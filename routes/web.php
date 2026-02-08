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
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::middleware(['auth'])->group(function () {
    Route::get('/work-forms', [\App\Http\Controllers\Public\WorkFormController::class, 'index'])->name('work-forms');
    Route::get('/work-forms/{workType}', [\App\Http\Controllers\Public\WorkFormController::class, 'byType'])->name('work-forms.by-type');
});


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
        
        // Profile Routes
        Route::get('/profile', [\App\Http\Controllers\Employee\EmployeeProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [\App\Http\Controllers\Employee\EmployeeProfileController::class, 'update'])->name('profile.update');

        // Service Book Routes
        Route::get('/service-book', [\App\Http\Controllers\Employee\EmployeeServiceBookController::class, 'index'])->name('service-book');
        Route::get('/service-book/correction', [\App\Http\Controllers\Employee\EmployeeServiceBookController::class, 'requestCorrection'])->name('service-book.correction');
        Route::post('/service-book/correction', [\App\Http\Controllers\Employee\EmployeeServiceBookController::class, 'submitCorrection'])->name('service-book.correction.submit');
        // Leave Routes
        Route::get('/leaves', [\App\Http\Controllers\Employee\EmployeeLeaveController::class, 'index'])->name('leaves.index');
        Route::get('/leaves/create', [\App\Http\Controllers\Employee\EmployeeLeaveController::class, 'create'])->name('leaves.create');
        Route::post('/leaves', [\App\Http\Controllers\Employee\EmployeeLeaveController::class, 'store'])->name('leaves.store');

        // Transfer Routes
        Route::get('/transfers', [\App\Http\Controllers\Employee\EmployeeTransferController::class, 'index'])->name('transfers.index');
        Route::get('/transfers/create', [\App\Http\Controllers\Employee\EmployeeTransferController::class, 'create'])->name('transfers.create');
        Route::post('/transfers', [\App\Http\Controllers\Employee\EmployeeTransferController::class, 'store'])->name('transfers.store');

        // Circulars Route
        Route::get('/circulars', [\App\Http\Controllers\Employee\EmployeeCircularController::class, 'index'])->name('circulars.index');

        // Notifications Route
        Route::get('/notifications', [\App\Http\Controllers\Employee\EmployeeNotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{notification}/read', [\App\Http\Controllers\Employee\EmployeeNotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    });
});

// School Routes
Route::prefix('school')->name('school.')->group(function () {
    // Auth Routes
    Route::get('/login', [\App\Http\Controllers\School\Auth\SchoolLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\School\Auth\SchoolLoginController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\School\Auth\SchoolLoginController::class, 'logout'])->name('logout');

    // Registration Routes
    Route::get('/register', [\App\Http\Controllers\School\Auth\SchoolRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\School\Auth\SchoolRegisterController::class, 'register']);

    // Dashboard (Protected)
    Route::middleware(['auth', 'school'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\School\SchoolDashboardController::class, 'index'])->name('dashboard');
        
        // Staff Management
        Route::resource('staff', \App\Http\Controllers\School\SchoolStaffController::class);
        
        // Student Strength
        Route::get('/students', [\App\Http\Controllers\School\SchoolStudentStrengthController::class, 'index'])->name('students.index');
        Route::post('/students', [\App\Http\Controllers\School\SchoolStudentStrengthController::class, 'update'])->name('students.update');
        
        // Infrastructure
        Route::get('/infrastructure', [\App\Http\Controllers\School\SchoolInfrastructureController::class, 'index'])->name('infrastructure.index');
        Route::post('/infrastructure', [\App\Http\Controllers\School\SchoolInfrastructureController::class, 'update'])->name('infrastructure.update');
        
        // Placeholders for now for other services
        // Transfer Application
        Route::get('/transfers', [\App\Http\Controllers\School\SchoolTransferController::class, 'create'])->name('transfers.index');
        Route::get('/transfers/apply', [\App\Http\Controllers\School\SchoolTransferController::class, 'create'])->name('transfers.create');
        Route::post('/transfers/apply', [\App\Http\Controllers\School\SchoolTransferController::class, 'store'])->name('transfers.store');

        // Leave Application
        Route::get('/leaves', [\App\Http\Controllers\School\SchoolLeaveController::class, 'create'])->name('leaves.index');
        Route::get('/leaves/apply', [\App\Http\Controllers\School\SchoolLeaveController::class, 'create'])->name('leaves.create');
        Route::post('/leaves/apply', [\App\Http\Controllers\School\SchoolLeaveController::class, 'store'])->name('leaves.store');

        // Documents
        Route::resource('documents', \App\Http\Controllers\School\SchoolDocumentController::class)->only(['index', 'store', 'destroy']);

        // Circulars
        Route::get('/circulars', [\App\Http\Controllers\School\SchoolCircularController::class, 'index'])->name('circulars.index');
        Route::get('/circulars/{circular}', [\App\Http\Controllers\School\SchoolCircularController::class, 'show'])->name('circulars.show');
        
        Route::post('/logout', [\App\Http\Controllers\School\Auth\SchoolLoginController::class, 'logout'])->name('logout');
    });
});


// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // School Management (District Admin)
    Route::get('staff/export', [\App\Http\Controllers\Admin\DistrictStaffController::class, 'export'])->name('staff.export');
    Route::resource('schools', \App\Http\Controllers\Admin\DistrictSchoolController::class);
    Route::get('schools/{school}/login', [\App\Http\Controllers\Admin\DistrictSchoolController::class, 'createLogin'])->name('schools.login.create');
    Route::post('schools/{school}/login', [\App\Http\Controllers\Admin\DistrictSchoolController::class, 'storeLogin'])->name('schools.login.store');
    Route::resource('staff', \App\Http\Controllers\Admin\DistrictStaffController::class);
    Route::resource('transfers', \App\Http\Controllers\Admin\AdminTransferController::class);
    Route::post('transfers/{transfer}/status', [\App\Http\Controllers\Admin\AdminTransferController::class, 'updateStatus'])->name('transfers.status.update');
    Route::resource('promotions', \App\Http\Controllers\Admin\AdminPromotionController::class);
    Route::post('promotions/{promotion}/status', [\App\Http\Controllers\Admin\AdminPromotionController::class, 'updateStatus'])->name('promotions.status.update');
    Route::get('/vacancies', [\App\Http\Controllers\Admin\AdminVacancyController::class, 'index'])->name('vacancy.index');
    Route::resource('leaves', \App\Http\Controllers\Admin\AdminLeaveController::class);
    Route::resource('officers', \App\Http\Controllers\Admin\AdminOfficerController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\AdminOrderController::class);
    Route::resource('circulars', \App\Http\Controllers\Admin\AdminCircularController::class);
    
    // Organizational Structure Management
    Route::resource('designations', \App\Http\Controllers\Admin\AdminDesignationController::class);
    Route::resource('pay-grades', \App\Http\Controllers\Admin\AdminPayGradeController::class);
    Route::resource('posts', \App\Http\Controllers\Admin\AdminPostController::class);
    Route::resource('gallery', \App\Http\Controllers\Admin\AdminGalleryController::class)->except(['show', 'edit', 'update']);
    Route::post('gallery/{gallery}/toggle', [\App\Http\Controllers\Admin\AdminGalleryController::class, 'toggleStatus'])->name('gallery.toggle');
    Route::resource('news', \App\Http\Controllers\Admin\AdminNewsController::class);
    
    // News Ticker Management (Separate from News & Notices)
    Route::resource('ticker', \App\Http\Controllers\Admin\AdminTickerController::class);
    Route::post('ticker/{ticker}/toggle', [\App\Http\Controllers\Admin\AdminTickerController::class, 'toggleStatus'])->name('ticker.toggle');
    
    Route::resource('seniority', \App\Http\Controllers\Admin\AdminSeniorityController::class);
    Route::resource('work-forms', \App\Http\Controllers\Admin\AdminWorkFormController::class);
    Route::resource('portal-forms', \App\Http\Controllers\Admin\AdminPortalFormController::class);
    Route::resource('elections', \App\Http\Controllers\Admin\AdminElectionController::class);
    Route::resource('election-duties', \App\Http\Controllers\Admin\AdminElectionDutyController::class);
    Route::get('donations/export', [\App\Http\Controllers\Admin\AdminDonationController::class, 'export'])->name('donations.export');
    Route::resource('notifications', \App\Http\Controllers\Admin\AdminNotificationController::class);
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

    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profile.update');
});
