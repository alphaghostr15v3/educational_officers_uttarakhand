<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Public\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/orders', [HomeController::class, 'orders'])->name('orders');
Route::get('/seniority', [HomeController::class, 'seniority'])->name('seniority');
Route::get('/officers', [HomeController::class, 'officers'])->name('officers');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/donation', [HomeController::class, 'donation'])->name('donation');
Route::post('/donation', [HomeController::class, 'processDonation'])->name('donation.process');

// Tools Routes
Route::prefix('tools')->name('tools.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Public\ToolsController::class, 'index'])->name('index');
    Route::get('/compress-pdf', [\App\Http\Controllers\Public\ToolsController::class, 'compressPdf'])->name('compress-pdf');
    Route::get('/hindi-converter', [\App\Http\Controllers\Public\ToolsController::class, 'hindiConverter'])->name('hindi-converter');
    Route::get('/image-resizer', [\App\Http\Controllers\Public\ToolsController::class, 'imageResizer'])->name('image-resizer');
    Route::get('/add-page-numbers', [\App\Http\Controllers\Public\ToolsController::class, 'addPageNumbers'])->name('add-page-numbers');
    Route::get('/word-to-pdf', [\App\Http\Controllers\Public\ToolsController::class, 'wordToPdf'])->name('word-to-pdf');
    Route::get('/jpg-to-pdf', [\App\Http\Controllers\Public\ToolsController::class, 'jpgToPdf'])->name('jpg-to-pdf');
});

Auth::routes();

// Redirect admin to dashboard if they go to /admin
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\Auth\AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\Auth\AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [\App\Http\Controllers\Admin\Auth\AdminLoginController::class, 'logout'])->name('logout');
});

// Employee/User Panel Routes
Route::prefix('employee')->name('employee.')->group(function () {
    // Auth Routes
    Route::get('/login', [\App\Http\Controllers\Employee\Auth\MemberLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Employee\Auth\MemberLoginController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Employee\Auth\MemberLoginController::class, 'logout'])->name('logout');

    // Registration Routes
    Route::get('/register', [\App\Http\Controllers\Employee\Auth\MemberRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Employee\Auth\MemberRegisterController::class, 'register']);

    // Dashboard (Protected)
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Employee\EmployeeDashboardController::class, 'index'])->name('dashboard');
    });
});

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
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

    // Frontend Content Management (Specialized)
    Route::get('/content-manager', [\App\Http\Controllers\Admin\FrontendAdminController::class, 'index'])->name('frontend.index');
    Route::get('/content-manager/slider', [\App\Http\Controllers\Admin\FrontendAdminController::class, 'slider'])->name('frontend.slider');

    // User Management (State Admin Only)
    Route::middleware(['role:state_admin'])->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserManagementController::class);
        Route::resource('divisions', \App\Http\Controllers\Admin\DivisionController::class);
        Route::resource('districts', \App\Http\Controllers\Admin\DistrictController::class);
        Route::resource('hero-slides', \App\Http\Controllers\Admin\AdminHeroSlideController::class);
    });
    
    // System Features (State Admin)
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs.index');
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});
