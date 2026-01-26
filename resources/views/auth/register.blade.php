<x-guest-layout>
    <style>
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem 1rem;
        }

        .register-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            width: 100%;
            max-width: 500px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-logo {
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

        .register-logo i {
            font-size: 2.5rem;
            color: white;
        }

        .register-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .register-subtitle {
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
            margin-bottom: 1.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
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

        .login-link {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .login-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .register-card {
                padding: 2rem 1.5rem;
            }

            .register-title {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="register-container">
        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <div class="register-logo">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="register-title">Create Account</h1>
                <p class="register-subtitle">Join us and start shopping!</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-user"></i> Full Name
                    </label>
                    <input id="name" 
                           class="form-input" 
                           type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autofocus 
                           autocomplete="name"
                           placeholder="Enter your full name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

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
                           autocomplete="new-password"
                           placeholder="Create a strong password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock"></i> Confirm Password
                    </label>
                    <input id="password_confirmation" 
                           class="form-input" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           placeholder="Confirm your password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn-primary">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>Or sign up with</span>
            </div>

            <!-- Social Login Buttons -->
            <div class="social-login">
                <!-- Google -->
                <a href="{{ route('social.redirect', 'google') }}" class="social-btn google" title="Sign up with Google">
                    <i class="fab fa-google"></i>
                </a>

                <!-- Discord -->
                <a href="{{ route('social.redirect', 'discord') }}" class="social-btn discord" title="Sign up with Discord">
                    <i class="fab fa-discord"></i>
                </a>

                <!-- GitHub -->
                <a href="{{ route('social.redirect', 'github') }}" class="social-btn github" title="Sign up with GitHub">
                    <i class="fab fa-github"></i>
                </a>
            </div>

            <!-- Login Link -->
            <div class="login-link">
                Already have an account? 
                <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>
</x-guest-layout>
