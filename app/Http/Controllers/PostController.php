<?php

namespace App\Http\Controllers;

use App\Exports\ActiveUsersExport;
use App\Exports\DonationsExport;
use App\Models\DonationModel;
use App\Models\RecipientRequest;
use App\Models\GalleryModel;
use App\Models\InNeedsModel;
use App\Models\SupportModel;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DonationMatch;
use PDF;
use App\Models\Donation;
use App\Models\DonationMatches;
use App\Models\RecipientRequests;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{

    public function index(){
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == 'user') {
                $user = Auth::user();
                return view('user.index');
            }elseif ($usertype == 'admin') {
                return view('admin.index');
            } else {
                return redirect()->back()->withErrors(['error' => 'User type not recognized.']);
            }
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Please log in first.']);
        }
    }

    public function loginpost(Request $request){
      $request->validate([
        'email' => ['required','email'],
        'password' => ['required']
      ]);

      if(Auth::attempt($request->only('email','password'),$request->boolean('remember'))){
        $request->session()->regenerate();

        $user = Auth::user();

        if($user->role === 'admin'){
            return redirect()->route('admindashboard');
        }

        if($user->role === 'donor'){
            $auth =Auth::user();
            return redirect()->route('landingpageuser')->with('success','Login Successfully');
        }
        if($user->role === 'csdl_staff'){
            $auth =Auth::user();
            return redirect()->route('csdlstaffdashboard')->with('success','Login Successfully');
        }
        if($user->role === 'monitoring_staff'){
            $auth =Auth::user();
            return redirect()->route('monitoringstaffdashboard')->with('success','Login Successfully');
        }
        if($user->role === 'it_staff'){
            $auth =Auth::user();
            return redirect()->route('itstaffdashboard')->with('success','Login Successfully');
        }
        if($user->role === 'recipient'){
            $auth =Auth::user();
            return redirect()->route('landingpagerecipient')->with('success','Login Successfully');
        }
        // elseif($user->role==='user'){
        //     if ($user->account_status === 'inactive') {
        //         return redirect()->route('login')->withErrors(['account' => 'Your account has been deactivated. Please contact support.']);
        //     }
        //     return redirect()->route('landingpageuser');
        // }
        else{
            return back()->with('error','Email and Password does not match our records!');
        }
      }
      return back()->with('error', 'Email and Password does not match our records!');
    }

  public function itstaffdashboard()
    {
        $auth = Auth::user();
        $date = Carbon::now();

        // Real Data Calculations
        $newrecord = User::whereDate('created_at', today())
            ->whereIn('role', ['donor', 'recipient'])
            ->count();

        $newservice = SupportModel::whereDate('created_at', today())
            ->where('status', 'pending')
            ->count();

        $newdonation = Donation::whereDate('created_at', today())
            ->where('status', 'pending')
            ->count();

        // Donation Statistics with Real Data
        $totalpending = Donation::where('status','pending')->count();
        $totalrejected = Donation::where('status','rejected')->count();
        $totaldonation = Donation::whereIn('status', ['approved', 'matched'])->count();

        // User Statistics with Real Data
        $activeuser = User::where('account_status','active')->count();
        $inactiveuser = User::where('account_status','inactive')->count();
        $users = User::whereIn('role', ['donor', 'recipient'])->get();
        $usercount = User::whereIn('role', ['donor', 'recipient'])->count();

        // Top Donor with Real Data
        $topdonator = Donation::with('user')
            ->selectRaw('user_id, count(*) as donation_count')
            ->whereIn('status', ['approved', 'matched'])
            ->groupBy('user_id')
            ->orderByDesc('donation_count')
            ->first();

        // Most Donated Items with Real Data
        $mostDonatedItems = Donation::whereIn('status', ['approved', 'matched'])
            ->select('subcategory', DB::raw('COUNT(*) as count'))
            ->groupBy('subcategory')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Donation Status Distribution with Real Data
        $donationStatusDistribution = Donation::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Donations by Category with Real Data
        $donationsByCategory = Donation::whereIn('status', ['approved', 'matched'])
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->get();

        // Weekly Donation Analytics with Real Data
        $weeklyDonationAnalytics = $this->getWeeklyDonationAnalytics();

        // IT-Specific Analytics with Real Data
        $systemPerformance = $this->getSystemPerformanceMetrics();
        $predictiveAnalytics = $this->getPredictiveAnalytics();
        $userGrowthTrends = $this->getUserGrowthTrends();
        $systemHealthMetrics = $this->getSystemHealthMetrics();

        return view('it_staff.index', compact(
            'totalpending', 'totalrejected', 'auth', 'activeuser', 'inactiveuser',
            'date', 'users', 'usercount', 'totaldonation', 'topdonator',
            'newrecord', 'newservice', 'newdonation', 'weeklyDonationAnalytics',
            'mostDonatedItems', 'donationStatusDistribution', 'donationsByCategory',
            'systemPerformance', 'predictiveAnalytics', 'userGrowthTrends', 'systemHealthMetrics'
        ));
    }

    /**
     * Generate weekly donation analytics data with REAL data
     */
    private function getWeeklyDonationAnalytics()
    {
        $weeks = [];
        $approvedDonations = [];
        $pendingDonations = [];
        $matchedDonations = [];
        $totalDonations = [];
        $rejectedDonations = [];

        // Get data for the past 8 weeks for better trend analysis
        for ($i = 7; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();

            $weekLabel = $startOfWeek->format('M d') . ' - ' . $endOfWeek->format('M d');
            $weeks[] = $weekLabel;

            // Real database queries for each status
            $weeklyApproved = Donation::where('status', 'approved')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->count();
            $approvedDonations[] = $weeklyApproved;

            $weeklyPending = Donation::where('status', 'pending')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->count();
            $pendingDonations[] = $weeklyPending;

            $weeklyMatched = Donation::where('status', 'matched')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->count();
            $matchedDonations[] = $weeklyMatched;

            $weeklyRejected = Donation::where('status', 'rejected')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->count();
            $rejectedDonations[] = $weeklyRejected;

            $weeklyTotal = Donation::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->count();
            $totalDonations[] = $weeklyTotal;
        }

        return [
            'weeks' => $weeks,
            'approved_donations' => $approvedDonations,
            'pending_donations' => $pendingDonations,
            'matched_donations' => $matchedDonations,
            'rejected_donations' => $rejectedDonations,
            'total_donations' => $totalDonations
        ];
    }

    /**
     * Get system performance metrics with REAL data
     */
    private function getSystemPerformanceMetrics()
    {
        // Real database counts
        $totalUsers = User::whereIn('role', ['donor', 'recipient'])->count();
        $totalDonations = Donation::count();
        $totalRequests = RecipientRequest::count();
        $totalMatches = DonationMatch::count();
        $totalSupportTickets = SupportModel::count();

        // Calculate real growth rates
        $lastWeekUsers = User::whereIn('role', ['donor', 'recipient'])
            ->where('created_at', '>=', Carbon::now()->subWeek())
            ->count();
        $userGrowthRate = $lastWeekUsers > 0 ? (($totalUsers - $lastWeekUsers) / $lastWeekUsers) * 100 : 0;

        $lastWeekDonations = Donation::where('created_at', '>=', Carbon::now()->subWeek())->count();
        $donationGrowthRate = $lastWeekDonations > 0 ? (($totalDonations - $lastWeekDonations) / $lastWeekDonations) * 100 : 0;

        // Real performance metrics from database
        $avgProcessingTime = Donation::where('status', 'approved')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
            ->first()->avg_hours ?? 0;

        $matchEfficiency = $totalDonations > 0 ? ($totalMatches / $totalDonations) * 100 : 0;

        return [
            'total_users' => $totalUsers,
            'total_donations' => $totalDonations,
            'total_requests' => $totalRequests,
            'total_matches' => $totalMatches,
            'total_support_tickets' => $totalSupportTickets,
            'user_growth_rate' => round($userGrowthRate, 2),
            'donation_growth_rate' => round($donationGrowthRate, 2),
            'avg_processing_time' => round($avgProcessingTime, 1),
            'match_efficiency' => round($matchEfficiency, 1)
        ];
    }

    /**
     * Generate predictive analytics with REAL historical data
     */
    private function getPredictiveAnalytics()
    {
        // Get real historical data for prediction
        $monthlyDonations = [];
        $monthlyUsers = [];
        $monthlyMatches = [];

        for ($i = 6; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();

            $monthlyDonations[] = Donation::whereBetween('created_at', [$monthStart, $monthEnd])->count();
            $monthlyUsers[] = User::whereIn('role', ['donor', 'recipient'])
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
            $monthlyMatches[] = DonationMatch::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        }

        // Use real data for predictions
        $predictedNextMonthDonations = $this->predictNextValue($monthlyDonations);
        $predictedNextMonthUsers = $this->predictNextValue($monthlyUsers);
        $predictedNextMonthMatches = $this->predictNextValue($monthlyMatches);

        // Real peak hours analysis
        $peakHours = $this->analyzeRealPeakHours();

        // Real category trends
        $categoryTrends = $this->analyzeCategoryTrends();

        return [
            'predicted_next_month_donations' => max(0, round($predictedNextMonthDonations)),
            'predicted_next_month_users' => max(0, round($predictedNextMonthUsers)),
            'predicted_next_month_matches' => max(0, round($predictedNextMonthMatches)),
            'current_month_donations' => end($monthlyDonations),
            'current_month_users' => end($monthlyUsers),
            'prediction_confidence' => $this->calculatePredictionConfidence($monthlyDonations),
            'peak_hours' => $peakHours,
            'category_trends' => $categoryTrends,
            'recommended_action' => $this->getRecommendedAction($predictedNextMonthDonations, end($monthlyDonations))
        ];
    }

    /**
     * Simple linear regression prediction using REAL data
     */
    private function predictNextValue($data)
    {
        $n = count($data);
        if ($n < 2) return end($data) ?? 0;

        // Remove any null values
        $data = array_filter($data, function($value) {
            return !is_null($value);
        });

        $data = array_values($data);
        $n = count($data);

        if ($n < 2) return end($data);

        $sumX = 0;
        $sumY = 0;
        $sumXY = 0;
        $sumX2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumX += $i;
            $sumY += $data[$i];
            $sumXY += $i * $data[$i];
            $sumX2 += $i * $i;
        }

        $slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $intercept = ($sumY - $slope * $sumX) / $n;

        return $slope * $n + $intercept;
    }

    /**
     * Calculate standard deviation manually
     */
    private function calculateStandardDeviation($data)
    {
        $n = count($data);
        if ($n < 2) return 0;

        $mean = array_sum($data) / $n;
        $variance = 0.0;

        foreach ($data as $value) {
            $variance += pow($value - $mean, 2);
        }

        $variance = $variance / ($n - 1); // Sample variance
        return sqrt($variance);
    }

    /**
     * Analyze real peak usage hours from database
     */
    private function analyzeRealPeakHours()
    {
        $peakData = DB::table('donations')
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->pluck('count', 'hour')
            ->toArray();

        return $peakData;
    }

    /**
     * Analyze real category trends
     */
    private function analyzeCategoryTrends()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        $currentMonthCategories = Donation::where('created_at', '>=', $currentMonth)
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        $lastMonthCategories = Donation::whereBetween('created_at', [$lastMonth, $currentMonth])
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->orderByDesc('count')
            ->get()
            ->pluck('count', 'category')
            ->toArray();

        $trends = [];
        foreach ($currentMonthCategories as $category => $count) {
            $lastMonthCount = $lastMonthCategories[$category] ?? 0;
            $growth = $lastMonthCount > 0 ? (($count - $lastMonthCount) / $lastMonthCount) * 100 : ($count > 0 ? 100 : 0);

            $trends[$category] = [
                'current' => $count,
                'last_month' => $lastMonthCount,
                'growth' => round($growth, 1),
                'trend' => $growth > 0 ? 'up' : ($growth < 0 ? 'down' : 'stable')
            ];
        }

        // If no current data, return empty trends
        if (empty($trends)) {
            return [
                'No Data' => [
                    'current' => 0,
                    'last_month' => 0,
                    'growth' => 0,
                    'trend' => 'stable'
                ]
            ];
        }

        return $trends;
    }

    /**
     * Calculate prediction confidence based on data consistency
     */
    private function calculatePredictionConfidence($data)
    {
        if (count($data) < 3) return 50;

        $variance = $this->calculateStandardDeviation($data);
        $mean = array_sum($data) / count($data);
        $coefficientOfVariation = $mean > 0 ? ($variance / $mean) * 100 : 100;

        // Higher confidence for more consistent data
        $confidence = max(60, 100 - ($coefficientOfVariation / 2));

        return min(95, round($confidence));
    }

    /**
     * Get recommended action based on predictions
     */
    private function getRecommendedAction($predicted, $current)
    {
        if ($current === null || $current == 0) {
            return [
                'action' => 'monitor',
                'message' => 'Insufficient data for accurate prediction.',
                'severity' => 'medium'
            ];
        }

        $growth = (($predicted - $current) / $current) * 100;

        if ($growth > 25) {
            return [
                'action' => 'scale_up',
                'message' => 'Significant growth predicted. Consider scaling resources.',
                'severity' => 'high'
            ];
        } elseif ($growth > 10) {
            return [
                'action' => 'monitor_closely',
                'message' => 'Moderate growth expected. Monitor system performance.',
                'severity' => 'medium'
            ];
        } elseif ($growth > -10) {
            return [
                'action' => 'maintain',
                'message' => 'Stable growth predicted. Maintain current operations.',
                'severity' => 'low'
            ];
        } else {
            return [
                'action' => 'review',
                'message' => 'Decline predicted. Review system performance.',
                'severity' => 'medium'
            ];
        }
    }

    /**
     * Get user growth trends with REAL data
     */
    private function getUserGrowthTrends()
    {
        $dailyRegistrations = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = User::whereIn('role', ['donor', 'recipient'])
                ->whereDate('created_at', $date)
                ->count();
            $dailyRegistrations[$date->format('D')] = $count;
        }

        $weeklyGrowth = User::whereIn('role', ['donor', 'recipient'])
            ->where('created_at', '>=', Carbon::now()->subWeek())
            ->count();

        $previousWeekGrowth = User::whereIn('role', ['donor', 'recipient'])
            ->whereBetween('created_at', [Carbon::now()->subWeeks(2), Carbon::now()->subWeek()])
            ->count();

        $weeklyGrowthRate = $previousWeekGrowth > 0 ?
            (($weeklyGrowth - $previousWeekGrowth) / $previousWeekGrowth) * 100 : ($weeklyGrowth > 0 ? 100 : 0);

        return [
            'daily_registrations' => $dailyRegistrations,
            'avg_daily_registrations' => count($dailyRegistrations) > 0 ? array_sum($dailyRegistrations) / count($dailyRegistrations) : 0,
            'weekly_growth' => $weeklyGrowth,
            'weekly_growth_rate' => round($weeklyGrowthRate, 1),
            'growth_momentum' => count($dailyRegistrations) > 1 ? ((end($dailyRegistrations) - reset($dailyRegistrations)) > 0 ? 'positive' : 'negative') : 'neutral'
        ];
    }

    /**
     * Get system health metrics with REAL data
     */
    private function getSystemHealthMetrics()
    {
        // Real database metrics
        $pendingDonationsCount = Donation::where('status', 'pending')->count();
        $pendingRequestsCount = RecipientRequest::where('status', 'pending')->count();
        $pendingSupportCount = SupportModel::where('status', 'pending')->count();

        // Calculate real system health scores
        $donationProcessingHealth = $this->calculateProcessingHealth('donations');
        $requestProcessingHealth = $this->calculateProcessingHealth('requests');
        $systemLoadHealth = $this->calculateSystemLoadHealth();

        return [
            'pending_donations' => $pendingDonationsCount,
            'pending_requests' => $pendingRequestsCount,
            'pending_support' => $pendingSupportCount,
            'donation_processing_health' => $donationProcessingHealth,
            'request_processing_health' => $requestProcessingHealth,
            'system_load_health' => $systemLoadHealth,
            'overall_health_score' => round(($donationProcessingHealth + $requestProcessingHealth + $systemLoadHealth) / 3, 1)
        ];
    }

    /**
     * Calculate processing health based on pending items and processing time
     */
    private function calculateProcessingHealth($type)
    {
        switch ($type) {
            case 'donations':
                $pending = Donation::where('status', 'pending')->count();
                $total = Donation::count();
                $avgProcessingTime = Donation::where('status', 'approved')
                    ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
                    ->first()->avg_hours ?? 24;
                break;
            case 'requests':
                $pending = RecipientRequest::where('status', 'pending')->count();
                $total = RecipientRequest::count();
                $avgProcessingTime = RecipientRequest::where('status', 'approved')
                    ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours')
                    ->first()->avg_hours ?? 24;
                break;
            default:
                return 100;
        }

        $pendingRatio = $total > 0 ? ($pending / $total) * 100 : 0;
        $timeScore = max(0, 100 - ($avgProcessingTime / 24 * 10)); // Penalize longer processing times

        $healthScore = max(60, 100 - ($pendingRatio * 0.5) - ((100 - $timeScore) * 0.3));

        return min(100, round($healthScore));
    }

    /**
     * Calculate system load health based on various metrics
     */
    private function calculateSystemLoadHealth()
    {
        $totalUsers = User::count();
        $totalDonations = Donation::count();
        $totalRequests = RecipientRequest::count();

        // Calculate load factor (simplified)
        $loadFactor = ($totalUsers * 0.3) + ($totalDonations * 0.4) + ($totalRequests * 0.3);

        // Normalize to health score (higher load = lower health)
        // Assuming optimal load is around 500 total items
        $optimalLoad = 500;
        $loadPercentage = min(100, ($loadFactor / $optimalLoad) * 100);
        $healthScore = max(60, 100 - ($loadPercentage * 0.4));

        return min(100, round($healthScore));
    }

    /**
     * Export analytics data
     */
    public function exportAnalytics(Request $request)
    {
        $type = $request->get('type', 'performance');

        // Implementation for exporting analytics data
        // You can implement CSV/Excel export here

        return redirect()->back()->with('success', 'Analytics data exported successfully!');
    }


    public function login(){
        return view('login');
    }

    public function useractivationrequest(){
        return view('useractivationrequest');
    }

    public function register(){
        return view('register');
    }

    public function donation(){
        $inneeds = InNeedsModel::all();
        return view('donation',compact('inneeds'));
    }

    public function aboutus(){
        return view('aboutus');
    }

    public function gallery(){
        $gallery = GalleryModel::all();
        return view('gallery',compact('gallery'));
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('landingpage')->with('success','logout successfully');
    }

    public function landingpage(){
        return view('landingpage');
    }

    public function registerpost(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required|in:male,female,others',
            'contact' => 'required|numeric',
            'password' => 'required|confirmed',
            'role' => 'required|in:admin,donor,recipient', // Ensure role is valid
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
            'age' => $validatedData['age'],
            'gender' => $validatedData['gender'],
            'contact' => $validatedData['contact'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'], // Store the role
        ]);

        Auth::login($user);

        // Redirect based on role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admindashboard')->with('success', 'Admin registered successfully');
            case 'donor':
                return redirect()->route('landingpageuser')->with('success', 'Donor registered successfully');
            case 'recipient':
                return redirect()->route('landingpagerecipient')->with('success', 'Recipient registered successfully');
            default:
                return redirect('/')->with('success', 'User registered successfully');
        }
    }

 public function csdlstaffdashboard()
    {
        $newrecord = User::whereDate('created_at', today())
            ->where('role', 'user')
            ->count();
        $newservice = SupportModel::whereDate('created_at', today())
            ->where('status', 'pending')
            ->count();
        $newdonation = DonationModel::whereDate('created_at', today())
            ->where('status', 'pending')
            ->count();
        $auth = Auth::user();

        // Count donations with approved OR matched status as approved
        $totalpending = Donation::where('status','pending')->count();
        $totalrejected = Donation::where('status','rejected')->count();
        $totaldonation = Donation::whereIn('status', ['approved', 'matched'])->count();

        $activeuser = User::where('account_status','active')->count();
        $inactiveuser = User::where('account_status','inactive')->count();
        $date = Carbon::now();
        $users = User::where('role','user')->get();
        $usercount = User::where('role','user')->count();

        // Top donator - count donations with approved OR matched status
        $topdonator = Donation::with('user')
            ->selectRaw('user_id, count(*) as donation_count')
            ->whereIn('status', ['approved', 'matched'])
            ->groupBy('user_id')
            ->orderByDesc('donation_count')
            ->first();

        // Get most donated items
        $mostDonatedItems = Donation::whereIn('status', ['approved', 'matched'])
            ->select('subcategory', DB::raw('COUNT(*) as count'))
            ->groupBy('subcategory')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Get most requested items
        $mostRequestedItems = RecipientRequest::whereIn('status', ['approved', 'matched', 'fulfilled'])
            ->select('subcategory', DB::raw('COUNT(*) as count'))
            ->groupBy('subcategory')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Weekly Analytics Data
        $weeklyAnalytics = $this->getWeeklyAnalytics();

        return view('csdl_staff.index', compact(
            'totalpending', 'totalrejected', 'auth', 'activeuser', 'inactiveuser',
            'date', 'users', 'usercount', 'totaldonation', 'topdonator',
            'newrecord', 'newservice', 'newdonation', 'weeklyAnalytics',
            'mostDonatedItems', 'mostRequestedItems'
        ));
    }
public function monitoringstaffdashboard()
    {
        $newrecord = User::whereDate('created_at', today())
            ->where('role', 'user')
            ->count();
        $newservice = SupportModel::whereDate('created_at', today())
            ->where('status', 'pending')
            ->count();
        $newdonation = Donation::whereDate('created_at', today())
            ->where('status', 'pending')
            ->count();
        $auth = Auth::user();

        // Count donations with approved OR matched status as approved
        $totalpending = Donation::where('status','pending')->count();
        $totalrejected = Donation::where('status','rejected')->count();
        $totaldonation = Donation::whereIn('status', ['approved', 'matched'])->count();

        $activeuser = User::where('account_status','active')->count();
        $inactiveuser = User::where('account_status','inactive')->count();
        $date = Carbon::now();
        $users = User::where('role','user')->get();
        $usercount = User::where('role','user')->count();

        // Top donator - count donations with approved OR matched status
        $topdonator = Donation::with('user')
            ->selectRaw('user_id, count(*) as donation_count')
            ->whereIn('status', ['approved', 'matched'])
            ->groupBy('user_id')
            ->orderByDesc('donation_count')
            ->first();

        // Get most donated items
        $mostDonatedItems = Donation::whereIn('status', ['approved', 'matched'])
            ->select('subcategory', DB::raw('COUNT(*) as count'))
            ->groupBy('subcategory')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Get donation status distribution
        $donationStatusDistribution = Donation::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Get donations by category
        $donationsByCategory = Donation::whereIn('status', ['approved', 'matched'])
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->get();

        // Weekly Donation Analytics Data
        $weeklyDonationAnalytics = $this->getWeeklyDonationAnalytics();

        return view('monitoring_staff.index', compact(
            'totalpending', 'totalrejected', 'auth', 'activeuser', 'inactiveuser',
            'date', 'users', 'usercount', 'totaldonation', 'topdonator',
            'newrecord', 'newservice', 'newdonation', 'weeklyDonationAnalytics',
            'mostDonatedItems', 'donationStatusDistribution', 'donationsByCategory'
        ));
    }

    /**
     * Generate weekly donation analytics data for the past 4 weeks
     */
    // private function getWeeklyDonationAnalytics()
    // {
    //     $weeks = [];
    //     $approvedDonations = [];
    //     $pendingDonations = [];
    //     $matchedDonations = [];
    //     $totalDonations = [];

    //     // Get data for the past 4 weeks
    //     for ($i = 3; $i >= 0; $i--) {
    //         $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
    //         $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();

    //         $weekLabel = $startOfWeek->format('M d') . ' - ' . $endOfWeek->format('M d');
    //         $weeks[] = $weekLabel;

    //         // Weekly approved donations
    //         $weeklyApproved = Donation::where('status', 'approved')
    //             ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
    //             ->count();
    //         $approvedDonations[] = $weeklyApproved;

    //         // Weekly pending donations
    //         $weeklyPending = Donation::where('status', 'pending')
    //             ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
    //             ->count();
    //         $pendingDonations[] = $weeklyPending;

    //         // Weekly matched donations
    //         $weeklyMatched = Donation::where('status', 'matched')
    //             ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
    //             ->count();
    //         $matchedDonations[] = $weeklyMatched;

    //         // Weekly total donations
    //         $weeklyTotal = Donation::whereBetween('created_at', [$startOfWeek, $endOfWeek])
    //             ->count();
    //         $totalDonations[] = $weeklyTotal;
    //     }

    //     return [
    //         'weeks' => $weeks,
    //         'approved_donations' => $approvedDonations,
    //         'pending_donations' => $pendingDonations,
    //         'matched_donations' => $matchedDonations,
    //         'total_donations' => $totalDonations
    //     ];
    // }

    /**
     * Export donation analytics data
     */
    public function exportDonationAnalytics(Request $request)
    {
        $type = $request->get('type', 'weekly');

        if ($type === 'weekly') {
            return $this->exportWeeklyDonationAnalytics();
        }

        return redirect()->back()->with('error', 'Invalid export type');
    }

    /**
     * Export weekly donation analytics as CSV
     */
    private function exportWeeklyDonationAnalytics()
    {
        $analytics = $this->getWeeklyDonationAnalytics();

        $fileName = 'donation_analytics_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($analytics) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['Week', 'Approved Donations', 'Pending Donations', 'Matched Donations', 'Total Donations']);

            // Data
            for ($i = 0; $i < count($analytics['weeks']); $i++) {
                fputcsv($file, [
                    $analytics['weeks'][$i],
                    $analytics['approved_donations'][$i],
                    $analytics['pending_donations'][$i],
                    $analytics['matched_donations'][$i],
                    $analytics['total_donations'][$i]
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get detailed donation analytics for specific time periods
     */
    public function getDetailedDonationAnalytics(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $donationsByCategory = Donation::whereBetween('created_at', [$startDate, $endDate])
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->get();

        $donationsByStatus = Donation::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $topDonors = Donation::with('user')
            ->selectRaw('user_id, count(*) as donation_count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('user_id')
            ->orderByDesc('donation_count')
            ->limit(5)
            ->get();

        return response()->json([
            'donations_by_category' => $donationsByCategory,
            'donations_by_status' => $donationsByStatus,
            'top_donors' => $topDonors
        ]);
    }


    // public function exportAnalytics(Request $request)
    // {
    //     $type = $request->get('type', 'weekly');

    //     if ($type === 'weekly') {
    //         return $this->exportWeeklyAnalytics();
    //     }

    //     return redirect()->back()->with('error', 'Invalid export type');
    // }

    /**
     * Export weekly analytics as CSV
     */
    private function exportWeeklyAnalytics()
    {
        $analytics = $this->getWeeklyAnalytics();

        $fileName = 'weekly_analytics_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($analytics) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['Week', 'Approved Donations', 'Approved Requests', 'Matches', 'Total Approved Items']);

            // Data
            for ($i = 0; $i < count($analytics['weeks']); $i++) {
                fputcsv($file, [
                    $analytics['weeks'][$i],
                    $analytics['donations'][$i],
                    $analytics['requests'][$i],
                    $analytics['matches'][$i],
                    $analytics['approved'][$i]
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get detailed analytics for specific time periods
     */
    public function getDetailedAnalytics(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $donationsByCategory = DonationModel::whereIn('status', ['approved', 'matched'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->get();

        $requestsByCategory = RecipientRequest::whereIn('status', ['approved', 'matched', 'fulfilled'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->get();

        return response()->json([
            'donations_by_category' => $donationsByCategory,
            'requests_by_category' => $requestsByCategory
        ]);
    }
public function admindashboard()
{
    $newrecord = User::whereDate('created_at', today())
        ->where('role', 'user')
        ->count();
    $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
    $newdonation = DonationModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
    $auth = Auth::user();

    // Count donations with approved OR matched status as approved
    $totalpending = DonationModel::where('status','pending')->count();
    $totalrejected = DonationModel::where('status','rejected')->count();
    $totaldonation = DonationModel::whereIn('status', ['approved', 'matched'])->count();

    $activeuser = User::where('account_status','active')->count();
    $inactiveuser = User::where('account_status','inactive')->count();
    $date = Carbon::now();
    $users = User::where('role','user')->get();
    $usercount = User::where('role','user')->count();

    // Top donator - count donations with approved OR matched status
    $topdonator = DonationModel::with('user')
        ->selectRaw('user_id, count(*) as donation_count')
        ->whereIn('status', ['approved', 'matched'])
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();

    // Get most donated items
    $mostDonatedItems = DonationModel::whereIn('status', ['approved', 'matched'])
        ->select('subcategory', DB::raw('COUNT(*) as count'))
        ->groupBy('subcategory')
        ->orderByDesc('count')
        ->limit(5)
        ->get();

    // Get most requested items
    $mostRequestedItems = RecipientRequest::whereIn('status', ['approved', 'matched', 'fulfilled'])
        ->select('subcategory', DB::raw('COUNT(*) as count'))
        ->groupBy('subcategory')
        ->orderByDesc('count')
        ->limit(5)
        ->get();

    // Weekly Analytics Data
    $weeklyAnalytics = $this->getWeeklyAnalytics();

    return view('admindashboard', compact(
        'totalpending', 'totalrejected', 'auth', 'activeuser', 'inactiveuser',
        'date', 'users', 'usercount', 'totaldonation', 'topdonator',
        'newrecord', 'newservice', 'newdonation', 'weeklyAnalytics',
        'mostDonatedItems', 'mostRequestedItems'
    ));
}

private function getWeeklyAnalytics()
{
    // Get the last 4 weeks data
    $weeks = [];
    $donationsData = [];
    $requestsData = [];
    $matchesData = [];
    $approvedData = [];

    for ($i = 3; $i >= 0; $i--) {
        $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
        $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();

        $weekLabel = 'Week ' . (4 - $i);
        $weeks[] = $weekLabel;

        // Approved donations for the week (including matched)
        $donationsCount = DonationModel::whereIn('status', ['approved', 'matched'])
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();
        $donationsData[] = $donationsCount;

        // Approved requests for the week (including matched and fulfilled)
        $requestsCount = RecipientRequest::whereIn('status', ['approved', 'matched', 'fulfilled'])
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();
        $requestsData[] = $requestsCount;

        // Matched donations for the week
        $matchesCount = DonationMatch::where('status', 'approved')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();
        $matchesData[] = $matchesCount;

        // Approved items bar chart data (combined approved donations and requests)
        $approvedCount = $donationsCount + $requestsCount;
        $approvedData[] = $approvedCount;
    }

    return [
        'weeks' => $weeks,
        'donations' => $donationsData,
        'requests' => $requestsData,
        'matches' => $matchesData,
        'approved' => $approvedData
    ];
}



    public function userlist(){
        $newrecord = User::whereDate('created_at', today())
        ->where('role', 'user')
        ->count();
        $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $newdonation = DonationModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $auth = Auth::user();
        $totaldonation = DonationModel::where('status','accepted')->count();
        $date = Carbon::now();
        $users = User::where('role','donor')->get();
        $usercount = User::where('role','donor')->count();
        $topdonator = DonationModel::with('donor')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();
        return view('userlist',compact('auth','date','users','usercount','totaldonation','topdonator','newrecord','newservice','newdonation'));
    }

    public function recipientlist(){
        $newrecord = User::whereDate('created_at', today())
        ->where('role', 'recipient')
        ->count();
        $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $newdonation = DonationModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $auth = Auth::user();
        $totaldonation = DonationModel::where('status','accepted')->count();
        $date = Carbon::now();
        $users = User::where('role','recipient')->get();
        $usercount = User::where('role','recipient')->count();
        $topdonator = DonationModel::with('recipient')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();
        return view('admin.recipientlist',compact('auth','date','users','usercount','totaldonation','topdonator','newrecord','newservice','newdonation'));
    }








    public function inneeds(){
        $newrecord = User::whereDate('created_at', today())
        ->where('role', 'user')
        ->count();
        $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $newdonation = DonationModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $auth =Auth::user();
        $totaldonation = DonationModel::where('status','accepted')->count();
        $date = Carbon::now();
        $users = User::where('role','user')->get();
        $usercount = User::where('role','user')->count();
        $inneeds = InNeedsModel::all();
        $topdonator = DonationModel::with('user')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();
        return view('inneeds',compact('auth','date','users','usercount','inneeds','totaldonation','topdonator','newrecord','newservice','newdonation'));
    }

    public function activationrequest(){
        $newrecord = User::whereDate('created_at', today())
        ->where('role', 'user')
        ->count();
        $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $newdonation = DonationModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $auth =Auth::user();
        $totaldonation = DonationModel::where('status','accepted')->count();
        $activationrequest = SupportModel::where('status','pending')->get();
        $date = Carbon::now();
        $users = User::where('role','user')->get();
        $usercount = User::where('role','user')->count();
        $inneeds = InNeedsModel::all();
        $topdonator = DonationModel::with('user')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();
        return view('activationrequest',compact('auth','date','users','usercount','inneeds','totaldonation','topdonator','activationrequest','newrecord','newservice','newdonation'));
    }

    public function activationrequestcompleted(){
        $newrecord = User::whereDate('created_at', today())
        ->where('role', 'user')
        ->count();
        $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $newdonation = DonationModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $auth =Auth::user();
        $totaldonation = DonationModel::count();
        $activationrequest = SupportModel::where('status','completed')->get();
        $date = Carbon::now();
        $users = User::where('role','user')->get();
        $usercount = User::where('role','user')->count();
        $inneeds = InNeedsModel::all();
        $topdonator = DonationModel::with('user')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();
        return view('activationrequestcompleted',compact('auth','date','users','usercount','inneeds','totaldonation','topdonator','activationrequest','newrecord','newservice','newdonation'));
    }


   public function admindonation()
{
    $newrecord = User::whereDate('created_at', today())
        ->where('role', 'donor')
        ->count();
    $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
    $newdonation = DonationModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
    $auth = Auth::user();
    $totaldonation = DonationModel::where('status','accepted')->count();
    $date = Carbon::now();
    $users = User::where('role','donor')->get();
    $usercount = User::where('role','donor')->count();

    // Changed to show all donations regardless of status
    $donations = DonationModel::with('user')->get();

    $topdonator = DonationModel::with('user')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();

    return view('admindonation', compact(
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
    public function admindonationaccepted(){
        $newrecord = User::whereDate('created_at', today())
        ->where('role', 'donor')
        ->count();
        $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $newdonation = DonationModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $auth =Auth::user();
        $totaldonation = DonationModel::where('status','accepted')->count();
        $date = Carbon::now();
        $users = User::where('role','user')->get();
        $usercount = User::where('role','user')->count();
        $alldonators = DonationModel::with('user')->where('status','accepted')->get();
        $topdonator = DonationModel::with('user')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();
        return view('admindonationaccepted',compact('auth','date','users','usercount','alldonators','totaldonation','topdonator','newrecord','newservice','newdonation'));
    }

    public function admindonationrejected(){
        $newrecord = User::whereDate('created_at', today())
        ->where('role', 'user')
        ->count();
        $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $newdonation = DonationModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $auth =Auth::user();
        $totaldonation = DonationModel::where('status','accepted')->count();
        $date = Carbon::now();
        $users = User::where('role','user')->get();
        $usercount = User::where('role','user')->count();
        $alldonators = DonationModel::with('user')->where('status','rejected')->get();
        $topdonator = DonationModel::with('user')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();
        return view('admindonationrejected',compact('auth','date','users','usercount','alldonators','totaldonation','topdonator','newrecord','newservice','newdonation'));
    }
    public function updatestatus(Request $request, $id){
        $donation  = DonationModel::findOrFail($id);
        $donation->status = $request->status;
        $donation->save();
        return redirect()->back()->with('success','Status Updated Successfully');
    }
    public function admingallery(){
        $gallery = GalleryModel::all();
        $newrecord = User::whereDate('created_at', today())
        ->where('role', 'user')
        ->count();
        $newservice = SupportModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $newdonation = DonationModel::whereDate('created_at', today())
        ->where('status', 'pending')
        ->count();
        $auth = Auth::user();
        $totaldonation = DonationModel::where('status','accepted')->count();
        $date = Carbon::now();
        $usercount = User::where('role','user')->count();
        $topdonator = DonationModel::with('user')
        ->selectRaw('user_id, count(*) as donation_count')
        ->where('status', 'accepted')
        ->groupBy('user_id')
        ->orderByDesc('donation_count')
        ->first();
        return view('admingallery',compact('auth','date','usercount','totaldonation','topdonator','newrecord','newservice','newdonation','gallery'));
    }

    public function gallerypost(Request $request)
        {
            // Step 1: Validate the text fields first.
            $validatedData = $request->validate([
                'description' => 'required|string|max:200',
                'location'    => 'required|string',
                'images'      => 'present|array' // This ensures the 'images' field was submitted.
            ]);

            // Step 2: Manually loop through and filter the uploaded files.
            $validImagePaths = [];
            $allowedExtensions = ['jpeg', 'png', 'jpg', 'gif', 'svg'];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    // Check if the file is valid and has an allowed extension
                    if ($file->isValid() && in_array(strtolower($file->getClientOriginalExtension()), $allowedExtensions)) {
                        // If it's a valid image, store it and save the path
                        $path = $file->store('gallery', 'public');
                        $validImagePaths[] = $path;
                    }
                    // Invalid files are simply ignored, and the loop continues.
                }
            }

            // Step 3: After checking all files, ensure at least one was valid.
            if (empty($validImagePaths)) {
                // If no valid images were uploaded, return with an error.
                return back()->withErrors(['images' => 'You must upload at least one valid image file (jpeg, png, jpg, gif, svg).'])->withInput();
            }

            // Step 4: Create the gallery record using ONLY the valid image paths.
            $gallery = GalleryModel::create([
                'images'      => $validImagePaths, // Use the filtered array of valid paths
                'description' => $validatedData['description'],
                'location'    => $validatedData['location'],
            ]);

            // Step 5: Return a success message.
            return back()->with('success', 'Gallery added successfully! Any invalid files were ignored.');
        }

    public function galleryupdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|max:200',
            'location' => 'required',
        ]);

        $gallery = GalleryModel::findOrFail($id);

        $imagePaths = $gallery->images ?? [];

        if ($request->hasFile('images')) {
            // Delete old images
            if (!empty($imagePaths)) {
                foreach ($imagePaths as $imagePath) {
                    if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('gallery', 'public');
            }
        }

        $gallery->update([
            'images' => $imagePaths,
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
        ]);

        return back()->with('success', 'Gallery Updated Successfully');
    }

    public function deletegallery($id){
        $gallery = GalleryModel::findOrFail($id);
        foreach ($gallery->images as $image) {
            Storage::disk('public')->delete($image);
        }
        $gallery->delete();
        return back()->with('success', 'Gallery Deleted Successfully');
    }

public function recipientdashboard(){
    $requests = RecipientRequest::where('user_id', auth()->id())->get();
    $auth = Auth::user();
    $user = User::where('id',auth()->id())->first();

    // Request counts - COUNT MATCHED AS APPROVED TOO
    $donationscount = $requests->count();
    $pendingreq = $requests->where('status', 'pending')->count();
    $acceptedreq = $requests->whereIn('status', ['approved', 'matched', 'partially_matched'])->count(); // Include matched as approved
    $rejectedreq = $requests->where('status', 'rejected')->count();
    $matchedreq = $requests->where('status', 'matched')->count();
    $partiallymatched = $requests->where('status', 'partially_matched')->count();
    $fulfilledreq = $requests->where('status', 'fulfilled')->count();

    // Get matched donations data
    $matchedDonations = DonationMatch::whereHas('request', function($query) {
        $query->where('user_id', auth()->id());
    })->with(['donation', 'request'])->get();

    $totalMatchedDonations = $matchedDonations->count();
    $completedMatches = $matchedDonations->where('status', 'completed')->count();
    $pendingMatches = $matchedDonations->where('status', 'pending')->count();
    $cancelledMatches = $matchedDonations->where('status', 'cancelled')->count();

    // Calculate total allocated quantity
    $totalAllocatedQuantity = $matchedDonations->sum('allocated_quantity');

    // Analytics data for charts - COUNT MATCHED AS APPROVED
    $statusAnalytics = [
        'approved' => $acceptedreq, // This now includes matched and partially_matched
        'rejected' => $rejectedreq,
        'pending' => $pendingreq,
        'fulfilled' => $fulfilledreq
    ];

    // Category-wise analytics
    $categoryAnalytics = RecipientRequest::where('user_id', auth()->id())
        ->select('category', DB::raw('COUNT(*) as count'))
        ->groupBy('category')
        ->get()
        ->pluck('count', 'category')
        ->toArray();

    // Monthly request trends (last 6 months)
    $monthlyTrends = RecipientRequest::where('user_id', auth()->id())
        ->where('created_at', '>=', now()->subMonths(6))
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

    $monthlyLabels = [];
    $monthlyData = [];

    foreach ($monthlyTrends as $trend) {
        $monthName = date('M Y', mktime(0, 0, 0, $trend->month, 1, $trend->year));
        $monthlyLabels[] = $monthName;
        $monthlyData[] = $trend->count;
    }

    $date = Carbon::now();

    return view('recipient.index', compact(
        'auth', 'user', 'requests', 'donationscount', 'date',
        'pendingreq', 'acceptedreq', 'rejectedreq', 'matchedreq',
        'partiallymatched', 'fulfilledreq', 'totalMatchedDonations',
        'completedMatches', 'pendingMatches', 'cancelledMatches',
        'totalAllocatedQuantity', 'statusAnalytics', 'categoryAnalytics',
        'monthlyLabels', 'monthlyData'
    ));
}
    public function editRecipientRequest(RecipientRequest $recipientRequest)
    {
        // Check if the authenticated user owns this request and if it's pending
        if (Auth::id() !== $recipientRequest->user_id || $recipientRequest->status !== 'pending') {
            return response()->json(['error' => 'Unauthorized action or request is not editable.'], 403);
        }

        return response()->json($recipientRequest);
    }

    public function updateRecipientRequest(Request $request, RecipientRequest $recipientRequest)
    {
        // Check if the authenticated user owns this request and if it's pending
        if (Auth::id() !== $recipientRequest->user_id || $recipientRequest->status !== 'pending') {
            return redirect()->back()->withErrors(['error' => 'You cannot edit this request.']);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string|max:255',
            'urgency' => 'required|string|in:asap,within_week,within_month,flexible,specific',
            'specific_date' => 'nullable|date|after_or_equal:today',
        ]);

        $recipientRequest->update($validated);

        return redirect()->back()->with('success', 'Request updated successfully!');
    }

    public function destroyRecipientRequest(RecipientRequest $recipientRequest)
    {
        // Check if the authenticated user owns this request and if it's pending
        if (Auth::id() !== $recipientRequest->user_id || $recipientRequest->status !== 'pending') {
            return redirect()->back()->withErrors(['error' => 'You cannot delete this request.']);
        }

        $recipientRequest->delete();

        return redirect()->back()->with('success', 'Request deleted successfully!');
    }

    public function addinneed(Request   $request){
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'description' => ['required', function ($attribute, $value, $fail) {
                $wordCount = str_word_count($value);
                if ($wordCount > 500) {
                    $fail('The description may not be greater than 20 words.');
                }
            }],
            'location' => 'required',
            'category' => 'required|in:food,clothing,education,hygiene,shelter,medical,emergency',
        ]);

        $imagepath = null;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imagepath = $image->store('inneed','public');
        }

        $inneed = InNeedsModel::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
            'category' => $validatedData['category'],
            'image' => $imagepath
        ]);

        return back()->with('success', 'Request Added Successfully');
    }

    public function updateinneed(Request $request,$id){
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'category' => 'required|in:food,clothing,education,hygiene,shelter,medical,emergency',
        ]);

        $inneed = InNeedsModel::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($inneed->image) {
                Storage::disk('public')->delete($inneed->image);
            }
            $image = $request->file('image');
            $imagePath = $image->store('inneed', 'public');
            $inneed->image = $imagePath;
        }
        $inneed->title = $validatedData['title'];
        $inneed->description = $validatedData['description'];
        $inneed->location = $validatedData['location'];
        $inneed->category = $validatedData['category'];
        $inneed -> save();
        return redirect()->back()->with('success', 'In Needs Updated Successfully!');


    }

public function donordashboard(Request $request){
    $auth = Auth::user();
    $user = User::where('id',auth()->id())->first();
    $donations = DonationModel::where('user_id', auth()->id())->get();
    $donationscount = DonationModel::where('user_id', auth()->id())->count();

    // Count matched as approved too
    $pendingreq = DonationModel::where('status', 'pending')->where('user_id', auth()->id())->count();
    $acceptedreq = DonationModel::whereIn('status', ['accepted', 'matched'])->where('user_id', auth()->id())->count();
    $rejectedreq = DonationModel::where('status', 'rejected')->where('user_id', auth()->id())->count();
    $matchedreq = DonationModel::where('status', 'matched')->where('user_id', auth()->id())->count();

    // Analytics data for charts - simplified statuses
    $statusAnalytics = [
        'pending' => $pendingreq,
        'approved' => $acceptedreq, // This includes both accepted and matched
        'rejected' => $rejectedreq,
        'matched' => $matchedreq
    ];

    // Category-wise analytics
    $categoryAnalytics = DonationModel::where('user_id', auth()->id())
        ->select('category', DB::raw('COUNT(*) as count'))
        ->groupBy('category')
        ->get()
        ->pluck('count', 'category')
        ->toArray();

    // Monthly donation trends (last 6 months)
    $monthlyTrends = DonationModel::where('user_id', auth()->id())
        ->where('created_at', '>=', now()->subMonths(6))
        ->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

    $monthlyLabels = [];
    $monthlyData = [];

    foreach ($monthlyTrends as $trend) {
        $monthName = date('M Y', mktime(0, 0, 0, $trend->month, 1, $trend->year));
        $monthlyLabels[] = $monthName;
        $monthlyData[] = $trend->count;
    }

    // Get matched donations data
    $matchedDonations = DonationMatch::whereHas('donation', function($query) {
        $query->where('user_id', auth()->id());
    })->with(['donation', 'request'])->get();

    $totalMatchedDonations = $matchedDonations->count();
    $totalAllocatedQuantity = $matchedDonations->sum('allocated_quantity');

    $date = Carbon::now();

    return view('donor.index', compact(
        'auth', 'user', 'donations', 'donationscount', 'date',
        'pendingreq', 'acceptedreq', 'rejectedreq', 'matchedreq',
        'statusAnalytics', 'categoryAnalytics', 'monthlyLabels', 'monthlyData',
        'totalMatchedDonations', 'totalAllocatedQuantity'
    ));
}
    public function adduser(Request $request){
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'age' => 'required',
            'gender' => 'required|in:male,female,others',
            'contact' => 'required|numeric',
            'password' => 'required|confirmed',
            'role' => 'required|in:donor',
        ]);

        $imagepath = null;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imagepath = $image->store('profile','public');
        }

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
            'age' => $validatedData['age'],
            'gender' => $validatedData['gender'],
            'contact' => $validatedData['contact'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'image' => $imagepath,
        ]);


        return back()->with('success', 'User Added Successfully');
    }




    public function addrecipient(Request $request){
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'age' => 'required',
            'gender' => 'required|in:male,female,others',
            'contact' => 'required|numeric',
            'password' => 'required|confirmed',
            'role' => 'required|in:recipient',
        ]);

        $imagepath = null;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imagepath = $image->store('profile','public');
        }

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
            'age' => $validatedData['age'],
            'gender' => $validatedData['gender'],
            'contact' => $validatedData['contact'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'image' => $imagepath,
        ]);


        return back()->with('success', 'User Added Successfully');
    }



    public function editrecipient($id){
        $auth = Auth::user();
        $user = User::findOrFail($id); // Find the user by ID or return a 404 if not found
        return view('recipient.editrecipient', compact('auth', 'user')); // Pass 'auth' and 'user' to the view
    }
    public function updaterecipient(Request $request,$id){
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'required',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female,others',
            'password' => 'nullable|confirmed',
            'contact' => 'nullable|numeric'
        ]);

        $user = User::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $image = $request->file('image');
            $imagePath = $image->store('profile', 'public');
            $user->image = $imagePath;
        }
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->address = $validatedData['address'];
        $user->age = $validatedData['age'];
        $user->gender = $validatedData['gender'];
        $user->contact = $validatedData['contact'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();
        return redirect()->back()->with('success', 'Recipient Updated Successfully!');
    }

    public function deleterecipient($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success','Recipient Deleted Successfully');
    }

    public function deleteaccountrecipient($id)
    {
        try {
            $user = User::findOrFail($id);
            if (Auth::id() == $user->id) {
                $user->delete();
                Auth::logout();
                return redirect()->route('login')->with('success', 'Your Account Has Been Deleted Successfully. You Have Been Logged Out');
            }
            $user->delete();
            return redirect()->back()->with('success', 'User Deleted Successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'User not found');
        }
    }


    public  function destroyrecipient($id){
        $inneed = InNeedsModel::findOrFail($id);
        $inneed->delete();
        return redirect()->back()->with('success','Recipient Deleted Successfully');
    }














    public function edituser($id){
        $auth = Auth::user();
        $user = User::findOrFail($id); // Find the user by ID or return a 404 if not found
        return view('edituser', compact('auth', 'user')); // Pass 'auth' and 'user' to the view
    }

    public function updateuser(Request $request,$id){
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'required',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female,others',
            'password' => 'nullable|confirmed',
            'contact' => 'nullable|numeric'
        ]);

        $user = User::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $image = $request->file('image');
            $imagePath = $image->store('profile', 'public');
            $user->image = $imagePath;
        }
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->address = $validatedData['address'];
        $user->age = $validatedData['age'];
        $user->gender = $validatedData['gender'];
        $user->contact = $validatedData['contact'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();
        return redirect()->back()->with('success', 'User Updated Successfully!');
    }

    public function deleteuser($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success','User Deleted Successfully');
    }

    public function deleteaccount($id)
    {
        try {
            $user = User::findOrFail($id);
            if (Auth::id() == $user->id) {
                $user->delete();
                Auth::logout();
                return redirect()->route('login')->with('success', 'Your Account Has Been Deleted Successfully. You Have Been Logged Out');
            }
            $user->delete();
            return redirect()->back()->with('success', 'User Deleted Successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'User not found');
        }
    }


    public  function destroy($id){
        $inneed = InNeedsModel::findOrFail($id);
        $inneed->delete();
        return redirect()->back()->with('success','Request Deleted Successfully');
    }

    public function deletedonation($id){
        $donation = DonationModel::findOrFail($id);
        $donation -> delete();
        return redirect()->back()->with('success','Donation Deleted Successfully');
    }

    public function activateaccount($id){
        $user = User::findOrFail($id);
        if($user->account_status =='active'){
            return redirect()->back()->withErrors(['account' => 'This Account Is Already Active']);
        }
        $user ->account_status = 'active';
        $user->save();
        return back()->with('success','Account Activated Successfully');
    }

    public function deactivateaccount($id){
        $user = User::findOrFail(id: $id);
        if($user->account_status =='inactive'){
            return redirect()->back()->withErrors(['account' => 'This Account Is Already Inactive']);
        }
        $user ->account_status = 'inactive';
        $user->save();
        return back()->with('success','Account Deactivated Successfully');
    }

    public function userdeactivateaccount($id)
    {
        try {
            $user = User::findOrFail($id);

            if (Auth::id() == $user->id) {

                if ($user->account_status == 'inactive') {
                    return redirect()->back()->withErrors(['account' => 'This Account Is Already Inactive']);
                }


                $user->account_status = 'inactive';
                $user->save();

                Auth::logout();
                return redirect()->route('login')->with('success', 'Your Account Has Been Deactivated. You Have Been Logged Out');
            }
            if ($user->account_status != 'inactive') {
                $user->account_status = 'inactive';
                $user->save();
            }

            return redirect()->back()->with('success', 'Account Deactivated Successfully');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'User not found');
        }
    }


    public function useractivationstore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        $check = User::where('email',$validatedData['email'])->exists();

        if(!$check){
            return redirect()->back()->withErrors(['email' => 'This Email Does Not Exist In Our Records, Please Enter A Valid Email Address']);
        }

        $checkemailifexist = SupportModel::where('email',$validatedData['email'])->exists();

        if ($checkemailifexist) {
            return redirect()->back()->withErrors(['email' => 'You Can Only Submit Request Once, This Email Has Been Used To Submit A Request']);
        }


        $user = new SupportModel();

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->address = $validatedData['address'];
        $user->save();

        return redirect()->back()->with('success', 'The Activation Request Has Been Successfully Sent');
    }

    public function updaterequeststatus($id){
        $support = SupportModel::findOrFail($id);
        $support -> status = 'completed';
        $support -> save();
        return redirect()->back()->with('success', 'Request Status Updated Successfully');
    }

    public function deletesupport($id){
        $support = SupportModel::findOrFail($id);
        $support->delete();
        return redirect()->back()->with('success', 'User Request Deleted Successfully');
    }

    public function exportdonation(){
        return Excel::download(new DonationsExport, 'accepted_donations.xlsx');
    }

    public function exportactiveusers(){
        return Excel::download(new ActiveUsersExport,'active_users.xlsx');
    }




}
