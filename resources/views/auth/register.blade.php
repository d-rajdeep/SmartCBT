<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | SmartCBT</title>
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

        .register-container {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        .register-container::before {
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
            margin-bottom: 25px;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 8px;
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        @media (min-width: 480px) {
            .form-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        .form-group {
            margin-bottom: 15px;
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

        .password-requirements {
            background-color: var(--lighter-blue);
            border: 1px solid var(--light-blue);
            border-radius: 8px;
            padding: 12px 15px;
            margin: 15px 0;
        }

        .requirements-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 8px;
        }

        .requirement {
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .requirement::before {
            content: '•';
            color: var(--primary-blue);
            font-weight: bold;
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

        .login-section {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--gray-border);
        }

        .login-text {
            color: var(--text-light);
            margin-bottom: 10px;
        }

        .login-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: var(--dark-blue);
            text-decoration: underline;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 25px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .benefit-icon {
            color: var(--primary-blue);
            font-weight: bold;
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .register-container {
                padding: 30px 25px;
            }

            .logo {
                font-size: 2rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .benefits-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 360px) {
            body {
                padding: 15px;
            }

            .register-container {
                padding: 25px 20px;
            }
        }

        /* Error states */
        .form-input.error {
            border-color: var(--error-red);
            background-color: rgba(239, 68, 68, 0.05);
        }

        .form-input.success {
            border-color: var(--success-green);
            background-color: rgba(16, 185, 129, 0.05);
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="logo-section">
            <div class="logo">SmartCBT</div>
            <div class="logo-subtitle">Join Our Learning Platform</div>
        </div>

        <h2 class="page-title">Create Your Account</h2>

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Full Name" class="form-input" required>
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" class="form-input" required>
                </div>
            </div>

            <div class="form-group">
                <input type="tel" name="phone" placeholder="Mobile Number" class="form-input" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" class="form-input" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password"
                        class="form-input" required>
                </div>
            </div>

            <div class="password-requirements">
                <div class="requirements-title">Password Requirements:</div>
                <div class="requirement">At least 8 characters long</div>
                <div class="requirement">Include uppercase and lowercase letters</div>
                <div class="requirement">Include at least one number</div>
            </div>

            <button type="submit" class="submit-btn">Create Account</button>
        </form>

        <div class="login-section">
            <p class="login-text">Already have an account?</p>
            <a href="{{ route('login') }}" class="login-link">Sign In Here</a>
        </div>

        <div class="benefits-grid">
            <div class="benefit-item">
                <span class="benefit-icon">✓</span>
                <span>Unlimited Tests</span>
            </div>
            <div class="benefit-item">
                <span class="benefit-icon">✓</span>
                <span>Progress Tracking</span>
            </div>
            <div class="benefit-item">
                <span class="benefit-icon">✓</span>
                <span>Instant Results</span>
            </div>
            <div class="benefit-item">
                <span class="benefit-icon">✓</span>
                <span>Expert Support</span>
            </div>
        </div>
    </div>

    <script>
        // Simple password confirmation check
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.querySelector('input[name="password"]');
            const confirmPassword = document.querySelector('input[name="password_confirmation"]');

            function checkPasswordMatch() {
                if (confirmPassword.value === '') return;

                if (password.value !== confirmPassword.value) {
                    confirmPassword.classList.add('error');
                    confirmPassword.classList.remove('success');
                } else {
                    confirmPassword.classList.remove('error');
                    confirmPassword.classList.add('success');
                }
            }

            confirmPassword.addEventListener('input', checkPasswordMatch);
            password.addEventListener('input', checkPasswordMatch);
        });
    </script>
</body>

</html>
