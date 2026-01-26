<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'GrosirKu'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --secondary: #10b981;
            --accent: #f59e0b;
            --dark: #1f2937;
            --gray: #6b7280;
            --light: #f3f4f6;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        main {
            min-height: calc(100vh - 64px);
            padding: 2rem 0;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--secondary);
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border-left: 4px solid var(--primary);
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="container">
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container">
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="container">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            {{ session('info') }}
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('header')
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer style="background: var(--dark); color: white; padding: 3rem 0; margin-top: 4rem;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                <div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">GrosirKu</h3>
                    <p style="color: #9ca3af;">Platform belanja grosir online terpercaya dengan harga terbaik.</p>
                </div>
                <div>
                    <h4 style="font-size: 1.125rem; margin-bottom: 1rem;">Menu</h4>
                    <ul style="list-style: none;">
                        <li style="margin-bottom: 0.5rem;"><a href="{{ route('home') }}" style="color: #9ca3af; text-decoration: none;">Home</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="{{ route('products.index') }}" style="color: #9ca3af; text-decoration: none;">Products</a></li>
                        @auth
                        <li style="margin-bottom: 0.5rem;"><a href="{{ route('cart.index') }}" style="color: #9ca3af; text-decoration: none;">Cart</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 style="font-size: 1.125rem; margin-bottom: 1rem;">Kontak</h4>
                    <ul style="list-style: none;">
                        <li style="margin-bottom: 0.5rem; color: #9ca3af;"><i class="fas fa-phone"></i> +62 812-3456-7890</li>
                        <li style="margin-bottom: 0.5rem; color: #9ca3af;"><i class="fas fa-envelope"></i> info@grosirku.com</li>
                        <li style="margin-bottom: 0.5rem; color: #9ca3af;"><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #374151;">
                <p style="color: #9ca3af;">&copy; {{ date('Y') }} GrosirKu. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
