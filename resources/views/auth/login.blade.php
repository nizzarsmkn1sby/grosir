<x-guest-layout>
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem 1rem;
        }

        .login-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 80px;
            height: 80px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .login-logo i {
            font-size: 2.5rem;
            color: white;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .form-checkbox input {
            width: 18px;
            height: 18px;
            border-radius: 0.25rem;
        }

        .form-checkbox label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 1.5rem;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 1rem;
        }

        .social-login {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            padding: 0.875rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #6b7280;
        }

        .social-btn:hover {
            border-color: #667eea;
            background: #f9fafb;
            transform: translateY(-2px);
        }

        .social-btn i {
            font-size: 1.5rem;
        }

        .social-btn.google:hover {
            border-color: #ea4335;
            color: #ea4335;
        }

        .social-btn.discord:hover {
            border-color: #5865f2;
            color: #5865f2;
        }

        .social-btn.github:hover {
            border-color: #333;
            color: #333;
        }

        .register-link {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .register-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        @media (max-width: 640px) {
            .login-card {
                padding: 2rem 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h1 class="login-title">Welcome Back!</h1>
                <p class="login-subtitle">Login to continue shopping</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="alert alert-success" :status="session('status')" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <input id="email" 
                           class="form-input" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           autocomplete="username"
                           placeholder="your@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input id="password" 
                           class="form-input" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="Enter your password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="form-checkbox">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                </div>
                @endif

                <!-- Login Button -->
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Log In
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>Or continue with</span>
            </div>

            <!-- Social Login Buttons -->
            <div class="social-login">
                <!-- Google Login -->
                <a href="{{ route('social.redirect', 'google') }}" class="social-btn google" title="Login with Google">
                    <i class="fab fa-google"></i>
                </a>

                <!-- Discord Login -->
                <a href="{{ route('social.redirect', 'discord') }}" class="social-btn discord" title="Login with Discord">
                    <i class="fab fa-discord"></i>
                </a>

                <!-- GitHub Login -->
                <a href="{{ route('social.redirect', 'github') }}" class="social-btn github" title="Login with GitHub">
                    <i class="fab fa-github"></i>
                </a>
            </div>

            <!-- Register Link -->
            <div class="register-link">
                Don't have an account? 
                <a href="{{ route('register') }}">Register now</a>
            </div>
        </div>
    </div>
</x-guest-layout>
