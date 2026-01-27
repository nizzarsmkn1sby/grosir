@extends('layouts.public')

@section('title', 'Terminal Sourcing - GrosirKu Digital Ecosystem')

@push('styles')
<style>
    /* Home Terminal Premium Styles */
    .alibaba-hero {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 32px;
        margin-top: 40px;
        height: 520px;
    }

    .hero-sidebar {
        background: white;
        border-radius: 24px;
        padding: 2rem 0;
        box-shadow: var(--shadow-premium);
        border: 1px solid #f1f5f9;
        display: none;
    }

    @media (min-width: 1024px) {
        .hero-sidebar {
            display: block;
        }
    }

    .hero-sidebar-item {
        padding: 1rem 2.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #475569;
        text-decoration: none !important;
        font-size: 0.9375rem;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-sidebar-item:hover {
        background: #fff7f2;
        color: var(--alibaba-orange);
        padding-left: 3rem;
    }

    .hero-banner {
        background: #0f172a;
        background-image: 
            radial-gradient(at 0% 0%, rgba(255, 80, 0, 0.1) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(255, 80, 0, 0.05) 0px, transparent 50%);
        border-radius: 32px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        padding: 0 6rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.2);
    }

    .hero-banner-content {
        max-width: 650px;
        z-index: 2;
    }

    .hero-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: rgba(255, 80, 0, 0.1);
        border: 1px solid rgba(255, 80, 0, 0.2);
        border-radius: 100px;
        color: var(--alibaba-orange);
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 2rem;
    }

    .hero-banner-content h1 {
        font-size: 4.5rem;
        font-weight: 900;
        color: white;
        margin-bottom: 2rem;
        line-height: 1;
        letter-spacing: -0.04em;
    }

    .hero-banner-content p {
        font-size: 1.25rem;
        color: #94a3b8;
        margin-bottom: 3.5rem;
        font-weight: 600;
    }

    .hero-banner-btn {
        background: var(--alibaba-orange);
        color: white;
        padding: 1.25rem 4rem;
        border-radius: 100px;
        text-decoration: none !important;
        font-weight: 900;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 15px 30px rgba(255, 80, 0, 0.25);
        font-size: 1.125rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .hero-banner-btn:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(255, 80, 0, 0.35);
        background: #ff6a00;
    }

    /* Category Matrices */
    .alibaba-cat-card-premium {
        background: white;
        padding: 3rem 2rem;
        border-radius: 24px;
        text-align: center;
        text-decoration: none !important;
        color: #1e293b;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #f1f5f9;
    }

    .alibaba-cat-card-premium:hover {
        border-color: var(--alibaba-orange);
        transform: translateY(-12px);
        box-shadow: var(--shadow-hover);
    }

    .cat-icon-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto 2rem;
        background: #f8fafc;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #1e293b;
        transition: all 0.4s ease;
    }

    .alibaba-cat-card-premium:hover .cat-icon-wrapper {
        background: var(--alibaba-orange);
        color: white;
        transform: rotate(-5deg);
    }

    /* Trust Terminal */
    .trust-terminal {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin: 6rem 0;
        background: #0f172a;
        padding: 4rem;
        border-radius: 40px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .trust-item {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .trust-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--alibaba-orange);
        font-size: 1.25rem;
    }

    .trust-content h4 {
        color: white;
        font-weight: 800;
        font-size: 0.9375rem;
        margin-bottom: 4px;
    }

    .trust-content p {
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* Product Matrix Overrides */
    .alibaba-prod-card {
        border-radius: 28px !important;
        background: white !important;
        padding: 12px;
    }

    .prod-img-wrapper {
        border-radius: 20px !important;
    }

    .prod-price {
        color: #0f172a !important;
        font-size: 1.375rem !important;
    }

    .prod-action {
        border-radius: 100px !important;
        font-size: 0.75rem !important;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 1rem !important;
        background: #f8fafc !important;
        border: none !important;
    }

    @media (max-width: 1024px) {
        .alibaba-hero { grid-template-columns: 1fr; height: auto; }
        .hero-banner { padding: 5rem 3rem; }
        .hero-banner-content h1 { font-size: 3rem; }
    }
</style>
@endpush

@section('content')
<!-- Sourcing Terminal Hero -->
<div class="alibaba-hero">
    <div class="hero-sidebar">
        @foreach($categories->take(8) as $category)
        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="hero-sidebar-item">
            <span>{{ $category->name }}</span>
            <i class="fas fa-arrow-right text-[10px] opacity-20"></i>
        </a>
        @endforeach
        <div class="mt-8 px-10">
            <a href="{{ route('products.index') }}" class="text-[10px] font-black text-orange-600 uppercase tracking-widest hover:underline">Semua Protokol Sourcing</a>
        </div>
    </div>
    
    <div class="hero-banner">
        <div class="hero-banner-content">
            <div class="hero-label">
                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                Official Wholesale Terminal v.1.0
            </div>
            <h1>Bangun Ekosistem <br><span class="text-orange-500">Bisnis Global.</span></h1>
            <p>Akses ribuan manufaktur tangan pertama dengan jaminan keamanan transaksi terintegrasi.</p>
            <a href="{{ route('products.index') }}" class="hero-banner-btn">
                Mulai Pengadaan Barang
                <i class="fas fa-chevron-right text-sm"></i>
            </a>
        </div>
        <div class="hidden xl:block ml-auto">
            <img src="https://img.alicdn.com/imgextra/i4/O1CN01P9S6f71WzY6z6f9r6_!!6000000002875-2-tps-600-600.png" alt="Terminal" class="w-[450px] opacity-40 grayscale brightness-150">
        </div>
    </div>
</div>

<!-- Category Matrix Section -->
<div class="alibaba-section-title">
    <span class="text-2xl font-black">Matrix Kategori</span>
    <a href="{{ route('products.index') }}" class="more-link font-bold uppercase tracking-widest border-b-2 border-orange-500 pb-1">Master Protokol</a>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-8">
    @foreach($categories as $category)
    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="alibaba-cat-card-premium">
        <div class="cat-icon-wrapper">
            @if($category->name == 'Elektronik')
                <i class="fas fa-microchip"></i>
            @elseif($category->name == 'Fashion')
                <i class="fas fa-gem"></i>
            @elseif($category->name == 'Makanan & Minuman')
                <i class="fas fa-box-open"></i>
            @else
                <i class="fas fa-cubes"></i>
            @endif
        </div>
        <h3 class="font-black text-sm uppercase tracking-wider">{{ $category->name }}</h3>
    </a>
    @endforeach
</div>

<!-- Trust Terminal Hub -->
<div class="trust-terminal">
    <div class="trust-item">
        <div class="trust-icon"><i class="fas fa-shield-check"></i></div>
        <div class="trust-content">
            <h4>Trade Protocol</h4>
            <p>Keamanan dana terjamin sistem.</p>
        </div>
    </div>
    <div class="trust-item">
        <div class="trust-icon"><i class="fas fa-building"></i></div>
        <div class="trust-content">
            <h4>Factory Sourcing</h4>
            <p>Langsung dari jalur manufaktur.</p>
        </div>
    </div>
    <div class="trust-item">
        <div class="trust-icon"><i class="fas fa-truck-container"></i></div>
        <div class="trust-content">
            <h4>Global Logistics</h4>
            <p>Jaringan distribusi tanpa batas.</p>
        </div>
    </div>
    <div class="trust-item">
        <div class="trust-icon"><i class="fas fa-headphones-alt"></i></div>
        <div class="trust-content">
            <h4>Specialist Support</h4>
            <p>Pendampingan bisnis 24/7.</p>
        </div>
    </div>
</div>

<!-- Featured Manifest -->
<div class="alibaba-section-title">
    <span class="text-2xl font-black">Manifest Unggulan</span>
    <a href="{{ route('products.index') }}" class="more-link font-bold">Log Lengkap <i class="fas fa-arrow-right ml-2 text-[10px]"></i></a>
</div>

<div class="alibaba-products mb-24">
    @foreach($featuredProducts as $product)
    <div class="alibaba-prod-card shadow-sm hover:shadow-xl transition-all">
        <a href="{{ route('products.show', $product->id) }}">
            <div class="prod-img-wrapper">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                @else
                    <i class="fas fa-industry text-4xl opacity-10"></i>
                @endif
            </div>
        </a>
        <div class="prod-content">
            <a href="{{ route('products.show', $product->id) }}" class="no-underline text-inherit">
                <div class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-2">{{ $product->category->name }}</div>
                <h3 class="prod-name font-black">{{ $product->name }}</h3>
                <div class="prod-price font-black mt-4">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="prod-moq mt-2 font-bold opacity-40">Standard Unit Pricing</div>
            </a>
            <a href="{{ route('products.show', $product->id) }}" class="btn-terminal-primary w-full mt-6">
                Buka Terminal Produk
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection
