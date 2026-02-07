<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $site_settings['site_title'] ?? config('app.name', 'Educational Officers Portal') }} - Uttarakhand</title>
    
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
    @auth
        @if(in_array(auth()->user()->role, ['state_admin', 'division_admin', 'district_admin']))
        <div class="bg-dark text-white py-1 sticky-top" style="z-index: 1060; opacity: 0.95; border-bottom: 2px solid var(--uk-saffron);">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="small">
                    <i class="fas fa-user-shield me-1"></i> Logged in as: <span class="fw-bold">{{ auth()->user()->name }}</span>
                </div>
                <div class="d-flex gap-3">
                    <a href="{{ route('admin.frontend.index') }}" class="btn btn-warning btn-sm py-0 small fw-bold"><i class="fas fa-edit me-1"></i> Content Manager</a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm py-0 small"><i class="fas fa-columns me-1"></i> Dashboard</a>
                </div>
            </div>
        </div>
        @endif
    @endauth

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container d-flex justify-content-between">
            <div>
                <span class="me-3"><i class="fas fa-phone-alt me-1"></i> {{ $site_settings['contact_phone'] ?? '+91-135-271XXXX' }}</span>
                <span><i class="fas fa-envelope me-1"></i> {{ $site_settings['contact_email'] ?? 'education-uk@gov.in' }}</span>
            </div>
            <div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none me-3"><i class="fas fa-th-large me-1"></i> Admin Panel</a>
                @else
                    <a href="{{ route('admin.login') }}" class="text-white text-decoration-none me-3"><i class="fas fa-lock me-1"></i> Admin Login</a>
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
                        <div class="fw-bold fs-5 text-uppercase" style="color: var(--gov-blue); line-height: 1.2;">{{ $site_settings['site_title'] ?? 'Educational Ministerial Officers' }}</div>
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
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('officers') ? 'active' : '' }}" href="{{ route('officers') }}">Officers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('orders') ? 'active' : '' }}" href="{{ route('orders') }}">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('senority*') ? 'active' : '' }}" href="{{ route('seniority') }}">Seniority</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('tools*') ? 'active' : '' }}" href="{{ route('tools.index') }}">Tools</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('donation') ? 'active' : '' }}" href="{{ route('donation') }}">Donation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                        </li>
                        
                        <!-- Login Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown">
                                <li><a class="dropdown-item" href="{{ route('employee.login') }}"><i class="fas fa-users me-2"></i> Employee Login</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.login') }}"><i class="fas fa-user-shield me-2"></i> Admin Login</a></li>
                            </ul>
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
    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container pb-5">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <h3 class="fw-bold mb-3">EMOU</h3>
                    <div class="small text-white-50 mb-3 text-uppercase fw-bold" style="letter-spacing: 0.5px; line-height: 1.4;">
                        एजुकेशनल मिनिस्ट्रीयल ऑफिसर्स एसोसिएशन उत्तराखण्ड<br>
                        <span class="text-white small opacity-75">EDUCATIONAL MINISTERIAL OFFICERS ASSOCIATION UTTRAKHAND</span>
                    </div>
                    <div class="small mb-2">
                        <span class="fw-bold text-white">Phone:</span> <span class="text-white-50">{{ $site_settings['contact_phone'] ?? '+91 9411550251' }}</span>
                    </div>
                    <div class="small">
                        <span class="fw-bold text-white">Email:</span> <span class="text-white-50">{{ $site_settings['contact_email'] ?? 'websitehelp@emou.co.in' }}</span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="fw-bold mb-3">Useful Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://education.uk.gov.in/" target="_blank" class="footer-link text-decoration-none">Education Department</a></li>
                        <li><a href="https://uk.gov.in/" target="_blank" class="footer-link text-decoration-none">Uttarakhand Government</a></li>
                        <li><a href="#" class="footer-link text-decoration-none">Pay Commission</a></li>
                        <li><a href="#" class="footer-link text-decoration-none">GPF Information</a></li>
                        <li><a href="#" class="footer-link text-decoration-none">DA Rates</a></li>
                        <li><a href="#" class="footer-link text-decoration-none">RTI Portal</a></li>
                        <li><a href="#" class="footer-link text-decoration-none">Grievance Portal</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="fw-bold mb-3">Our Services</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link text-decoration-none">Member Services & Support</a></li>
                        <li><a href="#" class="footer-link text-decoration-none">Pay Commission & Benefits</a></li>
                        <li><a href="#" class="footer-link text-decoration-none">Administrative Services</a></li>
                        <li><a href="#" class="footer-link text-decoration-none">Digital Services</a></li>
                        <li><a href="#" class="footer-link text-decoration-none">Training & Development</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3">Our Newsletter</h5>
                    <p class="small text-white-50">Subscribe to our newsletter and get the latest information straight to your inbox!</p>
                    <form action="#" method="POST" class="mt-3">
                        <div class="input-group" style="background: rgba(255,255,255,0.05); border-radius: 30px; padding: 5px;">
                            <input type="email" class="form-control border-0 bg-transparent text-white px-4" placeholder="Your Email" style="box-shadow: none;">
                            <button class="btn btn-success px-4" type="submit" style="background-color: var(--uk-green); border-radius: 30px; border: none;">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="copyright-bar text-center">
            <div class="container text-white-50 small">
                <div class="mb-2">
                    &copy; {{ date('Y') }} <span class="fw-bold text-white text-uppercase">Educational Ministerial Officers Uttarakhand</span> All Rights Reserved
                </div>
                <div>
                    Site designed, developed and hosted by : <span class="fw-bold text-white">VIKAS DABRAL</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myCarousel = document.querySelector('#heroCarousel');
            if(myCarousel) {
                var carousel = new bootstrap.Carousel(myCarousel, {
                    interval: 5000,
                    ride: 'carousel',
                    pause: 'hover'
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
