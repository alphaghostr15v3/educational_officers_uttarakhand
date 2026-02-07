@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #1a5c96 0%, #003057 100%);
        --accent-color: #FF9933;
    }

    body {
        background-color: #f0f2f5;
        overflow-x: hidden;
    }

    .login-container {
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .login-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        width: 100%;
        max-width: 1000px;
        min-height: 600px;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-sidebar {
        flex: 1;
        background: url('{{ asset("images/about_association.png") }}');
        background-size: cover;
        background-position: center;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .login-sidebar::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(26, 92, 150, 0.8), rgba(0, 48, 87, 0.9));
        z-index: 1;
    }

    .login-sidebar-content {
        position: relative;
        z-index: 10;
    }

    .login-sidebar h2 {
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .login-sidebar p {
        font-size: 1.1rem;
        opacity: 0.9;
        line-height: 1.6;
    }

    .login-form-section {
        flex: 1;
        padding: 4rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #fff;
    }

    .form-header {
        margin-bottom: 2.5rem;
    }

    .form-header h3 {
        font-weight: 700;
        color: #1a5c96;
        margin-bottom: 0.5rem;
    }

    .form-header p {
        color: #6c757d;
    }

    .form-control-custom {
        border: 2px solid #eef0f2;
        border-radius: 12px;
        padding: 0.8rem 1.2rem;
        transition: all 0.3s;
        font-size: 1rem;
    }

    .form-control-custom:focus {
        border-color: #1a5c96;
        box-shadow: 0 0 0 4px rgba(26, 92, 150, 0.1);
        outline: none;
    }

    .btn-login {
        background: var(--primary-gradient);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 1rem;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s;
        margin-top: 1rem;
        box-shadow: 0 10px 20px rgba(26, 92, 150, 0.2);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(26, 92, 150, 0.3);
        color: #fff;
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .input-icon-wrapper {
        position: relative;
    }

    .input-icon-wrapper i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        transition: color 0.3s;
    }

    .input-icon-wrapper .form-control-custom {
        padding-left: 3rem;
    }

    .input-icon-wrapper .form-control-custom:focus + i {
        color: #1a5c96;
    }

    .social-login-separator {
        display: flex;
        align-items: center;
        margin: 2rem 0;
        color: #adb5bd;
    }

    .social-login-separator::before,
    .social-login-separator::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #eef0f2;
    }

    .social-login-separator span {
        padding: 0 1rem;
        font-size: 0.9rem;
    }

    @media (max-width: 991px) {
        .login-sidebar { display: none; }
        .login-card { max-width: 500px; }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <!-- Sidebar with message/branding -->
        <div class="login-sidebar">
            <div class="login-sidebar-content">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Emblem_of_Uttarakhand.svg/1024px-Emblem_of_Uttarakhand.svg.png" 
                     alt="UK Logo" style="height: 80px; margin-bottom: 2rem;">
                <h2>Employee Portal</h2>
                <p>Educational Ministerial Officers Association Uttarakhand. Access your professional employee resources, updates, and more.</p>
                <div class="mt-5">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-white bg-opacity-20 p-2 me-3">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <span>Departmental Orders & Notifications</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-white bg-opacity-20 p-2 me-3">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <span>Seniority Lists & Career Tracking</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login Form Section -->
        <div class="login-form-section">
            <div class="form-header text-center">
                <h3>Employee Login</h3>
                <p>Welcome back, Officer! Please enter your credentials.</p>
            </div>

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('employee.login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-bold small text-muted text-uppercase">Email Address</label>
                    <div class="input-icon-wrapper">
                        <input id="email" type="email" class="form-control-custom w-100 @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@education-uk.gov.in">
                        <i class="fas fa-envelope"></i>
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block mt-2" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label fw-bold small text-muted text-uppercase">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none small fw-bold" href="{{ route('password.request') }}" style="color: var(--accent-color);">Forgot?</a>
                        @endif
                    </div>
                    <div class="input-icon-wrapper">
                        <input id="password" type="password" class="form-control-custom w-100 @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="current-password" placeholder="••••••••">
                        <i class="fas fa-lock"></i>
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block mt-2" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check custom-checkbox">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-muted" for="remember">
                            Stay signed in for 30 days
                        </label>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-login">
                        Sign In to Your Account
                    </button>
                </div>

                <div class="social-login-separator">
                    <span>New here?</span>
                </div>

                <div class="text-center">
                    <p class="mb-0 text-muted">Don't have an account? <a href="{{ route('employee.register') }}" class="fw-bold text-decoration-none" style="color: #1a5c96;">Create free account</a></p>
                </div>
            </form>
            
            <div class="mt-5 text-center">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted small"><i class="fas fa-arrow-left me-1"></i> Return to Homepage</a>
            </div>
        </div>
    </div>
</div>
@endsection
