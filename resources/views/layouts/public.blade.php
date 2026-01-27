<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'GrosirKu'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Premium Design System -->
    <style>
        :root {
            --alibaba-orange: #FF5000;
            --alibaba-orange-hover: #E64500;
            --alibaba-black: #0f172a;
            --alibaba-gray: #f8fafc;
            --text-main: #1e293b;
            --text-secondary: #64748b;
            --bg-body: #f8fafc;
            --shadow-premium: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
            --shadow-hover: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --radius-xl: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            letter-spacing: -0.01em;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        main {
            min-height: 85vh;
            padding-bottom: 5rem;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.9375rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #D1FAE5;
        }

        .alert-error {
            background: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FEE2E2;
        }

        .alert-info {
            background: #EFF6FF;
            color: #1E40AF;
            border: 1px solid #DBEAFE;
        }

        /* Alibaba Style Components */
        .alibaba-section-title {
            margin: 3rem 0 1.5rem;
            font-size: 1.75rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: space-between;
            letter-spacing: -0.02em;
        }

        .more-link {
            font-size: 14px;
            color: #666;
            text-decoration: none;
            font-weight: 400;
        }

        .more-link:hover {
            color: var(--alibaba-orange);
        }

        .alibaba-products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .alibaba-prod-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            text-decoration: none;
            color: var(--text-main);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .alibaba-prod-card:hover {
            box-shadow: 0 40px 80px -20px rgba(255, 80, 0, 0.15);
            border-color: var(--alibaba-orange);
            border-width: 1px;
            transform: translateY(-12px);
        }

        .prod-img-wrapper {
            aspect-ratio: 1/1;
            background: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #d1d5db;
            position: relative;
            overflow: hidden;
        }

        .prod-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .alibaba-prod-card:hover .prod-img-wrapper img {
            transform: scale(1.1);
        }

        .prod-content {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .prod-name {
            font-size: 0.9375rem;
            line-height: 1.5;
            font-weight: 500;
            height: 2.8em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 0.75rem;
            color: var(--text-main);
            transition: color 0.3s ease;
        }

        .alibaba-prod-card:hover .prod-name {
            color: var(--alibaba-orange);
        }

        .prod-price {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--alibaba-orange);
            margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }

        .prod-moq {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Standardized Terminal Button System */
        .btn-terminal, 
        .btn-terminal-primary, 
        .btn-terminal-secondary, 
        .btn-terminal-outline, 
        .btn-terminal-danger, 
        .btn-terminal-success {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 1rem 1.5rem;
            border-radius: 100px;
            font-weight: 800;
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            text-decoration: none !important;
            white-space: nowrap;
        }

        .btn-terminal-primary {
            background: var(--alibaba-orange);
            color: white !important;
            box-shadow: 0 10px 25px rgba(255, 80, 0, 0.25);
        }

        .btn-terminal-primary:hover {
            transform: translateY(-4px);
            background: var(--alibaba-orange-hover);
            box-shadow: 0 15px 35px rgba(255, 80, 0, 0.35);
        }

        .btn-terminal-secondary {
            background: var(--alibaba-black);
            color: white !important;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.2);
        }

        .btn-terminal-secondary:hover {
            transform: translateY(-4px);
            background: #1e293b;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.3);
        }

        .btn-terminal-outline {
            background: transparent !important;
            border: 2px solid #e2e8f0;
            color: var(--text-main) !important;
        }

        .btn-terminal-outline:hover {
            border-color: var(--alibaba-orange);
            color: var(--alibaba-orange) !important;
            background: #fff7f2 !important;
        }

        .btn-terminal-danger {
            background: #ef4444;
            color: white !important;
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.2);
        }

        .btn-terminal-danger:hover {
            background: #dc2626;
            box-shadow: 0 15px 35px rgba(239, 68, 68, 0.3);
        }

        .prod-action {
            width: 100%;
            margin-top: auto;
            border-radius: 100px;
            font-weight: 800;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 1rem;
            text-align: center;
            transition: all 0.4s;
            border: 1px solid #f1f5f9;
            background: #f8fafc;
            color: #64748b !important;
            text-decoration: none;
        }

        .alibaba-prod-card:hover .prod-action {
            background: var(--alibaba-orange);
            color: white !important;
            border-color: var(--alibaba-orange);
            box-shadow: 0 10px 20px rgba(255, 80, 0, 0.2);
            transform: translateY(-3px);
        }

        /* Fixed Mobile Nav */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white !important;
            border-top: 1px solid #eee !important;
            display: flex !important;
            justify-content: space-around !important;
            padding: 12px 0 !important;
            z-index: 2000 !important;
            box-shadow: 0 -2px 15px rgba(0,0,0,0.08) !important;
        }

        .mobile-nav-item {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-decoration: none !important;
            color: #666 !important;
            font-size: 0.7rem !important;
            font-weight: 600 !important;
            gap: 4px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .mobile-nav-item i {
            font-size: 1.25rem !important;
        }

        .mobile-nav-item.active {
            color: var(--alibaba-orange) !important;
        }

        @media (min-width: 768px) {
            .mobile-bottom-nav {
                display: none !important;
            }
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
    <footer class="bg-[#0f172a] text-white mt-32 border-t border-white/5">
        <!-- Newsletter Section -->
        <div class="border-b border-white/5">
            <div class="container py-16">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                    <div class="max-w-xl">
                        <div class="text-[10px] font-black text-orange-500 uppercase tracking-[0.3em] mb-3">Newsletter & Market Updates</div>
                        <h3 class="text-3xl font-black tracking-tight mb-4">Stay Synchronized with the <br><span class="text-orange-500">Global Supply Chain.</span></h3>
                        <p class="text-gray-400 font-medium">Get real-time manifest updates and exclusive factory sourcing protocols directly to your terminal.</p>
                    </div>
                    <div class="w-full lg:w-auto">
                        <form class="flex flex-col sm:flex-row gap-4 p-2 bg-white/5 rounded-[32px] border border-white/10">
                            <input type="email" placeholder="Enter business email..." class="bg-transparent border-none text-white px-6 py-4 outline-none w-full sm:w-[320px] font-bold text-sm placeholder:text-gray-600">
                            <button class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-full font-black text-xs uppercase tracking-widest transition-all">Subscribe Protocol</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer Links -->
        <div class="container pt-20 pb-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-16 lg:gap-8">
                <!-- Branding Column -->
                <div class="lg:col-span-4 space-y-10">
                    <div>
                        <div class="text-4xl font-black tracking-tighter text-orange-500 mb-2">GrosirKu.</div>
                        <div class="text-[10px] font-black text-gray-500 uppercase tracking-[0.4em]">Wholesale Terminal v.1.0</div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed font-bold max-w-sm">
                        Enterprise-grade sourcing ecosystem designed for professional procurement. Connecting verified manufacturers with global trade networks.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-11 h-11 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center text-gray-400 hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all duration-300"><i class="fab fa-facebook-f text-sm"></i></a>
                        <a href="#" class="w-11 h-11 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center text-gray-400 hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all duration-300"><i class="fab fa-twitter text-sm"></i></a>
                        <a href="#" class="w-11 h-11 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center text-gray-400 hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all duration-300"><i class="fab fa-linkedin-in text-sm"></i></a>
                        <a href="#" class="w-11 h-11 rounded-2xl bg-white/5 border border-white/5 flex items-center justify-center text-gray-400 hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all duration-300"><i class="fab fa-instagram text-sm"></i></a>
                    </div>
                </div>

                <!-- Link Columns -->
                <div class="lg:col-span-2">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-500 mb-10">Supply Chain</h4>
                    <ul class="space-y-5 text-sm font-black text-gray-500">
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Sourcing Hub</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Verified Factory</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Logistics Node</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Trade Assurance</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-500 mb-10">Corporate</h4>
                    <ul class="space-y-5 text-sm font-black text-gray-500">
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">About Ecosystem</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Investor Relations</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Global Careers</a></li>
                        <li><a href="#" class="hover:text-white hover:translate-x-1 inline-block transition-all">Legal Terminal</a></li>
                    </ul>
                </div>

                <!-- Support Column -->
                <div class="lg:col-span-4">
                    <div class="bg-white/5 p-10 rounded-[40px] border border-white/5 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-orange-500/20 transition-all"></div>
                        <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-500 mb-8 flex items-center gap-3">
                            <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                            Customer Operations
                        </h4>
                        <div class="space-y-6">
                            <div>
                                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Central Node Contact</p>
                                <a href="mailto:ops@grosirku.com" class="text-xl font-black block hover:text-orange-500 transition-colors">ops@grosirku.com</a>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Operational Hotline</p>
                                <div class="text-lg font-black">+62 21 8888 9999</div>
                            </div>
                            <div class="pt-6 border-t border-white/5">
                                <div class="flex items-center gap-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                                    <i class="fas fa-clock text-orange-500"></i>
                                    24/7 Monitoring Active
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="mt-24 pt-10 border-t border-white/5 flex flex-wrap items-center justify-center gap-12 opacity-30 grayscale transition-all hover:opacity-80 hover:grayscale-0">
                <div class="flex items-center gap-3"><i class="fas fa-shield-alt text-2xl"></i> <span class="text-[10px] font-black uppercase tracking-widest">Trade Assurance</span></div>
                <div class="flex items-center gap-3"><i class="fas fa-lock text-2xl"></i> <span class="text-[10px] font-black uppercase tracking-widest">Secure Payment</span></div>
                <div class="flex items-center gap-3"><i class="fas fa-truck text-2xl"></i> <span class="text-[10px] font-black uppercase tracking-widest">Global Logistics</span></div>
                <div class="flex items-center gap-3"><i class="fas fa-check-circle text-2xl"></i> <span class="text-[10px] font-black uppercase tracking-widest">Verified Supplier</span></div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="bg-[#0b1120] py-10">
            <div class="container">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="text-[10px] font-black text-gray-600 uppercase tracking-widest">
                        &copy; 2024-{{ date('Y') }} GrosirKu Digital Ecosystem. <span class="text-gray-800 ml-2">All rights reserved.</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-8 text-[10px] font-black text-gray-600 uppercase tracking-widest">
                        <a href="#" class="hover:text-white transition-colors">Privacy Protocol</a>
                        <a href="#" class="hover:text-white transition-colors">Usage Policy</a>
                        <a href="#" class="hover:text-white transition-colors">Data Security</a>
                        <a href="#" class="hover:text-white transition-colors">SLA Agreement</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
