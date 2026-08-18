<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SmartCBT</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Premium UI CSS -->
    <link rel="stylesheet" href="{{ asset('css/premium-ui.css') }}">
    
    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-body);
            position: relative;
            overflow: hidden;
            padding: 2rem 1rem;
        }

        .auth-bg-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            top: 0; left: 0;
        }

        .auth-shape-1 {
            width: 600px; height: 600px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(168, 85, 247, 0.2));
            top: -200px; right: -200px;
        }

        .auth-shape-2 {
            width: 500px; height: 500px;
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.2), rgba(99, 102, 241, 0.2));
            bottom: -150px; left: -150px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            z-index: 10;
            animation: slideUp 0.6s ease-out;
            padding: 2.5rem;
        }
        
        .login-logo i {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-bg-shapes">
            <div class="bg-shape auth-shape-1"></div>
            <div class="bg-shape auth-shape-2"></div>
        </div>
        
        <div class="glass-card login-card text-center">
            <div class="login-logo mb-4">
                <i class="fas fa-graduation-cap text-primary"></i>
                <h2 class="fw-bold text-dark mb-0">Welcome Back</h2>
                <p class="text-muted small">Sign in to continue to SmartCBT</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 text-start small p-2 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" style="padding: 0.75rem"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3 text-start small p-3 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="text-start">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label fw-medium text-dark small ms-1">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1 ms-1">
                        <label for="password" class="form-label fw-medium text-dark small mb-0">Password</label>
                        <a href="{{ route('password.request') }}" class="text-primary text-decoration-none small fw-medium">Forgot?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" id="password"
                            name="password" required placeholder="Enter your password">
                    </div>
                </div>

                <div class="mb-4 form-check ms-1">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small text-muted user-select-none" for="remember">Keep me signed in</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm mb-4">
                    Sign In
                </button>

                <p class="text-center small text-muted mb-0">
                    Don't have an account? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">Create one</a>
                </p>
            </form>
            
            <div class="mt-4 pt-4 border-top border-light border-opacity-50 text-start bg-light bg-opacity-50 p-3 rounded-3">
                <p class="text-muted small fw-semibold mb-2"><i class="fas fa-info-circle me-1"></i> Demo Credentials</p>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-secondary small">Admin:</span>
                    <span class="text-dark small font-monospace">admin@smartcbt.com / password123</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-secondary small">User:</span>
                    <span class="text-dark small font-monospace">user@smartcbt.com / password123</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
