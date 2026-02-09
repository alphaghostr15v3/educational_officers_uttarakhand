<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Educational Ministerial Officers Uttarakhand</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --uk-saffron: #FF9933;
            --uk-green: #138808;
            --uk-blue: #000080;
            --gov-blue: #1a5c96;
            --gov-dark: #002b5c;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-image: linear-gradient(135deg, rgba(26, 92, 150, 0.05) 0%, rgba(0, 43, 92, 0.05) 100%);
        }

        .login-container {
            width: 100%;
            max-width: 450px;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 43, 92, 0.1);
            overflow: hidden;
            border: none;
        }

        .login-header {
            background-color: var(--gov-dark);
            padding: 30px;
            text-align: center;
            color: white;
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--uk-saffron) 0%, #ffffff 50%, var(--uk-green) 100%);
        }

        .login-header img {
            height: 60px;
            margin-bottom: 15px;
        }

        .login-body {
            padding: 40px;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
        }

        .btn-primary {
            background-color: var(--gov-blue);
            color: white;
            padding: 12px;
            font-weight: 700;
            width: 100%;
            border: none;
            border-radius: 6px;
        }

        .btn-primary:hover {
            background-color: var(--gov-dark);
        }

        .login-footer {
            padding: 20px;
            background-color: #f8fafc;
            border-top: 1px solid #edf2f7;
            text-align: center;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="{{ asset('images/association_logo.png') }}" alt="Logo">
                <h4 class="mb-0 fw-bold">{{ __('Reset Password') }}</h4>
                <p class="small opacity-75 mb-0">Uttarakhand Educational Officers</p>
            </div>
            
            <div class="login-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-envelope"></i></span>
                            <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        @error('email')
                            <span class="invalid-feedback d-block mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                            <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Min. 8 characters">
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block mt-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-check-double"></i></span>
                            <input id="password-confirm" type="password" class="form-control border-start-0" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat new password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Reset Password') }}
                    </button>
                </form>
            </div>

            <div class="login-footer">
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm px-4"><i class="fas fa-arrow-left me-1"></i> Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>
