<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Educational Ministerial Officers Uttarakhand</title>
    
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
            perspective: 1000px;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 43, 92, 0.1);
            overflow: hidden;
            border: none;
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .login-header {
            background-color: var(--gov-dark);
            padding: 35px 40px;
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
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--gov-blue);
            box-shadow: 0 0 0 3px rgba(26, 92, 150, 0.15);
        }

        .btn-admin {
            background-color: var(--gov-blue);
            color: white;
            padding: 12px;
            font-weight: 700;
            width: 100%;
            border-radius: 6px;
            border: none;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-admin:hover {
            background-color: var(--gov-dark);
            box-shadow: 0 5px 15px rgba(0, 43, 92, 0.3);
            color: white;
        }

        .login-footer {
            padding: 20px 40px;
            background-color: #f8fafc;
            border-top: 1px solid #edf2f7;
            text-align: center;
            font-size: 0.85rem;
            color: #718096;
        }

        .login-footer a {
            color: var(--gov-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .error-badge {
            background-color: #fff5f5;
            color: #c53030;
            padding: 10px;
            border-radius: 6px;
            border-left: 4px solid #c53030;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Emblem_of_Uttarakhand.svg/1024px-Emblem_of_Uttarakhand.svg.png" alt="UK Emblem">
                <h4 class="mb-0 fw-bold">Admin Portal</h4>
                <p class="small opacity-75 mb-0">Uttarakhand Educational Officers</p>
            </div>
            
            <div class="login-body">
                @if ($errors->any())
                    <div class="error-badge">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admin.login.post') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" id="email" class="form-control border-start-0" placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small text-muted" for="remember">
                                Remember me
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-admin">
                        LOGIN TO DASHBOARD <i class="fas fa-arrow-right ms-2 fs-7"></i>
                    </button>
                </form>
            </div>

            <div class="login-footer">
                <p class="mb-0">&copy; {{ date('Y') }} Govt of Uttarakhand. <br> Protected Administrative Access.</p>
                <div class="mt-2">
                    <a href="{{ url('/') }}"><i class="fas fa-home me-1"></i> Public Portal</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
