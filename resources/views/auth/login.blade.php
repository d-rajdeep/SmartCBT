<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SmartCBT</title>
    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #3b82f6;
            --lighter-blue: #dbeafe;
            --dark-blue: #1e40af;
            --white: #ffffff;
            --gray-light: #f8fafc;
            --gray-border: #e2e8f0;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --success-green: #10b981;
            --error-red: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--lighter-blue) 0%, var(--primary-blue) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--light-blue));
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 10px;
        }

        .logo-subtitle {
            color: var(--text-light);
            font-size: 1rem;
        }

        .page-title {
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
            font-weight: 500;
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--error-red);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-green);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid var(--gray-border);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--gray-light);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-blue);
            background-color: var(--white);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-input::placeholder {
            color: var(--text-light);
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: var(--white);
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .register-section {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--gray-border);
        }

        .register-text {
            color: var(--text-light);
            margin-bottom: 10px;
        }

        .register-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link:hover {
            color: var(--dark-blue);
            text-decoration: underline;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 25px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .feature-icon {
            color: var(--primary-blue);
            font-weight: bold;
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 25px;
            }

            .logo {
                font-size: 2rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        @media (max-width: 360px) {
            body {
                padding: 15px;
            }

            .login-container {
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo">SmartCBT</div>
            <div class="logo-subtitle">Computer Based Test Platform</div>
        </div>

        <h2 class="page-title">Welcome Back</h2>

        <!-- Error Message -->
        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Email Address" class="form-input" required>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" class="form-input" required>
            </div>

            <button type="submit" class="submit-btn">Login to SmartCBT</button>
        </form>

        <div class="register-section">
            <p class="register-text">Don't have an account?</p>
            <a href="{{ route('register') }}" class="register-link">Create New Account</a>
        </div>

        <div class="features-grid">
            <div class="feature-item">
                <span class="feature-icon">✓</span>
                <span>Secure Platform</span>
            </div>
            <div class="feature-item">
                <span class="feature-icon">✓</span>
                <span>Real-time Results</span>
            </div>
            <div class="feature-item">
                <span class="feature-icon">✓</span>
                <span>Easy to Use</span>
            </div>
            <div class="feature-item">
                <span class="feature-icon">✓</span>
                <span>24/7 Support</span>
            </div>
        </div>
    </div>
</body>

</html>
