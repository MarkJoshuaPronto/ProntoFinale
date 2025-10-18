<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonationMatchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\CsdlStaffContoller;
// In web.php
Route::post('/export-analytics', [AdminController::class, 'exportAnalyticsData'])->name('export.analytics');

Route::post('/admin/match-request', [AdminController::class, 'matchRequest'])->name('match-request');
Route::get('/admin/check-auto-matching-availability', [AdminController::class, 'checkAutoMatchingAvailability']);
// Add to routes/web.php
Route::post('/admin/fix-donation-statuses', [AdminController::class, 'fixDonationStatuses']);

Route::get('/admin/export/donations', [AdminController::class, 'exportDonations'])->name('admin.exportdonation');

// Staff Management Routes
Route::get('/admin/staff-management', [AdminController::class, 'staffManagement'])->name('staff-management');
Route::post('/admin/add-staff', [AdminController::class, 'addStaff'])->name('add-staff');
Route::put('/admin/staff/{id}/status', [AdminController::class, 'updateStaffStatus'])->name('update-staff-status');
Route::delete('/admin/staff/{id}', [AdminController::class, 'deleteStaff'])->name('delete-staff');


Route::get('/csdl-staff/analytics/export', [PostController::class, 'exportAnalytics'])->name('csdl.export.analytics');
Route::get('/csdl-staff/analytics/detailed', [PostController::class, 'getDetailedAnalytics'])->name('csdl.detailed.analytics');

Route::get('/', function () {
    return view('welcome');
});

Route::post('forgot-password', [AdminController::class, 'sendResetLinkEmail'])->name('password.email');
// In routes/web.php (for Laravel)
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgotpassword');

Route::get('/inventory', [AdminController::class, 'adminInventory'])->name('admin_inventory');

Route::get('/staff/inventory', [CsdlStaffContoller::class, 'donorInventory'])->name('staff_inventory');

Route::get('/staff/inventory2', [CsdlStaffContoller::class, 'donorInventory2'])->name('staff_inventory2');




Route::get('/notifications/show', [AdminController::class, 'show'])->name('notifications.show');
Route::post('/notifications/read', [AdminController::class, 'markAsRead'])->name('notifications.read');


// In your routes/web.php file
Route::get('/admin/recipient-requests/{id}/matches', [AdminController::class, 'getMatches'])->name('admin.recipient-requests.matches');

Route::get('/admin/test-matching', [AdminController::class, 'testMatching']);

// Auto-matching routes
Route::post('/run-auto-matching', [AdminController::class, 'runAutoMatching'])->name('run-auto-matching');
Route::get('/admin/recipient-requests/{id}/matches', [AdminController::class, 'getRequestMatches'])->name('request-matches');


Route::get('/admin/donations/matching/{requestId}', [DonationMatchController::class, 'getMatchingDonations']);
Route::post('/admin/match-request', [DonationMatchController::class, 'matchRequest'])->name('admin.match-request');
Route::get('/admin/match/{id}', [DonationMatchController::class, 'getMatchDetails']);

  Route::get('staff/recipient-requests', [CsdlStaffContoller::class, 'showStaffRequests'])->name('staff-recipient-request');



  Route::get('admin/recipient-requests', [AdminController::class, 'showRecipientRequests'])->name('show-recipient-request');
    Route::get('admin/recipient-requests/{id}', [AdminController::class, 'showRequest']);
    Route::put('admin/recipient-requests/{id}/status', [AdminController::class, 'updateStatus'])->name('update-request-status');
    Route::get('admin/donations/matching', [AdminController::class, 'getMatchingDonations']);
    Route::post('admin/match-request', [AdminController::class, 'matchRequest']);

// Route::get('/show-recipient-request',[AdminController::class,'showrecipientrequest'])->name('show-recipient-request');
Route::get('/show-match',[AdminController::class,'showmatch'])->name('show-match');

Route::get('/staff-show-match',[AdminController::class,'staffshowmatch'])->name('staff-show-match');


// Route::put('/update-request-status/{id}', [AdminController::class, 'updateRequestStatus'])->name('update-request-status');

Route::post('/donationsdonate', [DonorController::class, 'store_donation'])->name('donations.store');
Route::get('/donations/{donation}', [DonorController::class, 'show'])->name('donations.show');
Route::put('/donations/{donation}', [DonorController::class, 'update'])->name('donations.update');
Route::delete('/donations/{donation}', [DonorController::class, 'destroy'])->name('donations.destroy');

 Route::put('/{donation}/update-status', [DonorController::class, 'updateStatus'])->name('donations.update-status');



Route::get('/recipientrequest',[RecipientController::class,'show_request'])->name('show_request');
Route::post('/storerequest', [RecipientController::class, 'store_request'])->name('requests.store');
Route::put('/requests/{id}', [RecipientController::class, 'update_request'])->name('requests.update');
Route::get('/requests/{id}', [RecipientController::class, 'show']);
Route::delete('/requests/{id}', [RecipientController::class, 'delete_request'])->name('requests.destroy');




Route::get('/',[PostController::class,'landingpage'])->name('landingpage');
Route::get('/login',[PostController::class,'login'])->name('login');
Route::get('/useractivationrequest',[PostController::class,'useractivationrequest'])->name('useractivationrequest');
Route::get('/donation',[PostController::class,'donation'])->name('donation');
Route::get('/aboutus',[PostController::class,'aboutus'])->name('aboutus');
Route::get('/gallery',[PostController::class,'gallery'])->name('gallery');

Route::get('/donordashboard',[PostController::class,'donordashboard'])->name('donordashboard')->middleware('auth');
Route::get('/recipientdashboard',[PostController::class,'recipientdashboard'])->name('recipientdashboard')->middleware('auth');

// Route::get('/userdashboard',[PostController::class,'donordashboard'])->name('donordashboard')->middleware('auth');

Route::get('/csdlstaffdashboard',[PostController::class,'csdlstaffdashboard'])->name('csdlstaffdashboard')->middleware('auth');
Route::get('/monitoringstaffdashboard',[PostController::class,'monitoringstaffdashboard'])->name('monitoringstaffdashboard')->middleware('auth');
// Add these routes to your web.php file
Route::get('/monitoring-staff/analytics/donation-export', [PostController::class, 'exportDonationAnalytics'])->name('monitoring.export.donation-analytics');
Route::get('/monitoring-staff/analytics/donation-detailed', [PostController::class, 'getDetailedDonationAnalytics'])->name('monitoring.detailed.donation-analytics');

Route::get('/staffdonation',[CsdlStaffContoller::class,'staffdonation'])->name('staffdonation')->middleware('auth');
Route::get('/staffdonation2',[CsdlStaffContoller::class,'staffdonation2'])->name('staffdonation2')->middleware('auth');

Route::get('/admindashboard',[PostController::class,'admindashboard'])->name('admindashboard')->middleware('auth');


Route::get('/itstaffdashboard',[PostController::class,'itstaffdashboard'])->name('itstaffdashboard')->middleware('auth');
Route::get('/userlist',[PostController::class,'userlist'])->name('userlist')->middleware('auth');
Route::get('/recipientlist',[PostController::class,'recipientlist'])->name('recipientlist')->middleware('auth');
Route::get('/admingallery',[PostController::class,'admingallery'])->name('admingallery')->middleware('auth');
Route::get('/inneeds',[PostController::class,'inneeds'])->name('inneeds')->middleware('auth');
Route::get('/activationrequest',[PostController::class,'activationrequest'])->name('activationrequest')->middleware('auth');
Route::get('/activationrequestcompleted',[PostController::class,'activationrequestcompleted'])->name('activationrequestcompleted')->middleware('auth');
Route::get('/admindonation',[PostController::class,'admindonation'])->name('admindonation')->middleware('auth');
Route::get('/admindonationaccepted',[PostController::class,'admindonationaccepted'])->name('admindonationaccepted')->middleware('auth');
Route::get('/admindonationrejected',[PostController::class,'admindonationrejected'])->name('admindonationrejected')->middleware('auth');
Route::delete('/delete-donation/{id}', [PostController::class, 'deletedonation'])->name('deletedonation');
Route::put('/updatestatus/{id}',[PostController::class,'updatestatus'])->name('updatestatus');

Route::post('/addinneed',[PostController::class,'addinneed'])->name('addinneed');
Route::put('/edit-inneeds/{id}', [PostController::class, 'updateinneed'])->name('updateinneed');
Route::get('/register',[PostController::class,'register'])->name('register');
Route::post('/loginpost',[PostController::class,'loginpost'])->name('loginpost');
Route::post('/registerpost',[PostController::class,'registerpost'])->name('registerpost');

Route::post('/adduser',[PostController::class,'adduser'])->name('adduser');
Route::get('/edituser/{id}', [PostController::class, 'edituser'])->name('edituser');
Route::put('/edit-user/{id}', [PostController::class, 'updateuser'])->name('updateuser');
Route::delete('/delete-user/{id}', [PostController::class, 'deleteuser'])->name('deleteuser');
Route::delete('/deleteaccount/{id}', [PostController::class, 'deleteaccount'])->name('deleteaccount');
Route::delete('/delete-request/{id}', [PostController::class, 'destroy'])->name('destroy');


Route::post('/addrecipient',[PostController::class,'addrecipient'])->name('addrecipient');
Route::get('/editrecipient/{id}', [PostController::class, 'editrecipient'])->name('editrecipient');
Route::put('/edit-recipient/{id}', [PostController::class, 'updaterecipient'])->name('updaterecipient');
Route::delete('/delete-recipient/{id}', [PostController::class, 'deleterecipient'])->name('deleterecipient');
Route::delete('/deleteaccountrecipient/{id}', [PostController::class, 'deleteaccountrecipient'])->name('deleteaccountrecipient');
Route::delete('/delete-requestrecipient/{id}', [PostController::class, 'destroyrecipient'])->name('destroyrecipient');


Route::get('/landingpageuser',[UserController::class,'landingpageuser'])->name('landingpageuser')->middleware('auth');
Route::get('/donationuser',[UserController::class,'donationuser'])->name('donationuser')->middleware('auth');
Route::get('/galleryuser',[UserController::class,'galleryuser'])->name('galleryuser')->middleware('auth');
Route::get('/aboutususer',[UserController::class,'aboutususer'])->name('aboutususer')->middleware('auth');
Route::post('/logout', [PostController::class, 'logout'])->name('logout');

Route::post('/donatenow',[UserController::class,'donatenow'])->name('donatenow');
Route::put('/updatedonation/{id}', [UserController::class, 'updatedonation'])->name('updatedonation');
Route::delete('/destroy-user-donation/{id}', [UserController::class, 'destroyuserdonation'])->name('destroyuserdonation');

Route::put('/activate/{id}',[PostController::class,'activateaccount'])->name('activateaccount');
Route::put('/deactivate/{id}',[PostController::class,'deactivateaccount'])->name('deactivateaccount');

Route::put('/userdeactivateaccount/{id}',[PostController::class,'userdeactivateaccount'])->name('userdeactivateaccount');

Route::post('/useractivationstore',[PostController::class,'useractivationstore'])->name('useractivationstore');
Route::put('/updaterequeststatus/{id}',[PostController::class,'updaterequeststatus'])->name('updaterequeststatus');
Route::delete('/user-request/{id}', [PostController::class, 'deletesupport'])->name('deletesupport');

Route::get('forgot-password', [UserController::class, 'forgotpassword'])->name('forgotpassword');
Route::post('forgot-password', [UserController::class, 'forgotpasswordpost'])->name('forgotpasswordpost');

Route::get('reset-password/{token}', [UserController::class, 'showresetform'])->name('password.reset');
Route::post('reset-password', [UserController::class, 'reset'])->name('password.update');

Route::post('adding-gallery...', [PostController::class, 'gallerypost'])->name('gallerypost');
Route::put('updating-gallery/{id}...', [PostController::class, 'galleryupdate'])->name('galleryupdate');
Route::delete('deleting-gallery/{id}...', [PostController::class, 'deletegallery'])->name('deletegallery');

Route::get('/download-donations', [PostController::class, 'exportdonation'])->name('exportdonation');
Route::get('/download-active-users', [PostController::class, 'exportactiveusers'])->name('exportactiveusers');


Route::get('/landingpagerecipient',[RecipientController::class,'landingpagerecipient'])->name('landingpagerecipient')->middleware('auth');
Route::get('/donationrecipient',[RecipientController::class,'donationrecipient'])->name('donationrecipient')->middleware('auth');
Route::get('/gallerypagerecipient',[RecipientController::class,'gallerypagerecipient'])->name('gallerypagerecipient')->middleware('auth');
Route::get('/aboutuspagerecipient',[RecipientController::class,'aboutuspagerecipient'])->name('aboutuspagerecipient')->middleware('auth');
Route::post('/logout', [PostController::class, 'logout'])->name('logout');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
