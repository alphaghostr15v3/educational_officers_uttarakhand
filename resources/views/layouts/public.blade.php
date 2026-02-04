<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Educational Officers Portal') }} - Uttarakhand</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container d-flex justify-content-between">
            <div>
                <span class="me-3"><i class="fas fa-phone-alt me-1"></i> +91-135-271XXXX</span>
                <span><i class="fas fa-envelope me-1"></i> education-uk@gov.in</span>
            </div>
            <div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none me-3"><i class="fas fa-th-large me-1"></i> Admin Panel</a>
                @else
                    <a href="{{ route('login') }}" class="text-white text-decoration-none me-3"><i class="fas fa-lock me-1"></i> Admin Login</a>
                @endauth
                <a href="#" class="text-white text-decoration-none">Hindi</a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="uk-header">
        <nav class="navbar navbar-expand-lg py-0">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Emblem_of_Uttarakhand.svg/1024px-Emblem_of_Uttarakhand.svg.png" alt="UK Logo" class="me-2">
                    <div>
                        <div class="fw-bold fs-5 text-uppercase" style="color: var(--gov-blue); line-height: 1.2;">Educational Ministerial Officers</div>
                        <div class="small fw-bold text-muted">Government of Uttarakhand</div>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Officers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Notice Board</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Donation</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Department</h5>
                    <p class="small">The Educational Ministerial Officers department of Uttarakhand is dedicated to managing officer data, promotions, and welfare of the ministerial cadre within the education system.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Seniority List</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Latest Circulars</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Transfer Orders</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-2"></i>Election Portal</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled small text-white-50">
                        <li><i class="fas fa-map-marker-alt me-2 text-white"></i> Education Directorate, Uttarakhand</li>
                        <li><i class="fas fa-phone-alt me-2 text-white"></i> +91-135-271XXXX</li>
                        <li><i class="fas fa-envelope me-2 text-white"></i> support-education@uk.gov.in</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
            <div class="text-center small text-white-50">
                &copy; {{ date('Y') }} Department of Education, Uttarakhand. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
