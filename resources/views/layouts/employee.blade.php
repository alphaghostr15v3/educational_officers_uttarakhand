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
                <li>
                    <a href="#"><i class="fas fa-user"></i> My Profile</a>
                </li>
                <li>
                    <a href="{{ route('orders') }}"><i class="fas fa-file-alt"></i> Official Orders</a>
                </li>
                <li>
                    <a href="{{ route('seniority') }}"><i class="fas fa-list-ol"></i> Seniority Lists</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-bullhorn"></i> Circulars</a>
                </li>
                <li class="mt-4">
                    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();" class="text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
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
                        <div class="dropdown profile-dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                                <span class="me-2 d-none d-sm-inline">{{ auth()->user()->name }}</span>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff" alt="User">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-user-circle me-2"></i> Profile</a></li>
                                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
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
