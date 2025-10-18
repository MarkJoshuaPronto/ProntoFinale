<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Donation;
use App\Models\RecipientRequest;
use Illuminate\Support\Facades\Auth;
use App\Exports\ActiveUsersExport;
use App\Exports\DonationsExport;
use App\Models\GalleryModel;
use App\Models\InNeedsModel;
use App\Models\SupportModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DonationMatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestMatched;
use App\Mail\DonationMatched;
use Illuminate\Support\Facades\Log;
use App\Models\CustomNotification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;



class AdminController extends Controller
{

public function adminInventory()
{
    $donations = Donation::where('status', 'approved')
        ->where('available_quantity', '>', 0)
        ->orderBy('created_at', 'desc')
        ->get();
        $newrecord = User::whereDate('created_at', today())->where('role', 'donor')->count();
        $newservice = SupportModel::whereDate('created_at', today())->where('status', 'pending')->count();
        $newdonation = Donation::whereDate('created_at', today())->where('status', 'pending')->count();
        $auth = Auth::user();
        $totaldonation = Donation::where('status','accepted')->count();
        $date = Carbon::now();
        $users = User::where('role','donor')->get();
        $usercount = User::where('role','donor')->count();
        $alldonators = Donation::with('user')->where('status','pending')->get();
        $topdonator = Donation::with('user')
            ->selectRaw('user_id, count(*) as donation_count')
            ->where('status', 'accepted')
            ->groupBy('user_id')
            ->orderByDesc('donation_count')
            ->first();

        // This is the variable your table needs
        $requests = RecipientRequest::orderBy('created_at', 'desc')->get();
    
    return view('admin.inventory', compact('donations', 'auth', 'date', 'users', 'usercount', 'alldonators', 'totaldonation', 'topdonator', 'newrecord', 'newservice', 'newdonation'));
}




// NotificationController.php

public function show()
{
    // Get all notifications for display
    $notifications = CustomNotification::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

    // Count only unread notifications for the badge
    $unreadCount = CustomNotification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();

    return response()->json([
        'notifications' => $notifications,
        'unreadCount'   => $unreadCount
    ]);
}

public function markAsRead()
{
    // Mark all unread notifications as read
    CustomNotification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return response()->json(['success' => true]);
}

/**
 * Check if auto-matching is possible (if there are available donations)
 */
public function checkAutoMatchingAvailability()
{
    try {
        $approvedRequests = RecipientRequest::where('status', 'approved')->count();
        
        if ($approvedRequests === 0) {
            return response()->json([
                'available' => false,
                'message' => 'No approved requests available for matching'
            ]);
        }

        // Check if there are any available donations that could potentially match
        $availableDonations = Donation::whereIn('status', ['approved', 'accepted'])
            ->where('available_quantity', '>', 0)
            ->count();

        if ($availableDonations === 0) {
            return response()->json([
                'available' => false,
                'message' => 'No available donations found for matching'
            ]);
        }

        // Check if there are potential matches
        $potentialMatches = 0;
        $approvedRequests = RecipientRequest::where('status', 'approved')->get();
        
        foreach ($approvedRequests as $request) {
            $matchingDonations = Donation::whereIn('status', ['approved', 'accepted'])
                ->where('available_quantity', '>', 0)
                ->where('category', $request->category)
                ->where('subcategory', $request->subcategory)
                ->count();
                
            if ($matchingDonations > 0) {
                $potentialMatches++;
            }
        }

        if ($potentialMatches === 0) {
            return response()->json([
                'available' => false,
                'message' => 'No compatible donations found for any approved requests'
            ]);
        }

        // --- NOTIFY ADMIN EMAIL ABOUT AVAILABLE AUTO-MATCH ---
        try {
            Mail::send('emails.auto_match_available', [
                'approvedRequests' => $approvedRequests->count(),
                'availableDonations' => $availableDonations,
                'potentialMatches' => $potentialMatches,
                'checkTime' => now()->format('Y-m-d H:i:s')
            ], function ($message) {
                $message->to('cycleofgiving2025@gmail.com')
                        ->subject('Auto-Matching Available - Cycle of Giving');
            });
            Log::info("✓ Auto-match availability email sent to cycleofgiving2025@gmail.com");
        } catch (\Exception $e) {
            Log::error('Failed to send auto-match availability email: ' . $e->getMessage());
        }

        return response()->json([
            'available' => true,
            'message' => "Auto-matching available. {$potentialMatches} requests have potential matches.",
            'stats' => [
                'approved_requests' => $approvedRequests->count(),
                'available_donations' => $availableDonations,
                'potential_matches' => $potentialMatches
            ]
        ]);

    } catch (\Exception $e) {
        Log::error('Error checking auto-matching availability: ' . $e->getMessage());
        return response()->json([
            'available' => false,
            'message' => 'Error checking auto-matching availability'
        ]);
    }
}

public function exportDonations()
{
    try {
        Log::info('Export Donations method called');
        
        $donations = Donation::where('status', 'matched')
            ->with('user')
            ->get();

        Log::info('Donations count: ' . $donations->count());
        Log::info('Donations data: ', $donations->toArray());

        if ($donations->isEmpty()) {
            Log::warning('No approved donations found for export');
            return back()->with('error', 'No approved donations to export.');
        }

        $fileName = "accepted_donations_" . date('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($donations) {
            $file = fopen('php://output', 'w');
            
            // Add BOM to fix UTF-8 encoding issues in Excel
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // Headers
            fputcsv($file, [
                'ID',
                'Donor Name',
                'Email',
                'Category',
                'Subcategory',
                'Item Description',
                'Quantity',
                'Condition',
                'Location',
                'Available Date',
                'Status',
                'Created At'
            ]);

            // Data
            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->id,
                    $donation->user->name ?? 'N/A',
                    $donation->user->email ?? 'N/A',
                    $donation->category,
                    $donation->subcategory,
                    $donation->item_description ?? $donation->specific_items ?? 'N/A',
                    $donation->quantity,
                    $donation->condition,
                    $donation->location,
                    $donation->available_date,
                    $donation->status,
                    $donation->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($file);
        };

        Log::info('Returning CSV response');
        return response()->stream($callback, 200, $headers);
        
    } catch (\Exception $e) {
        Log::error('Export error: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        return back()->with('error', 'Error exporting donations: ' . $e->getMessage());
    }
}
public function runAutoMatching(Request $request)
{
    try {
        $approvedRequests = RecipientRequest::where('status', 'approved')->get();
        
        if ($approvedRequests->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No approved requests available for auto-matching.'
            ]);
        }

        $matchedCount = 0;
        $detailedResults = [];
        $totalMatches = 0;

        Log::info("=== STARTING AUTO-MATCHING ===");
        Log::info("Total approved requests: " . $approvedRequests->count());

        foreach ($approvedRequests as $req) {
            Log::info("Processing request ID: {$req->id} - {$req->category}/{$req->subcategory}");
            
            $result = $this->autoMatchRequest($req->id);
            
            if ($result) {
                $matchCount = count($result['matches']);
                $totalMatches += $matchCount;
                
                if ($matchCount > 0) {
                    $matchedCount++;
                    $detailedResults[] = [
                        'request_id' => $req->id,
                        'category' => $req->category,
                        'subcategory' => $req->subcategory,
                        'matches_found' => $matchCount,
                        'remaining_quantity' => $result['remaining_quantity'],
                        'status' => 'Matched'
                    ];
                    Log::info("✓ Request {$req->id}: {$matchCount} matches found");
                } else {
                    $detailedResults[] = [
                        'request_id' => $req->id,
                        'category' => $req->category,
                        'subcategory' => $req->subcategory,
                        'matches_found' => 0,
                        'remaining_quantity' => $result['remaining_quantity'],
                        'status' => 'No matches - Check donation availability/conditions'
                    ];
                    Log::info("✗ Request {$req->id}: No matches found");
                }
            }
        }

        Log::info("=== AUTO-MATCHING COMPLETED ===");
        Log::info("Matched {$matchedCount} out of {$approvedRequests->count()} requests");
        Log::info("Total matches made: {$totalMatches}");

        // Build detailed message
        if ($matchedCount > 0) {
            $message = "Auto-matching completed successfully! ";
            $message .= "Matched {$matchedCount} requests with {$totalMatches} total donations. ";
            
            if ($matchedCount < $approvedRequests->count()) {
                $unmatched = $approvedRequests->count() - $matchedCount;
                $message .= "{$unmatched} requests could not be matched due to donation availability or condition requirements.";
            }
        } else {
            $message = "Auto-matching completed but no matches were made. ";
            $message .= "This could be due to:";
            $message .= "<br>- No available donations matching the request categories";
            $message .= "<br>- Condition requirements not met";
            $message .= "<br>- Size or other compatibility issues";
            $message .= "<br>- All available donations already matched";
        }

        return response()->json([
            'success' => true,
            'matched' => $matchedCount > 0,
            'message' => $message,
            'details' => [
                'total_requests' => $approvedRequests->count(),
                'matched_requests' => $matchedCount,
                'total_matches' => $totalMatches,
                'results' => $detailedResults
            ]
        ]);

    } catch (\Exception $e) {
        Log::error('Error in runAutoMatching: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'An error occurred during auto-matching: ' . $e->getMessage()
        ], 500);
    }
}

public function autoMatchRequest($requestId)
{
    try {
        $request = RecipientRequest::findOrFail($requestId);

        if ($request->status !== 'approved') {
            Log::info("Request {$requestId} is not approved (status: {$request->status})");
            return false;
        }

        $remainingQuantity = $request->remaining_quantity ?? $request->quantity;
        
        if ($remainingQuantity <= 0) {
            Log::info("Request {$requestId} has no remaining quantity needed");
            return false;
        }

        Log::info("=== AUTO-MATCHING REQUEST {$requestId} ===");
        Log::info("Looking for: {$request->category}/{$request->subcategory}, Condition: {$request->condition}, Needed: {$remainingQuantity}");

        // Find matching donations
        $matchingDonations = Donation::whereIn('status', ['approved', 'accepted'])
            ->where('available_quantity', '>', 0)
            ->where('category', $request->category)
            ->where('subcategory', $request->subcategory)
            ->where(function($query) use ($request) {
                if ($request->condition && $request->condition !== 'Any') {
                    $query->where('condition', $request->condition)
                          ->orWhereNull('condition');
                }
            })
            ->orderBy('available_date', 'asc')
            ->get();

        Log::info("Found {$matchingDonations->count()} potential donations");

        if ($matchingDonations->count() === 0) {
            Log::info("No donations found for category: {$request->category}, subcategory: {$request->subcategory}");
            return [
                'matches' => [],
                'remaining_quantity' => $remainingQuantity,
                'reason' => 'No compatible donations found'
            ];
        }

        $compatibleDonations = $matchingDonations->filter(function($donation) use ($request) {
            return $this->isRelaxedCompatibleMatch($request, $donation);
        });

        Log::info("After compatibility check: {$compatibleDonations->count()} donations remain");

        if ($compatibleDonations->count() === 0) {
            Log::info("No donations passed compatibility check (condition/size requirements)");
            return [
                'matches' => [],
                'remaining_quantity' => $remainingQuantity,
                'reason' => 'No donations met compatibility requirements'
            ];
        }

        $matches = [];
        
        foreach ($compatibleDonations as $donation) {
            if ($remainingQuantity <= 0) break;

            $allocatedQuantity = min($remainingQuantity, $donation->available_quantity);

            Log::info("Matching with donation {$donation->id}: allocating {$allocatedQuantity} units");

            // Create match record
            $match = DonationMatch::create([
                'request_id' => $request->id,
                'donation_id' => $donation->id,
                'allocated_quantity' => $allocatedQuantity,
                'status' => 'approved'
            ]);

            // Update quantities
            $donation->available_quantity -= $allocatedQuantity;
            if ($donation->available_quantity == 0) {
                $donation->status = 'matched';
            }
            $donation->save();

            // --- EMAIL NOTIFICATIONS ---
            try {
                // Make sure relationships are loaded
                if (!$request->relationLoaded('user')) {
                    $request->load('user');
                }
                if (!$donation->relationLoaded('user')) {
                    $donation->load('user');
                }

                if ($request->user && $request->user->email) {
                    Mail::to($request->user->email)->send(
                        new RequestMatched($request, $donation)
                    );
                    Log::info("✓ Email sent to requester: {$request->user->email}");
                }

                if ($donation->user && $donation->user->email) {
                    Mail::to($donation->user->email)->send(
                        new DonationMatched($donation, $request)
                    );
                    Log::info("✓ Email sent to donor: {$donation->user->email}");
                }
            } catch (\Exception $e) {
                Log::error('Email notification failed: ' . $e->getMessage());
                // Don't stop the matching process if email fails
            }

            // --- CUSTOM NOTIFICATIONS ---
            try {
                CustomNotification::create([
                    'user_id' => $request->user_id,
                    'title'   => 'Request Matched',
                    'message' => 'Your request "' . $request->category . ' - ' . $request->subcategory . '" has been matched with a donor.',
                ]);

                CustomNotification::create([
                    'user_id' => $donation->user_id,
                    'title'   => 'Donation Matched',
                    'message' => 'Your donation "' . $donation->category . ' - ' . $donation->subcategory . '" has been matched with a recipient.',
                ]);
                
                Log::info("✓ Custom notifications created for both users");
            } catch (\Exception $e) {
                Log::error('Custom notification failed: ' . $e->getMessage());
                // Don't stop the matching process if notification fails
            }

            $remainingQuantity -= $allocatedQuantity;
            $matches[] = $match;

            Log::info("✓ Successfully matched donation {$donation->id}");
        }

        // Update request status
        if ($remainingQuantity == 0) {
            $request->status = 'matched';
        } elseif (count($matches) > 0) {
            $request->status = 'partially_matched';
        }

        $request->remaining_quantity = $remainingQuantity;
        $request->save();

        Log::info("Request {$requestId} completed: " . count($matches) . " matches, {$remainingQuantity} remaining");

        return [
            'matches' => $matches,
            'remaining_quantity' => $remainingQuantity,
            'reason' => count($matches) > 0 ? 'Success' : 'Insufficient donation quantities'
        ];

    } catch (\Exception $e) {
        Log::error("Auto-match error for request {$requestId}: " . $e->getMessage());
        Log::error($e->getTraceAsString());
        return false;
    }
}
/**
 * Relaxed compatibility check for auto-matching
 * Less strict than manual matching to allow more matches
 */
private function isRelaxedCompatibleMatch($request, $donation)
{
    // 1. Basic category and subcategory match (already filtered in query)
    
    // 2. Relaxed condition matching
    if ($request->condition && $request->condition !== 'Any') {
        // Allow some flexibility in condition matching
        $conditionMap = [
            'Brand New' => ['Brand New', 'Like New', 'Gently Used'],
            'Like New' => ['Like New', 'Brand New', 'Gently Used'],
            'Gently Used' => ['Gently Used', 'Like New', 'Used - Fair'],
            'Used - Fair' => ['Used - Fair', 'Gently Used', 'Used - Poor'],
            'Used - Poor' => ['Used - Poor', 'Used - Fair']
        ];
        
        if (isset($conditionMap[$request->condition])) {
            if (!in_array($donation->condition, $conditionMap[$request->condition])) {
                Log::info("Condition mismatch: Request={$request->condition}, Donation={$donation->condition}");
                return false;
            }
        } elseif ($request->condition !== $donation->condition) {
            Log::info("Condition mismatch: Request={$request->condition}, Donation={$donation->condition}");
            return false;
        }
    }

    // 3. Relaxed size matching for wearables
    if ($request->category === 'wearable' && $request->size && $donation->size) {
        if (!$this->areSizesRelaxedCompatible($request->size, $donation->size)) {
            Log::info("Size mismatch: Request={$request->size}, Donation={$donation->size}");
            return false;
        }
    }

    // 4. For auto-matching, skip complex compatibility checks
    // Allow matches based on basic category/subcategory/condition
    
    Log::info("Compatible match found: Request ID {$request->id}, Donation ID {$donation->id}");
    return true;
}

/**
 * Relaxed size compatibility for auto-matching
 */
private function areSizesRelaxedCompatible($requestSize, $donationSize)
{
    // If sizes are exactly the same
    if ($requestSize === $donationSize) {
        return true;
    }

    // More relaxed size ranges for auto-matching
    $relaxedSizeRanges = [
        'XS' => ['XS', 'S'],
        'S' => ['S', 'XS', 'M'],
        'M' => ['M', 'S', 'L'],
        'L' => ['L', 'M', 'XL'],
        'XL' => ['XL', 'L', 'XXL'],
        'XXL' => ['XXL', 'XL', 'L'],
    ];

    if (isset($relaxedSizeRanges[$requestSize])) {
        return in_array($donationSize, $relaxedSizeRanges[$requestSize]);
    }

    // For numeric sizes, allow more flexibility
    if (is_numeric($requestSize) && is_numeric($donationSize)) {
        $sizeDiff = abs((float)$requestSize - (float)$donationSize);
        return $sizeDiff <= 2; // Allow ±2 size difference for auto-matching
    }

    // If we can't determine compatibility, allow the match
    return true;
}
/**
 * Enhanced compatibility check for matching
 */
private function isCompatibleMatch($request, $donation)
{
    // 1. Check wearable type compatibility
    if ($request->category === 'wearable' && $request->wearable_type && $donation->wearable_type) {
        if ($request->wearable_type !== $donation->wearable_type) {
            return false;
        }
    }

    // 2. Check size compatibility for wearables
    if ($request->category === 'wearable' && $request->size && $donation->size) {
        if (!$this->areSizesCompatible($request->size, $donation->size)) {
            return false;
        }
    }

    // 3. Check specific items compatibility
    if ($request->specific_items && $donation->specific_items) {
        if (!$this->areItemsCompatible($request->specific_items, $donation->specific_items)) {
            return false;
        }
    }

    // 4. Check item description compatibility
    if ($request->item_description && $donation->item_description) {
        if (!$this->areDescriptionsCompatible($request->item_description, $donation->item_description)) {
            return false;
        }
    }

    // 5. Check technology-specific compatibility
    if ($request->category === 'technology') {
        if (!$this->isTechnologyCompatible($request, $donation)) {
            return false;
        }
    }

    // 6. Check expiration requirements for food/medical
    if (in_array($request->category, ['food', 'medical']) && $request->expiration_preference) {
        if (!$this->meetsExpirationRequirements($request, $donation)) {
            return false;
        }
    }

    return true;
}

/**
 * Check if units are compatible for matching
 */
private function areUnitsCompatible($requestUnit, $donationUnit)
{
    $compatibleUnits = [
        'pieces' => ['pieces', 'units', 'packs', 'sets'],
        'pairs' => ['pairs', 'pieces'],
        'sets' => ['sets', 'pieces'],
        'kg' => ['kg', 'grams'],
        'grams' => ['grams', 'kg'],
        'liters' => ['liters'],
        'packets' => ['packets', 'boxes', 'pieces'],
        'boxes' => ['boxes', 'packets'],
        'bottles' => ['bottles', 'pieces'],
        'tubes' => ['tubes', 'pieces'],
        'strips' => ['strips', 'pieces'],
        'kits' => ['kits', 'sets', 'pieces'],
    ];

    // If units are the same, always compatible
    if ($requestUnit === $donationUnit) {
        return true;
    }

    // Check if units are compatible
    if (isset($compatibleUnits[$requestUnit])) {
        return in_array($donationUnit, $compatibleUnits[$requestUnit]);
    }

    // Default to compatible if no specific rules
    return true;
}

/**
 * Calculate allocated quantity considering unit conversion
 */
private function calculateAllocatedQuantity($request, $donation, $remainingQuantity)
{
    $availableQuantity = $donation->available_quantity;
    
    // If no quantity needed or available, return 0
    if ($remainingQuantity <= 0 || $availableQuantity <= 0) {
        return 0;
    }
    
    // If units are the same, simple calculation
    if ($request->unit === $donation->unit) {
        return min($remainingQuantity, $availableQuantity);
    }

    // Handle unit conversions
    $convertedQuantity = $this->convertQuantity($remainingQuantity, $request->unit, $donation->unit);
    
    if ($convertedQuantity === null) {
        // If conversion not possible, try conservative matching
        return min($remainingQuantity, $availableQuantity);
    }

    $allocated = min($convertedQuantity, $availableQuantity);
    
    // Convert back to request units for verification
    $convertedBack = $this->convertQuantity($allocated, $donation->unit, $request->unit);
    
    return $convertedBack !== null ? $allocated : min($remainingQuantity, $availableQuantity);
}

/**
 * Convert quantity between different units
 */
private function convertQuantity($quantity, $fromUnit, $toUnit)
{
    $conversionRates = [
        'kg_to_grams' => 1000,
        'grams_to_kg' => 0.001,
    ];

    $conversionKey = $fromUnit . '_to_' . $toUnit;
    
    if (isset($conversionRates[$conversionKey])) {
        return $quantity * $conversionRates[$conversionKey];
    }

    // For other unit conversions, return null (no conversion)
    return null;
}

/**
 * Check size compatibility for wearables
 */
private function areSizesCompatible($requestSize, $donationSize)
{
    // If sizes are exactly the same
    if ($requestSize === $donationSize) {
        return true;
    }

    // Size range compatibility (you can expand this logic)
    $sizeRanges = [
        'XS' => ['XS'],
        'S' => ['S', 'XS'],
        'M' => ['M', 'S', 'L'],
        'L' => ['L', 'M', 'XL'],
        'XL' => ['XL', 'L', 'XXL'],
        'XXL' => ['XXL', 'XL'],
    ];

    if (isset($sizeRanges[$requestSize])) {
        return in_array($donationSize, $sizeRanges[$requestSize]);
    }

    // For numeric sizes (shoes), allow some flexibility
    if (is_numeric($requestSize) && is_numeric($donationSize)) {
        $sizeDiff = abs((float)$requestSize - (float)$donationSize);
        return $sizeDiff <= 1; // Allow ±1 size difference
    }

    return false;
}

/**
 * Check item compatibility
 */
private function areItemsCompatible($requestItems, $donationItems)
{
    $requestItemArray = array_map('strtolower', array_map('trim', explode(',', $requestItems)));
    $donationItemArray = array_map('strtolower', array_map('trim', explode(',', $donationItems)));

    // Check if any requested item matches donated items
    foreach ($requestItemArray as $requestItem) {
        foreach ($donationItemArray as $donationItem) {
            if (str_contains($donationItem, $requestItem) || str_contains($requestItem, $donationItem)) {
                return true;
            }
        }
    }

    return false;
}

/**
 * Check description compatibility
 */
private function areDescriptionsCompatible($requestDesc, $donationDesc)
{
    $requestWords = array_map('strtolower', str_word_count($requestDesc, 1));
    $donationWords = array_map('strtolower', str_word_count($donationDesc, 1));

    $commonWords = array_intersect($requestWords, $donationWords);
    
    // If there are at least 2 common significant words, consider compatible
    $significantWords = array_filter($commonWords, function($word) {
        return strlen($word) > 3 && !in_array($word, ['this', 'that', 'with', 'have', 'from']);
    });

    return count($significantWords) >= 2;
}

/**
 * Technology-specific compatibility check
 */
private function isTechnologyCompatible($request, $donation)
{
    // Check functionality requirements
    if ($request->functionality_requirement === 'fully_functional' && 
        $donation->condition !== 'Brand New' && 
        $donation->condition !== 'Gently Used (Fully Functional)') {
        return false;
    }

    // Check accessories
    if ($request->accessories_included && $donation->accessories_included) {
        $requestAccessories = array_map('strtolower', array_map('trim', explode(',', $request->accessories_included)));
        $donationAccessories = array_map('strtolower', array_map('trim', explode(',', $donation->accessories_included)));
        
        $missingAccessories = array_diff($requestAccessories, $donationAccessories);
        if (!empty($missingAccessories)) {
            return false;
        }
    }

    return true;
}

/**
 * Check expiration requirements
 */
private function meetsExpirationRequirements($request, $donation)
{
    if (!$donation->expiration_date) {
        return true; // No expiration date specified, assume it's okay
    }

    $expirationDate = \Carbon\Carbon::parse($donation->expiration_date);
    $today = \Carbon\Carbon::today();

    switch ($request->expiration_preference) {
        case '3_months':
            return $expirationDate->diffInMonths($today) >= 3;
        case '6_months':
            return $expirationDate->diffInMonths($today) >= 6;
        case '1_year':
            return $expirationDate->diffInYears($today) >= 1;
        default:
            return true;
    }
}

/**
 * Manual matching of request with donation
 */
public function matchRequest(Request $request)
{
    try {
        $validated = $request->validate([
            'request_id' => 'required|exists:recipient_requests,id',
            'donation_id' => 'required|exists:donations,id',
            'allocated_quantity' => 'required|integer|min:1'
        ]);

        Log::info("Manual matching started", $validated);

        $requestObj = RecipientRequest::findOrFail($validated['request_id']);
        $donation = Donation::findOrFail($validated['donation_id']);

        // Check if request can be matched
        $remainingQuantity = $requestObj->remaining_quantity ?? $requestObj->quantity;
        if ($remainingQuantity <= 0) {
            return response()->json([
                'message' => 'This request has no remaining quantity to match'
            ], 422);
        }

        // Check if donation is available
        if ($donation->available_quantity <= 0) {
            return response()->json([
                'message' => 'This donation is no longer available'
            ], 422);
        }

        // Check if allocated quantity is valid
        if ($validated['allocated_quantity'] > $donation->available_quantity) {
            return response()->json([
                'message' => "Cannot allocate more than available quantity ({$donation->available_quantity})"
            ], 422);
        }

        if ($validated['allocated_quantity'] > $remainingQuantity) {
            return response()->json([
                'message' => "Cannot allocate more than needed quantity ({$remainingQuantity})"
            ], 422);
        }

        // Create match record
        $match = DonationMatch::create([
            'request_id' => $validated['request_id'],
            'donation_id' => $validated['donation_id'],
            'allocated_quantity' => $validated['allocated_quantity'],
            'status' => 'approved'
        ]);

        Log::info("Match created", ['match_id' => $match->id]);

        // Update donation available quantity
        $donation->available_quantity -= $validated['allocated_quantity'];
        if ($donation->available_quantity == 0) {
            $donation->status = 'matched';
        }
        $donation->save();

        Log::info("Donation updated", [
            'donation_id' => $donation->id,
            'new_available_quantity' => $donation->available_quantity,
            'new_status' => $donation->status
        ]);

        // Update request status and remaining quantity
        $newRemainingQuantity = $remainingQuantity - $validated['allocated_quantity'];
        $requestObj->remaining_quantity = $newRemainingQuantity;

        if ($newRemainingQuantity == 0) {
            $requestObj->status = 'matched';
        } elseif ($requestObj->status == 'approved') {
            $requestObj->status = 'partially_matched';
        }

        $requestObj->save();

        Log::info("Request updated", [
            'request_id' => $requestObj->id,
            'new_remaining_quantity' => $requestObj->remaining_quantity,
            'new_status' => $requestObj->status
        ]);

        // Send email notifications
        try {
            if (!$requestObj->relationLoaded('user')) {
                $requestObj->load('user');
            }
            if (!$donation->relationLoaded('user')) {
                $donation->load('user');
            }

            if ($requestObj->user && $requestObj->user->email) {
                Mail::to($requestObj->user->email)->send(
                    new RequestMatched($requestObj, $donation)
                );
            }

            if ($donation->user && $donation->user->email) {
                Mail::to($donation->user->email)->send(
                    new DonationMatched($donation, $requestObj)
                );
            }
        } catch (\Exception $e) {
            Log::error('Email notification failed: ' . $e->getMessage());
        }

        // Create custom notifications
        CustomNotification::create([
            'user_id' => $requestObj->user_id,
            'title'   => 'Request Matched',
            'message' => 'Your request "' . $requestObj->category . ' - ' . $requestObj->subcategory . '" has been matched with a donor.',
        ]);

        CustomNotification::create([
            'user_id' => $donation->user_id,
            'title'   => 'Donation Matched',
            'message' => 'Your donation "' . $donation->category . ' - ' . $donation->subcategory . '" has been matched with a recipient.',
        ]);

        Log::info("Manual matching completed successfully");

        return response()->json([
            'success' => true,
            'message' => 'Request successfully matched with donation',
            'match' => $match,
            'remaining_quantity' => $newRemainingQuantity
        ]);

    } catch (\Exception $e) {
        Log::error('Error in matchRequest: ' . $e->getMessage());
        Log::error($e->getTraceAsString());
        
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while matching: ' . $e->getMessage()
        ], 500);
    }
}



// // Add this to your update status method
//     public function updateStatus(Request $request, $id)
//     {
//         $validated = $request->validate([
//             'status' => 'required|in:pending,approved,rejected,matched,fulfilled'
//         ]);

//         $recipientRequest = RecipientRequest::findOrFail($id);
//         $recipientRequest->status = $validated['status'];
//         $recipientRequest->status_updated_at = now();
//         $recipientRequest->save();

//         // If status is approved, attempt auto-matching
//         if ($validated['status'] === 'approved') {
//             $this->autoMatchRequest($id);
//         }

//         return redirect()->back()->with('success', 'Request status updated successfully');
//     }

// // public function matchRequest(Request $request)
// // {
// //     try {
// //         $validated = $request->validate([
// //             'request_id' => 'required|exists:recipient_requests,id',
// //             'donation_id' => 'required|exists:donations,id'
// //         ]);

// //         // Check if already matched
// //         $existingMatch = DonationMatch::where('request_id', $validated['request_id'])
// //             ->orWhere('donation_id', $validated['donation_id'])
// //             ->whereIn('status', ['pending', 'approved'])
// //             ->first();

// //         if ($existingMatch) {
// //             return response()->json([
// //                 'message' => 'This request or donation is already matched'
// //             ], 422);
// //         }

// //         // Create the match
// //         $match = DonationMatch::create([
// //             'request_id' => $validated['request_id'],
// //             'donation_id' => $validated['donation_id'],
// //             'status' => 'approved' // directly approve after confirmation
// //         ]);

// //         // Update request and donation statuses
// //         RecipientRequest::find($validated['request_id'])->update(['status' => 'matched']);
// //         Donation::find($validated['donation_id'])->update(['status' => 'matched']);

// //         // Send email notifications
// //         try {
// //             $recipientRequest = RecipientRequest::find($validated['request_id']);
// //             $donation = Donation::find($validated['donation_id']);

// //             Mail::to($recipientRequest->user->email)->send(new RequestMatched($recipientRequest, $donation));
// //             Mail::to($donation->user->email)->send(new DonationMatched($donation, $recipientRequest));
// //         } catch (\Exception $e) {
// //             Log::error('Email sending failed: ' . $e->getMessage());
// //         }

// //         return response()->json([
// //             'message' => 'Request successfully matched with donation',
// //             'match' => $match
// //         ]);

// //     } catch (\Exception $e) {
// //         Log::error('Error in matchRequest: ' . $e->getMessage());
// //         return response()->json([
// //             'message' => 'An error occurred: ' . $e->getMessage()
// //         ], 500);
// //     }
// // }

// In your RecipientRequestController or similar controller
// In your AdminController.php
// In your AdminController.php
public function getMatches($requestId)
{
    try {
        Log::info("Fetching matches for request ID: " . $requestId);

        // First check if the request exists
        $request = RecipientRequest::find($requestId);
        if (!$request) {
            Log::error("Request not found with ID: " . $requestId);
            return response()->json([
                'success' => false,
                'message' => 'Request not found'
            ], 404);
        }

        Log::info("Request found: " . json_encode($request->toArray()));

        // Now eager load the matches with donations
        $request = RecipientRequest::with(['matches' => function($query) {
            $query->with(['donation' => function($q) {
                $q->select('id', 'full_name', 'contact_number', 'email',
                          'location', 'address', 'category', 'subcategory',
                          'size', 'quantity', 'notes');
            }]);
        }])->findOrFail($requestId);

        Log::info("Loaded matches: " . json_encode($request->matches));

        // Transform the matches data for the response
        $formattedMatches = $request->matches->map(function($match) {
            return [
                'id' => $match->id,
                'allocated_quantity' => $match->allocated_quantity,
                'status' => $match->status,
                'created_at' => $match->created_at,
                'donation' => $match->donation ? [
                    'id' => $match->donation->id,
                    'full_name' => $match->donation->full_name,
                    'contact_number' => $match->donation->contact_number,
                    'email' => $match->donation->email,
                    'location' => $match->donation->location,
                    'address' => $match->donation->address,
                    'category' => $match->donation->category,
                    'subcategory' => $match->donation->subcategory,
                    'size' => $match->donation->size,
                    'quantity' => $match->donation->quantity,
                    'notes' => $match->donation->notes
                ] : null
            ];
        });

        return response()->json([
            'success' => true,
            'matches' => $formattedMatches,
            'request' => [
                'id' => $request->id,
                'full_name' => $request->full_name,
                'contact_number' => $request->contact_number,
                'address' => $request->address
            ]
        ]);

    } catch (\Exception $e) {
        Log::error("Error loading matches: " . $e->getMessage());
        Log::error("Stack trace: " . $e->getTraceAsString());
        return response()->json([
            'success' => false,
            'message' => 'Error loading matches: ' . $e->getMessage()
        ], 500);
    }
}


public function getMatchingDonations(Request $request)
{
    $category = $request->input('category');
    $subcategory = $request->input('subcategory');
    $requestId = $request->input('request_id');

    // Get the request to check remaining quantity
    $recipientRequest = RecipientRequest::find($requestId);
    $remainingQuantity = $recipientRequest ? ($recipientRequest->remaining_quantity ?? $recipientRequest->quantity) : 0;

    $donations = Donation::whereIn('status', ['approved', 'accepted']) // FIXED: Both statuses
        ->where('available_quantity', '>', 0)
        ->where(function($query) use ($category, $subcategory) {
            $query->whereRaw('LOWER(category) = ?', [strtolower($category)])
                ->whereRaw('LOWER(subcategory) = ?', [strtolower($subcategory)]);
        })
        ->with('user')
        ->get();

    return response()->json($donations);
}

    public function getMatchDetails($matchId)
    {
        $match = DonationMatch::with(['request.user', 'donation.user'])->findOrFail($matchId);
        return response()->json($match);
    }


    public function showRecipientRequests()
    {
        // Fetch all the required data
        $newrecord = User::whereDate('created_at', today())->where('role', 'donor')->count();
        $newservice = SupportModel::whereDate('created_at', today())->where('status', 'pending')->count();
        $newdonation = Donation::whereDate('created_at', today())->where('status', 'pending')->count();
        $auth = Auth::user();
        $totaldonation = Donation::where('status','accepted')->count();
        $date = Carbon::now();
        $users = User::where('role','donor')->get();
        $usercount = User::where('role','donor')->count();
        $alldonators = Donation::with('user')->where('status','pending')->get();
        $topdonator = Donation::with('user')
            ->selectRaw('user_id, count(*) as donation_count')
            ->where('status', 'accepted')
            ->groupBy('user_id')
            ->orderByDesc('donation_count')
            ->first();

        // This is the variable your table needs
        $requests = RecipientRequest::orderBy('created_at', 'desc')->get();

        // Return the view with all the data
        return view('admin.request_recipient', compact('requests', 'auth', 'date', 'users', 'usercount', 'alldonators', 'totaldonation', 'topdonator', 'newrecord', 'newservice', 'newdonation'));
    }

    public function showRequest($id)
    {
        $request = RecipientRequest::findOrFail($id);
        return response()->json($request);
    }

    public function updateStatus(Request $request, $id)
    {
        $recipientRequest = RecipientRequest::findOrFail($id);
        $recipientRequest->update([
            'status' => $request->status,
            'status_updated_at' => now()
        ]);
        CustomNotification::create([
        'user_id' => $recipientRequest->user_id,
        'title' => 'Donation Approved',
        'message' => 'Your donation "' . $recipientRequest->category . '" has been approved by the admin.',
        ]);


        return back()->with('success', 'Request status updated successfully');
    }



    public function viewRequestDetails($id)
    {
        $request = RecipientRequest::with('user')->findOrFail($id);
        return view('admin.request-details', compact('request'));
    }

    public function findMatchingRequests(Request $request)
    {
        $query = RecipientRequest::where('status', 'approved')
            ->whereNull('donation_id')
            ->with('user');

        // Filter by category
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // Filter by subcategory if provided
        if ($request->subcategory) {
            $query->where('subcategory', $request->subcategory);
        }

        // Filter by size if provided
        if ($request->size) {
            $query->where('size', $request->size);
        }

        // Filter by quantity (requests with equal or less quantity)
        if ($request->quantity) {
            $query->where('quantity', '<=', $request->quantity);
        }

        $requests = $query->get();

        // Get the donation details
        $donation = Donation::with('user')->find($request->donation_id);

        return response()->json([
            'requests' => $requests,
            'donation' => $donation
        ]);
    }
    public function findMatchingDonations(Request $request)
    {
        $query = Donation::whereIn('status', ['accepted', 'available'])
            ->whereNull('recipient_request_id')
            ->with('user');

        // Filter by category
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // Filter by subcategory if provided
        if ($request->subcategory) {
            $query->where('subcategory', $request->subcategory);
        }

        // Filter by size if provided
        if ($request->size) {
            $query->where('size', $request->size);
        }

        // Filter by quantity (donations with equal or more quantity)
        if ($request->quantity) {
            $query->where('quantity', '>=', $request->quantity);
        }

        $donations = $query->get();

        // Get the request details if request_id was provided
        $recipientRequest = null;
        if ($request->request_id) {
            $recipientRequest = RecipientRequest::find($request->request_id);
        }

        return response()->json([
            'donations' => $donations,
            'request' => $recipientRequest
        ]);
    }

    public function connectDonation(Request $request)
    {
        $validated = $request->validate([
            'request_id' => 'required|exists:recipient_requests,id',
            'donation_id' => 'required|exists:donations,id'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Update the donation
                $donation = Donation::find($validated['donation_id']);
                $donation->update([
                    'recipient_request_id' => $validated['request_id'],
                    'status' => 'fulfilled'
                ]);

                // Update the request
                $recipientRequest = RecipientRequest::find($validated['request_id']);
                $recipientRequest->update([
                    'donation_id' => $validated['donation_id'],
                    'status' => 'fulfilled'
                ]);

                // You might want to add notifications here
            });

            return response()->json(['message' => 'Donation connected successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to connect donation'], 500);
        }
    }

    public function updateRequestStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $recipientRequest = RecipientRequest::findOrFail($id);
        $recipientRequest->update(['status' => $validated['status']]);

        return back()->with('success', 'Request status updated successfully');
    }


    public function showmatch()
    {
        $newrecord = User::whereDate('created_at', today())
            ->where('role', 'donor')
            ->count();
        $newservice = SupportModel::whereDate('created_at', today())
            ->where('status', 'pending')
            ->count();
        $newdonation = Donation::whereDate('created_at', today())
            ->where('status', 'approved')
            ->count();
        $auth = Auth::user();
        $totaldonation = Donation::where('status','accepted')->count();
        $date = Carbon::now();
        $users = User::where('role','donor')->get();
        $usercount = User::where('role','donor')->count();
        $alldonators = Donation::with('user')->whereIn('status', ['accepted', 'available'])->get();
        $topdonator = Donation::with('user')
            ->selectRaw('user_id, count(*) as donation_count')
            ->where('status', 'accepted')
            ->groupBy('user_id')
            ->orderByDesc('donation_count')
            ->first();
        $requests = RecipientRequest::with('matches.donation')->orderBy('created_at', 'desc')->get();

        return view('admin.matching_donation', compact('requests', 'auth', 'date','users','usercount','alldonators','totaldonation','topdonator','newrecord','newservice','newdonation'));
    }

    
    public function staffshowmatch()
    {
        $newrecord = User::whereDate('created_at', today())
            ->where('role', 'donor')
            ->count();
        $newservice = SupportModel::whereDate('created_at', today())
            ->where('status', 'pending')
            ->count();
        $newdonation = Donation::whereDate('created_at', today())
            ->where('status', 'approved')
            ->count();
        $auth = Auth::user();
        $totaldonation = Donation::where('status','accepted')->count();
        $date = Carbon::now();
        $users = User::where('role','donor')->get();
        $usercount = User::where('role','donor')->count();
        $alldonators = Donation::with('user')->whereIn('status', ['accepted', 'available'])->get();
        $topdonator = Donation::with('user')
            ->selectRaw('user_id, count(*) as donation_count')
            ->where('status', 'accepted')
            ->groupBy('user_id')
            ->orderByDesc('donation_count')
            ->first();
        $requests = RecipientRequest::with('matches.donation')->orderBy('created_at', 'desc')->get();

        return view('it_staff.donation_matching', compact('requests', 'auth', 'date','users','usercount','alldonators','totaldonation','topdonator','newrecord','newservice','newdonation'));
    }

    public function showRequestDetails($id)
    {
        $request = RecipientRequest::with('matches.donation')->findOrFail($id);
        return view('admin.partials.request_details', compact('request'));
    }

     public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

      public function staffManagement()
    {
        // Get all staff users (excluding admin, donor, recipient)
        $staffUsers = User::whereIn('role', ['csdl_staff', 'it_staff', 'monitoring_staff'])
            ->orderBy('created_at', 'desc')
            ->get();
            $donations = Donation::where('status', 'approved')
        ->where('available_quantity', '>', 0)
        ->orderBy('created_at', 'desc')
        ->get();
        $newrecord = User::whereDate('created_at', today())->where('role', 'donor')->count();
        $newservice = SupportModel::whereDate('created_at', today())->where('status', 'pending')->count();
        $newdonation = Donation::whereDate('created_at', today())->where('status', 'pending')->count();
        $auth = Auth::user();
        $totaldonation = Donation::where('status','accepted')->count();
        $date = Carbon::now();
        $users = User::where('role','donor')->get();
        $usercount = User::where('role','donor')->count();
        $alldonators = Donation::with('user')->where('status','pending')->get();
        $topdonator = Donation::with('user')
            ->selectRaw('user_id, count(*) as donation_count')
            ->where('status', 'accepted')
            ->groupBy('user_id')
            ->orderByDesc('donation_count')
            ->first();

        // This is the variable your table needs
        $requests = RecipientRequest::orderBy('created_at', 'desc')->get();

        return view('admin.staff_management', compact('staffUsers','donations', 'auth', 'date', 'users', 'usercount', 'alldonators', 'totaldonation', 'topdonator', 'newrecord', 'newservice', 'newdonation'));
    }

    /**
     * Add new staff member
     */
    public function addStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'required|string|max:500',
            'age' => 'required|integer|min:18',
            'gender' => 'required|in:male,female,others',
            'role' => 'required|in:csdl_staff,it_staff,monitoring_staff',
            'contact' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('user_images', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
            'role' => $request->role,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
            'image' => $imagePath,
            'account_status' => 'active',
        ]);

        return redirect()->route('staff-management')->with('success', 'Staff member added successfully!');
    }

    /**
     * Update staff account status
     */
    public function updateStaffStatus(Request $request, $id)
    {
        $request->validate([
            'account_status' => 'required|in:active,inactive'
        ]);

        $user = User::findOrFail($id);
        
        // Ensure we're only updating staff accounts
        if (in_array($user->role, ['csdl_staff', 'it_staff', 'monitoring_staff'])) {
            $user->update([
                'account_status' => $request->account_status
            ]);

            return redirect()->back()->with('success', 'Staff account status updated successfully!');
        }

        return redirect()->back()->with('error', 'Invalid staff account!');
    }

    /**
     * Delete staff member
     */
    public function deleteStaff($id)
    {
        $user = User::findOrFail($id);
        
        // Ensure we're only deleting staff accounts
        if (in_array($user->role, ['csdl_staff', 'it_staff', 'monitoring_staff'])) {
            // Delete user image if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            
            $user->delete();

            return redirect()->back()->with('success', 'Staff member deleted successfully!');
        }

        return redirect()->back()->with('error', 'Invalid staff account!');
    }
}
