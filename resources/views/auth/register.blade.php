<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | SmartCBT</title>
    <link rel="icon" type="image/svg+xml" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.7.2/svgs/solid/graduation-cap.svg">
    
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

        .register-card {
            width: 100%;
            max-width: 550px;
            z-index: 10;
            animation: slideUp 0.6s ease-out;
            padding: 2.5rem;
        }
        
        .register-logo i {
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
        
        <div class="glass-card register-card text-center">
            <div class="register-logo mb-4">
                <i class="fas fa-user-plus text-primary"></i>
                <h2 class="fw-bold text-dark mb-0">Create Account</h2>
                <p class="text-muted small">Join SmartCBT today</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3 text-start small p-3 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="text-start">
                @csrf
                
                <div class="row gx-3">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-medium text-dark small ms-1">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" value="{{ old('name') }}" required placeholder="John Doe">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-medium text-dark small ms-1">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com">
                        </div>
                    </div>
                </div>

                <div class="row gx-3">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label fw-medium text-dark small ms-1">Phone Number <span class="text-muted fw-normal">(Optional)</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-phone"></i></span>
                            <input type="tel" class="form-control border-start-0 ps-0" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+1 234 567 8900">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="date_of_birth" class="form-label fw-medium text-dark small ms-1">Date of Birth <span class="text-muted fw-normal">(Optional)</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-calendar-alt"></i></span>
                            <input type="date" class="form-control border-start-0 ps-0" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        </div>
                    </div>
                </div>

                <div class="row gx-3">
                    <div class="col-md-6 mb-4">
                        <label for="password" class="form-label fw-medium text-dark small ms-1">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" required placeholder="Create a password">
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="password_confirmation" class="form-label fw-medium text-dark small ms-1">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0" id="password_confirmation" name="password_confirmation" required placeholder="Confirm password">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm mb-4">
                    Create Account
                </button>

                <p class="text-center small text-muted mb-0">
                    Already have an account? <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">Sign in here</a>
                </p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
