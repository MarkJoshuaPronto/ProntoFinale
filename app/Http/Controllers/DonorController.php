<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonationModel;
use App\Models\Donation;
use App\Models\CustomNotification;
use Illuminate\Support\Facades\Mail; // make sure this is on top



class DonorController extends Controller
{

    public function updateStatus(Request $request, Donation $donation)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,approved,rejected,claimed'
    ]);

    $donation->update(['status' => $request->status]);
    CustomNotification::create([
    'user_id' => $donation->user_id,
    'title' => 'Donation Approved',
    'message' => 'Your donation "' . $donation->category . '" has been approved by the admin.',
]);


    return back()->with('success', 'Donation status updated successfully');
}
      // Update donation
public function update(Request $request, Donation $donation)
{
    // Verify the donation belongs to the current user
    if ($donation->user_id !== auth()->id()) {
        return response()->json(['message' => 'Unauthorized action.'], 403);
    }

    // Only allow updating if status is pending
    if ($donation->status !== 'pending') {
        return response()->json(['message' => 'You can only update donations with pending status'], 403);
    }

    $validated = $request->validate([
        'wearable_type' => 'nullable|string',
        'size' => 'nullable|string',
        'quantity' => 'required|integer|min:1',
        'condition' => 'required|string',
        'available_date' => 'required|date',
        'notes' => 'nullable|string'
    ]);

    $donation->update($validated);

    return response()->json(['success' => 'Donation updated successfully!']);
}

// Delete donation
public function destroy(Donation $donation)
{
    // Verify the donation belongs to the current user
    if ($donation->user_id !== auth()->id()) {
        return response()->json(['message' => 'Unauthorized action.'], 403);
    }

    // Only allow deleting if status is pending
    if ($donation->status !== 'pending') {
        return response()->json(['message' => 'You can only delete donations with pending status'], 403);
    }

    $donation->delete();
    return response()->json(['success' => 'Donation deleted successfully!']);
}
    public function show(Donation $donation)
{
    return response()->json($donation);
}

public function store_donation(Request $request)
{
    $validated = $request->validate([
        'category' => 'required|string',
        'subcategory' => 'required|string',
        'quantity' => 'required|integer',
        'unit' => 'required|string',
        'condition' => 'required|string',
        'available_date' => 'required|date',
        'notes' => 'nullable|string',
        'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        'item_description' => 'nullable|string',
        'accessories_included' => 'nullable|string',
        'tested_functionality' => 'nullable|string',
        'expiration_date' => 'nullable|date',
        'data_privacy_agreement' => 'sometimes|boolean'
    ]);

    // Handle file uploads
    $photoPaths = [];
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            $photoPaths[] = $photo->store('donation_photo', 'public');
        }
    }

    // Handle anonymous name
    $fullName = $request->is_anonymous ? $this->convertToAnonymous($request->full_name) : $request->full_name;

    // Save donation
    $donation = Donation::create([
        'user_id' => auth()->id(),
        'full_name' => $fullName,
        'contact_number' => $request->contact_number,
        'location' => $request->location,
        'category' => $request->category,
        'subcategory' => $request->subcategory,
        'wearable_type' => $request->wearable_type,
        'size' => $request->size,
        'quantity' => $request->quantity,
        'unit' => $request->unit, // NEW
        'available_quantity' => $request->quantity,
        'condition' => $request->condition,
        'notes' => $request->notes,
        'specific_items' => $request->specific_items,
        'item_description' => $request->item_description, // NEW
        'accessories_included' => $request->accessories_included, // NEW
        'tested_functionality' => $request->tested_functionality, // NEW
        'data_privacy_agreement' => $request->has('data_privacy_agreement'), // NEW
        'expiration_date' => $request->expiration_date, // NEW
        'is_anonymous' => $request->has('is_anonymous'), // NEW
        'available_date' => $request->available_date,
        'donation_photo' => !empty($photoPaths) ? json_encode($photoPaths) : null
    ]);

    // Send email notification
    $subject = 'New Donation Submitted';
    $body = "
        A new donation has been submitted.\n\n
        Full Name: {$fullName}
        Contact Number: {$request->contact_number}
        Location: {$request->location}
        Category: {$request->category}
        Subcategory: {$request->subcategory}
        Item Description: " . ($request->item_description ?? 'N/A') . "
        Quantity: {$request->quantity} {$request->unit}
        Condition: {$request->condition}
        Available Date: {$request->available_date}
        Notes: " . ($request->notes ?? 'N/A') . "
        Specific Items: " . ($request->specific_items ?? 'N/A') . "
        Anonymous: " . ($request->has('is_anonymous') ? 'Yes' : 'No') . "
    ";

    Mail::raw($body, function ($message) use ($subject) {
        $message->to('cycleofgiving2025@gmail.com')
                ->subject($subject);
    });

    return redirect()->route('donationuser')->with('success', 'Donation submitted successfully and email notification sent!');
}

// Helper function for anonymous names
private function convertToAnonymous($fullName)
{
    return preg_replace_callback('/\b\w+/', function($matches) {
        $word = $matches[0];
        if (strlen($word) <= 1) return $word;
        return $word[0] . str_repeat('*', strlen($word) - 1);
    }, $fullName);
}
}
