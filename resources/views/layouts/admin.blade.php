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
                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Main Menu</small>
                <div class="mt-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.officers.index') }}" class="nav-link {{ request()->routeIs('admin.officers.*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i> Officers
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice"></i> Orders
                    </a>
                    <a href="{{ route('admin.circulars.index') }}" class="nav-link {{ request()->routeIs('admin.circulars.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> Circulars
                    </a>
                    <a href="{{ route('admin.elections.index') }}" class="nav-link {{ request()->routeIs('admin.elections.*') ? 'active' : '' }}">
                        <i class="fas fa-vote-yea"></i> Elections
                    </a>
                    <a href="{{ route('admin.elections.vote.index') }}" class="nav-link {{ request()->is('admin/voting*') ? 'active' : '' }}">
                        <i class="fas fa-ballot"></i> Voting Portal
                    </a>
                    <a href="{{ route('admin.donations.index') }}" class="nav-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                        <i class="fas fa-hand-holding-heart"></i> Donations
                    </a>
                    <a href="{{ route('admin.news.index') }}" class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i> News & Notices
                    </a>
                    <a href="{{ route('admin.seniority.index') }}" class="nav-link {{ request()->routeIs('admin.seniority.*') ? 'active' : '' }}">
                        <i class="fas fa-list-ol"></i> Seniority Lists
                    </a>
                    <a href="{{ route('admin.portal-forms.index') }}" class="nav-link {{ request()->routeIs('admin.portal-forms.*') ? 'active' : '' }}">
                        <i class="fas fa-th"></i> Home Page Grid
                    </a>
                    <a href="{{ route('admin.hero-slides.index') }}" class="nav-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                        <i class="fas fa-images"></i> Hero Sliders
                    </a>
                </div>

                @if(auth()->user()->role === 'state_admin')
                <div class="mt-4">
                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">System Admin</small>
                    <div class="mt-2">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i> User Management
                        </a>
                        <a href="{{ route('admin.divisions.index') }}" class="nav-link {{ request()->routeIs('admin.divisions.*') ? 'active' : '' }}">
                            <i class="fas fa-map-marked-alt"></i> Divisions & Districts
                        </a>
                        <a href="{{ route('admin.logs.index') }}" class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                            <i class="fas fa-history"></i> Activity Logs
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </nav>

        <!-- Main Content -->
        <div id="content">
            <header class="admin-header d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">@yield('page_title', 'Dashboard')</h5>
                <div class="d-flex align-items-center">
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
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2 text-muted"></i> Profile</a></li>
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
