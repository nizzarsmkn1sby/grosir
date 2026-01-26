<style>
    /* Modern Navbar Styling */
    nav {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: none !important;
    }

    nav .max-w-7xl {
        max-width: 1280px;
    }

    /* Logo Styling */
    .nav-logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .nav-logo:hover {
        transform: scale(1.05);
    }

    .nav-logo-icon {
        background: white;
        color: #667eea;
        width: 40px;
        height: 40px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .nav-logo-text {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    /* Navigation Links */
    .nav-links {
        display: flex;
        gap: 0.5rem;
    }

    .nav-link {
        color: white !important;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-bottom: 3px solid transparent;
        position: relative;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
    }

    .nav-link.active {
        background: rgba(255, 255, 255, 0.1);
        border-bottom-color: white;
        font-weight: 600;
    }

    /* Auth Buttons */
    .auth-buttons {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .btn-login {
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .btn-login:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: white;
    }

    .btn-register {
        background: white;
        color: #667eea;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* User Dropdown */
    .user-dropdown-trigger {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .user-dropdown-trigger:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: white;
    }

    /* Mobile Menu Button */
    .mobile-menu-btn {
        color: white !important;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem;
        border-radius: 0.5rem;
    }

    .mobile-menu-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Responsive Mobile Menu */
    .mobile-nav-link {
        color: #1f2937 !important;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border-left: none !important;
    }

    .mobile-nav-link:hover,
    .mobile-nav-link.active {
        background: #f3f4f6;
        color: #667eea !important;
    }

    @media (max-width: 640px) {
        .nav-logo-text {
            font-size: 1.25rem;
        }
    }
</style>

<nav x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="nav-logo">
                    <div class="nav-logo-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <span class="nav-logo-text">GrosirKu</span>
                </a>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden sm:flex sm:ml-10 nav-links">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                    @auth
                    <a href="{{ route('cart.index') }}" class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Cart</span>
                    </a>
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side Navigation -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="user-dropdown-trigger">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-edit"></i> {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <!-- Guest Buttons -->
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-register">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                </div>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="mobile-menu-btn">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 px-4" style="background: white;">
            <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('products.index') }}" class="mobile-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                <span>Products</span>
            </a>
            @auth
            <a href="{{ route('cart.index') }}" class="mobile-nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Cart</span>
            </a>
            @if(Auth::user()->role === 'admin')
            <a href="{{ route('dashboard') }}" class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            @endif
            @endauth
        </div>

        @auth
        <!-- User Options (Mobile) -->
        <div class="pt-4 pb-1 border-t border-gray-200" style="background: white;">
            <div class="px-4 mb-3">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1 px-4">
                <a href="{{ route('profile.edit') }}" class="mobile-nav-link">
                    <i class="fas fa-user-edit"></i>
                    <span>Profile</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-nav-link w-full text-left">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </div>
        @else
        <!-- Guest Options (Mobile) -->
        <div class="pt-4 pb-4 border-t border-gray-200" style="background: white;">
            <div class="space-y-2 px-4">
                <a href="{{ route('login') }}" class="mobile-nav-link">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="mobile-nav-link">
                    <i class="fas fa-user-plus"></i>
                    <span>Register</span>
                </a>
            </div>
        </div>
        @endauth
    </div>
</nav>


