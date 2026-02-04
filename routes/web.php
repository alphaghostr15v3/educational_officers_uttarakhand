<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Public\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/orders', [HomeController::class, 'orders'])->name('orders');
Route::get('/seniority', [HomeController::class, 'seniority'])->name('seniority');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/donation', [HomeController::class, 'donation'])->name('donation');
Route::post('/donation', [HomeController::class, 'processDonation'])->name('donation.process');

Auth::routes();

// Redirect admin to login if they go to /admin or /admin/login directly
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});
Route::get('/admin/login', function () {
    return redirect()->route('login');
});

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('officers', \App\Http\Controllers\Admin\AdminOfficerController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\AdminOrderController::class);
    Route::resource('circulars', \App\Http\Controllers\Admin\AdminCircularController::class);
    Route::resource('news', \App\Http\Controllers\Admin\AdminNewsController::class);
    Route::resource('seniority', \App\Http\Controllers\Admin\AdminSeniorityController::class);
    Route::resource('portal-forms', \App\Http\Controllers\Admin\AdminPortalFormController::class);
    Route::resource('elections', \App\Http\Controllers\Admin\AdminElectionController::class);
    Route::post('elections/{election}/activate', [\App\Http\Controllers\Admin\AdminElectionController::class, 'activate'])->name('elections.activate');
    Route::post('elections/{election}/candidates', [\App\Http\Controllers\Admin\AdminElectionController::class, 'addCandidate'])->name('elections.candidates.add');

    // Voting Portal
    Route::get('/voting', [\App\Http\Controllers\Admin\VotingController::class, 'index'])->name('elections.vote.index');
    Route::get('/voting/{election}', [\App\Http\Controllers\Admin\VotingController::class, 'show'])->name('elections.vote.show');
    Route::post('/voting/{election}/cast', [\App\Http\Controllers\Admin\VotingController::class, 'cast'])->name('elections.vote.cast');

    // Donation Management
    Route::get('/donations', [\App\Http\Controllers\Admin\AdminDonationController::class, 'index'])->name('donations.index');

    // User Management (State Admin Only)
    Route::resource('users', \App\Http\Controllers\Admin\UserManagementController::class);
    Route::resource('divisions', \App\Http\Controllers\Admin\DivisionController::class);
    Route::resource('districts', \App\Http\Controllers\Admin\DistrictController::class);
    
    // System Features (State Admin)
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs.index');
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});
