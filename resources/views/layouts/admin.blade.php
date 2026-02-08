<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Educational Officers Portal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @stack('styles')
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="logo">
                <div class="d-flex align-items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Emblem_of_Uttarakhand.svg/1024px-Emblem_of_Uttarakhand.svg.png" style="height: 40px;" class="me-2">
                    <span class="fw-bold text-white small text-uppercase">UK-EDU Portal</span>
                </div>
            </div>
            <div class="p-3">
                @if(auth()->user()->role === 'state_admin')
                    <!-- Super Admin Menu -->
                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Main</small>
                    <div class="mt-2 mb-4">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> Dashboard
                        </a>
                    </div>

                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Master Data</small>
                    <div class="mt-2 mb-4">
                        <a href="{{ route('admin.divisions.index') }}" class="nav-link {{ request()->routeIs('admin.divisions.*') ? 'active' : '' }}">
                            <i class="fas fa-map-marked-alt"></i> Divisions & Districts
                        </a>
                        <a href="{{ route('admin.schools.index') }}" class="nav-link {{ request()->routeIs('admin.schools.*') ? 'active' : '' }}">
                            <i class="fas fa-school"></i> Approve Schools
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i> Create Users
                        </a>
                        <a href="{{ route('admin.staff.index') }}" class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                            <i class="fas fa-id-badge"></i> Staff Master Data
                        </a>
                    </div>

                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Organizational Structure</small>
                    <div class="mt-2 mb-4">
                        <a href="{{ route('admin.designations.index') }}" class="nav-link {{ request()->routeIs('admin.designations.*') ? 'active' : '' }}">
                            <i class="fas fa-sitemap"></i> Designations
                        </a>
                        <a href="{{ route('admin.pay-grades.index') }}" class="nav-link {{ request()->routeIs('admin.pay-grades.*') ? 'active' : '' }}">
                            <i class="fas fa-money-bill-wave"></i> Pay Grades
                        </a>
                        <a href="{{ route('admin.posts.index') }}" class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                            <i class="fas fa-briefcase"></i> Sanctioned Posts
                        </a>
                    </div>

                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Approvals & Services</small>
                    <div class="mt-2 mb-4">
                        <a href="{{ route('admin.transfers.index') }}" class="nav-link {{ request()->routeIs('admin.transfers.*') ? 'active' : '' }}">
                            <i class="fas fa-exchange-alt"></i> Transfer Approval
                        </a>
                        <a href="{{ route('admin.promotions.index') }}" class="nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                            <i class="fas fa-user-check"></i> Promotion Approval
                        </a>
                        <a href="{{ route('admin.elections.index') }}" class="nav-link {{ request()->routeIs('admin.elections.*') ? 'active' : '' }}">
                            <i class="fas fa-vote-yea"></i> Election Voting
                        </a>
                        <a href="{{ route('admin.election-duties.index') }}" class="nav-link {{ request()->routeIs('admin.election-duties.*') ? 'active' : '' }}">
                            <i class="fas fa-user-tag"></i> Duty Assignments
                        </a>
                         <a href="{{ route('admin.donations.index') }}" class="nav-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                            <i class="fas fa-hand-holding-heart"></i> Welfare Fund
                        </a>
                    </div>

                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Downloads & Uploads</small>
                    <div class="mt-2 mb-4">
                        <a href="{{ route('admin.seniority.index') }}" class="nav-link {{ request()->routeIs('admin.seniority.*') ? 'active' : '' }}">
                            <i class="fas fa-list-ol"></i> Seniority Lists
                        </a>
                        <a href="{{ route('admin.circulars.index') }}" class="nav-link {{ request()->routeIs('admin.circulars.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i> Circulars
                        </a>
                         <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="fas fa-file-invoice"></i> Govt Orders
                        </a>
                    </div>

                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">CMS (Website)</small>
                    <div class="mt-2 mb-4">
                         <a href="{{ route('admin.news.index') }}" class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper"></i> News & Notices
                        </a>
                        <a href="{{ route('admin.ticker.index') }}" class="nav-link {{ request()->routeIs('admin.ticker.*') ? 'active' : '' }}">
                            <i class="fas fa-rss"></i> News Ticker
                        </a>
                        <a href="{{ route('admin.gallery.index') }}" class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                            <i class="fas fa-images"></i> Photo Gallery
                        </a>
                        <a href="{{ route('admin.hero-slides.index') }}" class="nav-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                            <i class="fas fa-camera"></i> Hero Sliders
                        </a>
                         <a href="{{ route('admin.portal-forms.index') }}" class="nav-link {{ request()->routeIs('admin.portal-forms.*') ? 'active' : '' }}">
                            <i class="fas fa-th"></i> Grid/Downloads
                        </a>
                    </div>
                    <div class="mt-2 mb-4">
                        <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                            <i class="fas fa-bell"></i> Send Notifications
                        </a>
                        <a href="{{ route('admin.logs.index') }}" class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                            <i class="fas fa-history"></i> System Reports
                        </a>
                    </div>

                @elseif(auth()->user()->role === 'division_admin')
                    <!-- Division Admin Menu -->
                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Main Menu</small>
                    <div class="mt-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> Division Dashboard
                        </a>
                        <a href="{{ route('admin.schools.index') }}" class="nav-link {{ request()->routeIs('admin.schools.*') ? 'active' : '' }}">
                            <i class="fas fa-school"></i> View District Data
                        </a>
                         <a href="{{ route('admin.transfers.index') }}" class="nav-link {{ request()->routeIs('admin.transfers.*') ? 'active' : '' }}">
                            <i class="fas fa-exchange-alt"></i> Approve/Recommend
                        </a>
                         <a href="{{ route('admin.promotions.index') }}" class="nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                            <i class="fas fa-award"></i> Promotion Recommendation
                        </a>
                         <a href="{{ route('admin.vacancy.index') }}" class="nav-link {{ request()->routeIs('admin.vacancy.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Vacancy Overview
                        </a>
                         <a href="{{ route('admin.logs.index') }}" class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i> Division Reports
                        </a>
                        <a href="{{ route('admin.circulars.index') }}" class="nav-link {{ request()->routeIs('admin.circulars.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i> Circulars (Distribute)
                        </a>
                    </div>
                @else
                    <!-- District Admin Menu -->
                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Main Menu</small>
                    <div class="mt-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.schools.index') }}" class="nav-link {{ request()->routeIs('admin.schools.*') ? 'active' : '' }}">
                            <i class="fas fa-school"></i> School Management
                        </a>
                        <a href="{{ route('admin.staff.index') }}" class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                            <i class="fas fa-chalkboard-teacher"></i> Staff & Service Book
                        </a>
                         <a href="{{ route('admin.transfers.index') }}" class="nav-link {{ request()->routeIs('admin.transfers.*') ? 'active' : '' }}">
                            <i class="fas fa-exchange-alt"></i> Transfer Forwarding
                        </a>
                         <a href="{{ route('admin.leaves.index') }}" class="nav-link {{ request()->routeIs('admin.leaves.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i> Leave Approval
                        </a>
                         <a href="{{ route('admin.promotions.index') }}" class="nav-link {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                            <i class="fas fa-award"></i> Promotion Records
                        </a>
                         <a href="{{ route('admin.seniority.index') }}" class="nav-link {{ request()->routeIs('admin.seniority.*') ? 'active' : '' }}">
                            <i class="fas fa-list-ol"></i> Seniority Lists
                        </a>
                        <a href="{{ route('admin.elections.index') }}" class="nav-link {{ request()->routeIs('admin.elections.*') ? 'active' : '' }}">
                            <i class="fas fa-vote-yea"></i> Election Duty
                        </a>
                        <a href="{{ route('admin.circulars.index') }}" class="nav-link {{ request()->routeIs('admin.circulars.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i> Notices Upload
                        </a>
                         <a href="{{ route('admin.logs.index') }}" class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar"></i> District Reports
                        </a>
                    </div>
                @endif
            </div>
        </nav>

        <!-- Main Content -->
        <div id="content">
            <header class="admin-header d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">@yield('page_title', 'Dashboard')</h5>
                <div class="d-flex align-items-center">
                    @php
                        $notifications = \App\Models\Notification::where(function($q) {
                            $q->where('target_role', auth()->user()->role)
                              ->orWhere('user_id', auth()->id())
                              ->orWhereNull('target_role');
                        })->latest()->take(5)->get();
                        $unreadCount = \App\Models\Notification::where(function($q) {
                            $q->where('target_role', auth()->user()->role)
                              ->orWhere('user_id', auth()->id())
                              ->orWhereNull('target_role');
                        })->where('is_read', false)->count();
                    @endphp

                    <div class="dropdown me-4">
                        <a href="#" class="text-dark position-relative" data-bs-toggle="dropdown">
                            <i class="fas fa-bell fs-5"></i>
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-0" style="width: 300px;">
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">Notifications</h6>
                                <a href="{{ route('admin.notifications.index') }}" class="small text-primary text-decoration-none">View All</a>
                            </div>
                            <div class="notification-list" style="max-height: 300px; overflow-y: auto;">
                                @forelse($notifications as $notif)
                                    <div class="p-3 border-bottom {{ $notif->is_read ? '' : 'bg-light' }}">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-info-circle text-{{ $notif->type }} mt-1"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="fw-bold small">{{ $notif->title }}</div>
                                                <div class="text-muted small text-truncate" style="max-width: 200px;">{{ $notif->message }}</div>
                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $notif->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted">
                                        <small>No new updates</small>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="me-4 text-end">
                        <div class="fw-bold small">{{ auth()->user()->name }}</div>
                        <span class="badge {{ auth()->user()->role == 'state_admin' ? 'badge-state' : (auth()->user()->role == 'division_admin' ? 'badge-division' : 'badge-district') }} small" style="font-size: 0.65rem;">
                            {{ strtoupper(str_replace('_', ' ', auth()->user()->role)) }}
                        </span>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle text-dark" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=1e3a8a&color=fff" class="rounded-circle" style="width: 35px;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user me-2 text-muted"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-bold"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <div class="container-fluid px-4 pb-5">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('admin_content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
