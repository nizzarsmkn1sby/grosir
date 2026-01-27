<x-guest-layout>
    <style>
        :root {
            --alibaba-orange: #FF5000;
            --alibaba-orange-hover: #E64500;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, rgba(255, 80, 0, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(255, 80, 0, 0.1) 0px, transparent 50%);
            padding: 2rem 1.5rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .login-card-premium {
            background: white;
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            padding: 4rem;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        .login-card-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--alibaba-orange), #ff8c00);
        }

        .login-header-premium {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .auth-logo-premium {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--alibaba-orange);
            letter-spacing: -0.05em;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .login-title-premium {
            font-size: 1.75rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .login-subtitle-premium {
            color: #6b7280;
            font-size: 0.9375rem;
            font-weight: 500;
        }

        .form-label-premium {
            display: block;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.75rem;
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-input-premium {
            width: 100%;
            padding: 1.125rem 1.25rem;
            border: 2px solid #f3f4f6;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f9fafb;
            font-weight: 500;
        }

        .form-input-premium:focus {
            outline: none;
            border-color: var(--alibaba-orange);
            background: white;
            box-shadow: 0 0 0 4px rgba(255, 80, 0, 0.08);
        }

        .btn-auth-premium {
            width: 100%;
            background: var(--alibaba-orange);
            color: white;
            padding: 1.125rem;
            border: none;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.125rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 20px rgba(255, 80, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .btn-auth-premium:hover {
            transform: translateY(-3px);
            background: var(--alibaba-orange-hover);
            box-shadow: 0 15px 30px rgba(255, 80, 0, 0.3);
        }

        .forgot-link-premium {
            display: block;
            text-align: right;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.8125rem;
            font-weight: 700;
            margin-top: -1rem;
            margin-bottom: 2rem;
            transition: color 0.2s;
        }

        .forgot-link-premium:hover {
            color: var(--alibaba-orange);
        }

        .divider-premium {
            display: flex;
            align-items: center;
            margin: 2.5rem 0;
            color: #9ca3af;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .divider-premium::before,
        .divider-premium::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f3f4f6;
        }

        .divider-premium span {
            padding: 0 1.25rem;
        }

        .social-grid-premium {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .social-tab-premium {
            padding: 0.875rem;
            border: 2px solid #f3f4f6;
            border-radius: 12px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #374151;
            font-size: 1.25rem;
        }

        .social-tab-premium:hover {
            border-color: var(--alibaba-orange);
            color: var(--alibaba-orange);
            background: #fff7f2;
            transform: translateY(-2px);
        }

        .footer-auth-premium {
            text-align: center;
            color: #6b7280;
            font-size: 0.9375rem;
            font-weight: 500;
        }

        .footer-auth-premium a {
            color: var(--alibaba-orange);
            font-weight: 800;
            text-decoration: none;
            margin-left: 0.25rem;
        }

        .footer-auth-premium a:hover {
            text-decoration: underline;
        }

        .alert-premium {
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-left: 4px solid;
        }

        .alert-premium-success {
            background: #ecfdf5;
            color: #065f46;
            border-color: #10b981;
        }

        @media (max-width: 640px) {
            .login-card-premium {
                padding: 3rem 1.5rem;
            }
        }
    </style>

    <div class="login-container">
        <div class="login-card-premium">
            <!-- Header -->
            <div class="login-header-premium">
                <div class="auth-logo-premium">GrosirKu.</div>
                <h1 class="login-title-premium">Selamat Datang Kembali</h1>
                <p class="login-subtitle-premium">Masuk ke terminal sourcing Anda</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert-premium alert-premium-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="form-label-premium">Alamat Email Bisnis</label>
                    <input id="email" 
                           class="form-input-premium" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           autocomplete="username"
                           placeholder="nama@perusahaan.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label-premium">Kata Sandi</label>
                    <input id="password" 
                           class="form-input-premium" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="Min. 8 karakter">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link-premium">
                        Lupa kata sandi?
                    </a>
                @endif

                <!-- Remember Me -->
                <div class="flex items-center mb-8">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                    <label for="remember_me" class="ml-2 text-sm font-bold text-gray-500">Ingat Akun Saya</label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-auth-premium">
                    <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="divider-premium">
                <span>Atau Masuk Melalui</span>
            </div>

            <!-- Social Login Grid -->
            <div class="social-grid-premium">
                <a href="{{ route('social.redirect', 'google') }}" class="social-tab-premium" title="Google">
                    <i class="fab fa-google text-[#ea4335]"></i>
                </a>
                <a href="{{ route('social.redirect', 'discord') }}" class="social-tab-premium" title="Discord">
                    <i class="fab fa-discord text-[#5865f2]"></i>
                </a>
                <a href="{{ route('social.redirect', 'github') }}" class="social-tab-premium" title="GitHub">
                    <i class="fab fa-github text-[#181717]"></i>
                </a>
            </div>

            <!-- Register Link -->
            <div class="footer-auth-premium">
                Belum punya akun sourcing? 
                <a href="{{ route('register') }}">Daftar Gratis</a>
            </div>
        </div>
    </div>
</x-guest-layout>
