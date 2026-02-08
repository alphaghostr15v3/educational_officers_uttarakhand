<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - School Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        .sidebar {
            width: 260px;
            background-color: #ffffff;
            min-height: 100vh;
            border-right: 1px solid #e5e7eb;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .main-content {
            margin-left: 260px;
            padding: 2rem;
        }
        .nav-link {
            color: #4b5563;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: #2563eb;
            background-color: #eff6ff;
            border-right: 3px solid #2563eb;
        }
        .nav-link i {
            width: 24px;
            margin-right: 10px;
        }
        .top-bar {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 2rem;
            margin-left: 260px;
        }
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        .section-header {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9ca3af;
            font-weight: 600;
            padding: 1rem 1.5rem 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar d-flex flex-column">
        <div class="p-4 border-bottom">
            <h4 class="fw-bold text-primary m-0"><i class="fas fa-school me-2"></i>School<span class="text-dark">Panel</span></h4>
        </div>
        
        <nav class="flex-grow-1 overflow-auto py-3">
            <div class="section-header">Main Menu</div>
            
            <a href="{{ route('school.dashboard') }}" class="nav-link {{ request()->routeIs('school.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            <a href="{{ route('school.staff.index') }}" class="nav-link {{ request()->routeIs('school.staff.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i> Staff Details
            </a>

            <a href="{{ route('school.students.index') }}" class="nav-link {{ request()->routeIs('school.students.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i> Student Strength
            </a>



            <div class="section-header">Services</div>

            <a href="{{ route('school.transfers.index') }}" class="nav-link {{ request()->routeIs('school.transfers.*') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt"></i> Apply Transfer
            </a>

            <a href="{{ route('school.leaves.index') }}" class="nav-link {{ request()->routeIs('school.leaves.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Apply Leave
            </a>

            <a href="{{ route('school.documents.index') }}" class="nav-link {{ request()->routeIs('school.documents.*') ? 'active' : '' }}">
                <i class="fas fa-file-upload"></i> Upload Documents
            </a>

            <div class="section-header">Communication</div>

            <a href="{{ route('school.circulars.index') }}" class="nav-link {{ request()->routeIs('school.circulars.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i> Notices & Circulars
            </a>
        </nav>

        <div class="p-3 border-top bg-light">
             <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Clerk' }}&background=2563eb&color=fff" class="rounded-circle" width="32" height="32">
                </div>
                <div class="flex-grow-1 ms-2 overflow-hidden">
                    <div class="small fw-bold text-truncate">{{ auth()->user()->name ?? 'School Clerk' }}</div>
                    <div class="extra-small text-muted text-truncate">{{ auth()->user()->email ?? '' }}</div>
                </div>
                <form action="{{ route('school.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-link text-danger"><i class="fas fa-sign-out-alt"></i></button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <header class="top-bar d-flex justify-content-between align-items-center mb-4 rounded-bottom shadow-sm">
            <h5 class="m-0 fw-bold text-secondary">@yield('page_title', 'Dashboard')</h5>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-primary px-3 py-2 rounded-pill">
                    <i class="fas fa-school me-1"></i> {{ auth()->user()->school->name ?? 'School Panel' }}
                </span>
            </div>
        </header>

        <!-- Page Content -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('school_content')
        
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
