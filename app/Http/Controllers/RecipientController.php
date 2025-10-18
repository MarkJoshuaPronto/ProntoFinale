<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\RecipientRequest;
use App\Models\GalleryModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class RecipientController extends Controller
{
    public function show_request()
    {
        $auth = Auth::user();
        $recipientcount = RecipientRequest::where('user_id', auth()->id())->count();
        $requests = RecipientRequest::where('user_id', auth()->id())->get();
        return view('recipient.request', compact('auth', 'requests', 'recipientcount'));
    }

    public function landingpagerecipient()
    {
        $auth = Auth::user();
        return view('recipient.landingpage.landingpagerecipient', compact('auth'));
    }

    public function aboutuspagerecipient()
    {
        $auth = Auth::user();
        return view('recipient.aboutuspage.aboutuspagerecipient', compact('auth'));
    }

    public function gallerypagerecipient()
    {
        $auth = Auth::user();
        $gallery = GalleryModel::all();
        return view('recipient.gallery.gallerypagerecipient',compact('auth','gallery'));
    }

    // Renamed from 'editRequest' to 'edit' to align with Laravel resource naming.
    public function edit($id)
    {
        $request = RecipientRequest::findOrFail($id);

        // Check if the authenticated user owns this request and if its status is 'pending'
        if ($request->user_id !== auth()->id() || $request->status !== 'pending') {
            return response()->json(['error' => 'Could not fetch request data. The request is not editable.'], 403);
        }

        return response()->json($request);
    }

    // The 'updateStatus' method appears to be for an admin action. We'll leave it as is.
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $recipientRequest = RecipientRequest::findOrFail($id);

        $recipientRequest->status = $request->status;
        $recipientRequest->save();

        return redirect()->back()->with('success', 'Request has been ' . $request->status . ' successfully!');
    }

    // The 'store_request' method is correct for creating a new request.
 public function store_request(Request $request)
{
    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'category' => 'required|string|max:50',
        'subcategory' => 'required|string|max:50',
        'wearable_type' => 'nullable|string|max:100',
        'size' => 'nullable|string|max:20',
        'quantity' => 'required|integer|min:1',
        'unit' => 'required|string|max:20',
        'description' => 'required|string',
        'urgency' => 'required|in:asap,within_week,within_month,flexible',
        'condition' => 'required|string|max:100',
        
        // New fields for additional categories
        'specific_items' => 'nullable|string|max:255',
        'item_description' => 'nullable|string|max:255',
        'accessories_included' => 'nullable|string|max:255',
        'functionality_requirement' => 'nullable|string|max:100',
        'expiration_preference' => 'nullable|string|max:100',
    ]);

    // Prepare data for database
    $requestData = [
        'user_id' => auth()->id(),
        'full_name' => $validated['full_name'],
        'contact_number' => $validated['contact_number'],
        'address' => $validated['address'],
        'category' => $validated['category'],
        'subcategory' => $validated['subcategory'],
        'wearable_type' => $validated['wearable_type'] ?? null,
        'size' => $validated['size'] ?? null,
        'quantity' => $validated['quantity'],
        'unit' => $validated['unit'],
        'remaining_quantity' => $validated['quantity'], // Initially same as requested quantity
        'condition' => $validated['condition'],
        'description' => $validated['description'],
        'urgency' => $validated['urgency'],
        'status' => 'pending',
        
        // New fields
        'specific_items' => $validated['specific_items'] ?? null,
        'item_description' => $validated['item_description'] ?? null,
        'accessories_included' => $validated['accessories_included'] ?? null,
        'functionality_requirement' => $validated['functionality_requirement'] ?? null,
        'expiration_preference' => $validated['expiration_preference'] ?? null,
    ];

    // Save to DB
    RecipientRequest::create($requestData);

    // Build email content
    $subject = 'New Request Received';
    $body = "
        A new request has been submitted.\n\n
        Personal Information:
        Full Name: {$requestData['full_name']}
        Contact Number: {$requestData['contact_number']}
        Address: {$requestData['address']}
        
        Request Details:
        Category: {$requestData['category']}
        Subcategory: {$requestData['subcategory']}
        Quantity: {$requestData['quantity']} {$requestData['unit']}
        Condition Required: {$requestData['condition']}
        Urgency: {$requestData['urgency']}
        
        Additional Details:
        " . ($requestData['wearable_type'] ? "Wearable Type: {$requestData['wearable_type']}\n" : "") .
        ($requestData['size'] ? "Size: {$requestData['size']}\n" : "") .
        ($requestData['specific_items'] ? "Specific Items: {$requestData['specific_items']}\n" : "") .
        ($requestData['item_description'] ? "Item Description: {$requestData['item_description']}\n" : "") .
        ($requestData['accessories_included'] ? "Required Accessories: {$requestData['accessories_included']}\n" : "") .
        ($requestData['functionality_requirement'] ? "Functionality Requirement: {$requestData['functionality_requirement']}\n" : "") .
        ($requestData['expiration_preference'] ? "Expiration Preference: {$requestData['expiration_preference']}\n" : "") . "
        
        Description/Reason:
        {$requestData['description']}
    ";

    // Send email directly
    Mail::raw($body, function ($message) use ($subject) {
        $message->to('cycleofgiving2025@gmail.com')
                ->subject($subject);
    });

    return redirect()->back()->with('success', 'Request submitted successfully and email notification sent!');
}


    // The 'updateRequest' method is correct for updating a request.
    public function update(Request $request, $id)
    {
        $recipientRequest = RecipientRequest::findOrFail($id);

        // Check if the authenticated user owns this request
        if ($recipientRequest->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string|max:500',
            'urgency' => 'required|in:asap,within_week,within_month,flexible,specific',
            'specific_date' => 'nullable|required_if:urgency,specific|date|after:today'
        ]);

        $recipientRequest->update($validated);

        return redirect()->back()->with('success', 'Request updated successfully!');
    }

    // Renamed from 'deleteRequest' to 'destroy' to align with Laravel resource naming.
    public function delete_request($id)
    {
        $request = RecipientRequest::findOrFail($id);

        // Check if the authenticated user owns this request
        if ($request->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->delete();

        return redirect()->back()->with('success', 'Request deleted successfully!');
    }
}
