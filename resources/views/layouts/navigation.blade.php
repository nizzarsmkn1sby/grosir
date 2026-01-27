@php
    $categories = \App\Models\Category::all();
@endphp

<style>
    /* Premium Alibaba Style Navbar */
    .top-nav {
        background: #f4f4f4;
        font-size: 0.75rem;
        color: #666;
        padding: 8px 0;
        border-bottom: 1px solid #e5e5e5;
        font-weight: 500;
    }

    .header-main {
        background: white;
        padding: 1.5rem 0;
        border-bottom: 1px solid #e5e5e5;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }

    .header-container {
        display: flex;
        align-items: center;
        gap: 3rem;
    }

    .logo-alibaba {
        font-size: 1.875rem;
        font-weight: 900;
        color: var(--alibaba-orange);
        text-decoration: none !important;
        letter-spacing: -0.05em;
        display: flex;
        align-items: center;
        gap: 10px;
        line-height: 1;
        flex-shrink: 0;
    }

    .search-container {
        flex: 1;
        position: relative;
    }

    .search-wrapper {
        display: flex;
        border: 2px solid var(--alibaba-orange);
        border-radius: 50px;
        overflow: hidden;
        background: white;
        transition: all 0.3s ease;
    }

    .search-wrapper:focus-within {
        box-shadow: 0 0 15px rgba(255, 80, 0, 0.15);
    }

    .search-input {
        flex: 1;
        border: none;
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
        outline: none;
        background: transparent;
    }

    .search-button {
        background: var(--alibaba-orange);
        color: white;
        border: none;
        padding: 0 2rem;
        cursor: pointer;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.1em;
    }

    .search-button:hover {
        background: var(--alibaba-orange-hover);
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-shrink: 0;
    }

    .action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none !important;
        color: #333;
        font-size: 0.75rem;
        font-weight: 600;
        gap: 4px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .action-item:hover {
        color: var(--alibaba-orange);
    }

    .action-item i {
        font-size: 1.5rem;
    }

    .nav-categories {
        background: white;
        border-bottom: 1px solid #eee;
        padding: 12px 0;
    }

    .category-nav-list {
        display: flex;
        gap: 2rem;
        list-style: none;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
    }

    .category-nav-list::-webkit-scrollbar {
        display: none;
    }

    .category-nav-item {
        color: #333;
        text-decoration: none !important;
        font-weight: 500;
        font-size: 0.9375rem;
        transition: color 0.3s;
    }

    .category-nav-item:hover {
        color: var(--alibaba-orange);
    }

    .cart-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: var(--alibaba-orange);
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 50px;
        border: 2px solid white;
        font-weight: 800;
    }

    @media (max-width: 1024px) {
        .header-container { gap: 1.5rem; }
        .logo-alibaba span { display: none; }
    }
</style>

<!-- Top Nav -->
<div class="top-nav hidden md:block">
    <div class="container flex justify-between">
        <div class="flex gap-4">
            <span>Platform Grosir Terbesar</span>
            <a href="#" class="hover:text-orange-500">Bantuan</a>
        </div>
        <div class="flex gap-4">
            <a href="#" class="hover:text-orange-500">Bahasa Indonesia</a>
            <a href="#" class="hover:text-orange-500">IDR</a>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="header-main">
    <div class="container header-container">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="logo-alibaba">
            <i class="fas fa-shopping-bag"></i>
            <span>GrosirKu</span>
        </a>

        <!-- Search Bar -->
        <div class="search-container">
            <form action="{{ route('products.index') }}" method="GET" class="search-wrapper">
                <input type="text" name="search" placeholder="Cari ribuan produk grosir..." class="search-input" value="{{ request('search') }}">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                    <span class="hidden md:inline">Cari</span>
                </button>
            </form>
        </div>

        <!-- Actions -->
        <div class="header-actions">
            @auth
                <div class="relative group">
                    <div class="action-item">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil</span>
                    </div>
                    <!-- Simple Dropdown -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 hidden group-hover:block border z-[1002]">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                        </form>
                    </div>
                </div>

                <a href="{{ route('cart.index') }}" class="action-item relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pesanan</span>
                    @php
                        $cartCount = count(session('cart', []));
                    @endphp
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>
            @else
                <a href="{{ route('login') }}" class="action-item">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk</span>
                </a>
                <a href="{{ route('register') }}" class="btn-terminal-primary !py-2 !px-6 !text-[11px] !mt-[-5px]">
                    <span>Daftar</span>
                </a>
            @endauth
        </div>
    </div>
</header>

<!-- Categories Nav -->
<nav class="nav-categories hidden lg:block">
    <div class="container">
        <div class="flex items-center">
            <div class="flex items-center gap-3 font-bold flex-shrink-0 cursor-pointer hover:text-orange-600 mr-12" style="width: 180px;">
                <i class="fas fa-bars"></i>
                Semua Kategori
            </div>
            <div class="flex-1 overflow-hidden">
                <div class="category-nav-list" style="display: flex; gap: 2.5rem; align-items: center;">
                    @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="category-nav-item">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Navigation -->
<div class="mobile-bottom-nav">
    <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('products.index') }}" class="mobile-nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i>
        <span>Kategori</span>
    </a>
    <a href="{{ route('cart.index') }}" class="mobile-nav-item {{ request()->routeIs('cart.*') ? 'active' : '' }}">
        <i class="fas fa-shopping-cart"></i>
        <span>Pesanan</span>
    </a>
    <a href="{{ route('profile.edit') }}" class="mobile-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <i class="fas fa-user"></i>
        <span>Akun</span>
    </a>
</div>
