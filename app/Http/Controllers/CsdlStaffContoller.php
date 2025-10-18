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
use App\Model\DonationModel;


class CsdlStaffContoller extends Controller
{
    public function donorInventory()
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
    
    return view('csdl_staff.inventory', compact('donations', 'auth', 'date', 'users', 'usercount', 'alldonators', 'totaldonation', 'topdonator', 'newrecord', 'newservice', 'newdonation'));
}

 public function donorInventory2()
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
    
    return view('monitoring_staff.inventory', compact('donations', 'auth', 'date', 'users', 'usercount', 'alldonators', 'totaldonation', 'topdonator', 'newrecord', 'newservice', 'newdonation'));
}

public function staffdonation()
{
    $newrecord = User::whereDate('created_at', today())
        ->where('role', 'donor')
        ->count();
    $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
    $newdonation = Donation::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
    $auth = Auth::user();
    $totaldonation = Donation::where('status','accepted')->count();
    $date = Carbon::now();
    $users = User::where('role','donor')->get();
    $usercount = User::where('role','donor')->count();

    // Changed to show all donations regardless of status
    $donations = Donation::with('user')->get();

    $topdonator = Donation::with('user')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();

    return view('csdl_staff.incoming_donation', compact(
        'auth',
        'date',
        'users',
        'usercount',
        'donations',
        'totaldonation',
        'topdonator',
        'newrecord',
        'newservice',
        'newdonation'
    ));
}

public function staffdonation2()
{
    $newrecord = User::whereDate('created_at', today())
        ->where('role', 'donor')
        ->count();
    $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
    $newdonation = Donation::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
    $auth = Auth::user();
    $totaldonation = Donation::where('status','accepted')->count();
    $date = Carbon::now();
    $users = User::where('role','donor')->get();
    $usercount = User::where('role','donor')->count();

    // Changed to show all donations regardless of status
    $donations = Donation::with('user')->get();

    $topdonator = Donation::with('user')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();

    return view('monitoring_staff.incoming_donation', compact(
        'auth',
        'date',
        'users',
        'usercount',
        'donations',
        'totaldonation',
        'topdonator',
        'newrecord',
        'newservice',
        'newdonation'
    ));
}

  public function showStaffRequests()
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
        return view('csdl_staff.recipient_request', compact('requests', 'auth', 'date', 'users', 'usercount', 'alldonators', 'totaldonation', 'topdonator', 'newrecord', 'newservice', 'newdonation'));
    }
}
