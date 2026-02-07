<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - {{ config('app.name', 'EMOU') }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --bg-light: #f8fafc;
            --sidebar-dark: #1e293b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
        }

        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        /* Sidebar */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--sidebar-dark);
            color: #fff;
            transition: all 0.3s;
            min-height: 100vh;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: rgba(0,0,0,0.1);
        }

        #sidebar .sidebar-header h3 {
            color: #fff;
            font-size: 1.25rem;
            margin-bottom: 0;
            font-weight: 700;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li {
            padding: 0 15px;
        }

        #sidebar ul li a {
            padding: 12px 15px;
            font-size: 0.95rem;
            display: block;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: 0.2s;
        }

        #sidebar ul li a:hover {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }

        #sidebar ul li.active > a {
            color: #fff;
            background: var(--primary-color);
        }

        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Content Area */
        #content {
            width: 100%;
            padding: 0;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .navbar {
            padding: 15px 30px;
            background: #fff;
            border: none;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .dashboard-content {
            padding: 30px;
        }

        /* Profile Dropdown */
        .profile-dropdown img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="d-flex align-items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Emblem_of_Uttarakhand.svg/1024px-Emblem_of_Uttarakhand.svg.png" alt="UK Logo" width="40" class="me-2">
                    <h3>Employee Portal</h3>
                </div>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ request()->is('employee/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('employee.dashboard') }}"><i class="fas fa-th-large"></i> Dashboard</a>
                </li>
                <li class="{{ request()->routeIs('employee.service-book*') ? 'active' : '' }}">
                    <a href="{{ route('employee.service-book') }}"><i class="fas fa-book"></i> My Service Book</a>
                </li>
                <li>
                    <a href="{{ route('orders') }}"><i class="fas fa-file-pdf"></i> Official Orders</a>
                </li>
                <li>
                    <a href="{{ route('seniority') }}"><i class="fas fa-list-numbered"></i> Seniority Lists</a>
                </li>
                <li class="{{ request()->routeIs('employee.leaves*') ? 'active' : '' }}">
                    <a href="{{ route('employee.leaves.index') }}"><i class="fas fa-calendar-check"></i> My Leaves</a>
                </li>
                <li class="{{ request()->routeIs('employee.transfers*') ? 'active' : '' }}">
                    <a href="{{ route('employee.transfers.index') }}"><i class="fas fa-exchange-alt"></i> My Transfers</a>
                </li>
                <li class="{{ request()->routeIs('employee.circulars*') ? 'active' : '' }}">
                    <a href="{{ route('employee.circulars.index') }}"><i class="fas fa-bullhorn"></i> Circulars</a>
                </li>
                <li class="{{ request()->routeIs('employee.notifications*') ? 'active' : '' }}">
                    <a href="{{ route('employee.notifications.index') }}"><i class="fas fa-bell"></i> My Notifications</a>
                </li>
                <li>
                    <a href="{{ route('donation') }}"><i class="fas fa-hand-holding-heart"></i> Welfare Fund</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-outline-secondary d-md-none">
                        <i class="fas fa-align-left"></i>
                    </button>

                    <div class="ms-auto d-flex align-items-center">
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

                        <div class="dropdown me-3">
                            <a href="#" class="text-dark position-relative" data-bs-toggle="dropdown">
                                <i class="fas fa-bell fs-5"></i>
                                @if($unreadCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-0" style="width: 300px;">
                                <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
                                    <h6 class="mb-0 fw-bold">Recent Updates</h6>
                                </div>
                                <div class="notification-list" style="max-height: 300px; overflow-y: auto;">
                                    @forelse($notifications as $notif)
                                        <div class="p-3 border-bottom {{ $notif->is_read ? '' : 'bg-white' }}">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-{{ $notif->type }} bg-opacity-10 p-2 rounded">
                                                        <i class="fas fa-info-circle text-{{ $notif->type }}"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="fw-bold small">{{ $notif->title }}</div>
                                                    <div class="text-muted small" style="font-size: 0.8rem;">{{ $notif->message }}</div>
                                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $notif->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-4 text-center text-muted">
                                            <small>No new notifications</small>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="dropdown profile-dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                                <span class="me-2 d-none d-sm-inline">{{ auth()->user()->name }}</span>
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset(auth()->user()->profile_picture) }}" alt="User" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" alt="User">
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                                <li><a class="dropdown-item py-2" href="{{ route('employee.profile') }}"><i class="fas fa-user-circle me-2"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="dashboard-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="close" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarCollapse')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>
</html>
