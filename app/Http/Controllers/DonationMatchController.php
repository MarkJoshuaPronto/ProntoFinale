<?php

namespace App\Http\Controllers;

use App\Models\DonationMatch;
use App\Models\RecipientRequest;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationMatched;
use App\Mail\RequestMatched;
use Illuminate\Support\Facades\Log;


class DonationMatchController extends Controller
{
public function getMatchingDonations(Request $request)
{
    $category = $request->input('category');
    $subcategory = $request->input('subcategory');
    
    $donations = Donation::where('status', 'approved')
        ->where(function($query) use ($category, $subcategory) {
            $query->whereRaw('LOWER(category) = ?', [strtolower($category)])
                  ->whereRaw('LOWER(subcategory) = ?', [strtolower($subcategory)]);
        })
        ->with('user')
        ->get();

    return response()->json($donations);
}


public function matchRequest(Request $request)
{
    $validated = $request->validate([
        'request_id' => 'required|exists:recipient_requests,id',
        'donation_id' => 'required|exists:donations,id'
    ]);

    // Check if already matched
    $existingMatch = DonationMatch::where('request_id', $validated['request_id'])
        ->orWhere('donation_id', $validated['donation_id'])
        ->whereIn('status', ['pending', 'confirmed'])
        ->first();

    if ($existingMatch) {
        return response()->json([
            'message' => 'This request or donation is already matched'
        ], 422);
    }

    // Create the match
    $match = DonationMatch::create([
        'request_id' => $validated['request_id'],
        'donation_id' => $validated['donation_id'],
        'status' => 'pending'
    ]);

    // Get request and donation models
    $recipientRequest = RecipientRequest::find($validated['request_id']);
    $donation = Donation::find($validated['donation_id']);
    
    // Update statuses
    $recipientRequest->update(['status' => 'matched']);
    $donation->update(['status' => 'matched']);

    // --- EMAIL NOTIFICATIONS ---
    Mail::to($recipientRequest->user->email)->send(
        new RequestMatched($recipientRequest, $donation)
    );

    Mail::to($donation->user->email)->send(
        new DonationMatched($donation, $recipientRequest)
    );

    // --- CUSTOM NOTIFICATIONS ---
    // Recipient Notification
    CustomNotification::create([
        'user_id' => $recipientRequest->user_id,
        'title'   => 'Request Matched',
        'message' => 'Your request "' . $recipientRequest->category . '" has been matched with a donor.',
    ]);

    // Donor Notification
    CustomNotification::create([
        'user_id' => $donation->user_id,
        'title'   => 'Donation Matched',
        'message' => 'Your donation "' . $donation->category . '" has been matched with a recipient.',
    ]);

    return response()->json([
        'message' => 'Request successfully matched with donation',
        'match'   => $match
    ]);
}


    public function getMatchDetails($matchId)
    {
        $match = DonationMatch::with(['request.user', 'donation.user'])->findOrFail($matchId);
        return response()->json($match);
    }
}