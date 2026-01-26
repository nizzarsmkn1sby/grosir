@extends('layouts.public')

@section('title', 'Beranda - GrosirKu | Belanja Grosir Online Terpercaya')

@push('styles')
<style>
    /* Hero Section */
    .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4rem 0;
        border-radius: 1.5rem;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat;
        background-size: cover;
        opacity: 0.3;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .hero p {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }

    .hero-btn {
        background: white;
        color: #667eea;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .hero-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    }

    /* Categories Grid */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .category-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        text-align: center;
        text-decoration: none;
        color: var(--dark);
        transition: all 0.3s ease;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .category-card:hover::before {
        transform: scaleX(1);
    }

    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .category-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .category-card h3 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .category-card p {
        color: var(--gray);
        font-size: 0.875rem;
    }

    /* Section Title */
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .section-title::after {
        content: '';
        flex: 1;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), transparent);
    }

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .product-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--dark);
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .product-image {
        width: 100%;
        height: 250px;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: var(--gray);
        position: relative;
        overflow: hidden;
    }

    .product-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--accent);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .product-info {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-category {
        color: var(--primary);
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .product-name {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .product-stock {
        color: var(--secondary);
        font-size: 0.875rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .product-btn {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 0.875rem;
        border-radius: 0.5rem;
        text-align: center;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        margin-top: auto;
    }

    .product-btn:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    /* Features Section */
    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin: 4rem 0;
        padding: 3rem 0;
        background: white;
        border-radius: 1.5rem;
        box-shadow: var(--shadow);
    }

    .feature {
        text-align: center;
        padding: 2rem;
    }

    .feature-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .feature h3 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .feature p {
        color: var(--gray);
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2rem;
        }

        .hero p {
            font-size: 1rem;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
        }

        .product-image {
            height: 180px;
        }
    }
</style>
@endpush

@section('content')
<!-- Payment Status Alerts -->
@if(request()->get('status') == 'success')
<div class="alert alert-success mt-4">
    <i class="fas fa-check-circle"></i>
    Pembayaran berhasil! Pesanan Anda sedang kami proses.
</div>
@elseif(request()->get('status') == 'pending')
<div class="alert alert-info mt-4">
    <i class="fas fa-clock"></i>
    Pembayaran tertunda. Silakan selesaikan pembayaran Anda.
</div>
@elseif(request()->get('status') == 'error')
<div class="alert alert-error mt-4">
    <i class="fas fa-times-circle"></i>
    Terjadi kesalahan pada pembayaran. Silakan coba lagi.
</div>
@endif

<!-- Hero Section -->
<div class="hero">
    <div class="hero-content">
        <h1>🛒 Belanja Grosir Jadi Lebih Mudah!</h1>
        <p>Dapatkan harga terbaik untuk kebutuhan usaha dan rumah tangga Anda. Gratis ongkir untuk pembelian di atas Rp 500.000</p>
        <a href="{{ route('products.index') }}" class="hero-btn">
            <i class="fas fa-shopping-bag"></i>
            Mulai Belanja Sekarang
        </a>
    </div>
</div>

<!-- Categories Section -->
<h2 class="section-title">
    <i class="fas fa-th-large"></i>
    Kategori Populer
</h2>

<div class="categories-grid">
    @foreach($categories as $category)
    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="category-card">
        <div class="category-icon">
            @if($category->name == 'Elektronik')
                <i class="fas fa-laptop"></i>
            @elseif($category->name == 'Fashion')
                <i class="fas fa-tshirt"></i>
            @elseif($category->name == 'Makanan & Minuman')
                <i class="fas fa-utensils"></i>
            @elseif($category->name == 'Peralatan Rumah Tangga')
                <i class="fas fa-home"></i>
            @else
                <i class="fas fa-box"></i>
            @endif
        </div>
        <h3>{{ $category->name }}</h3>
        <p>{{ $category->children->count() }} Sub-kategori</p>
    </a>
    @endforeach
</div>

<!-- Featured Products -->
<h2 class="section-title">
    <i class="fas fa-star"></i>
    Produk Unggulan
</h2>

<div class="products-grid">
    @foreach($featuredProducts as $product)
    <div class="product-card">
        <div class="product-image">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <i class="fas fa-box-open"></i>
            @endif
            @if($product->stock_qty < 10)
                <span class="product-badge">Stok Terbatas!</span>
            @endif
        </div>
        <div class="product-info">
            <div class="product-category">
                <i class="fas fa-tag"></i> {{ $product->category->name }}
            </div>
            <h3 class="product-name">{{ $product->name }}</h3>
            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="product-stock">
                <i class="fas fa-check-circle"></i>
                Stok: {{ $product->stock_qty }} unit
            </div>
            <a href="{{ route('products.show', $product->id) }}" class="product-btn">
                <i class="fas fa-eye"></i> Lihat Detail
            </a>
        </div>
    </div>
    @endforeach
</div>

<!-- Features Section -->
<div class="features">
    <div class="feature">
        <div class="feature-icon">
            <i class="fas fa-shipping-fast"></i>
        </div>
        <h3>Pengiriman Cepat</h3>
        <p>Gratis ongkir untuk pembelian di atas Rp 500.000</p>
    </div>
    <div class="feature">
        <div class="feature-icon">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h3>Pembayaran Aman</h3>
        <p>Transaksi dijamin aman dengan sistem enkripsi</p>
    </div>
    <div class="feature">
        <div class="feature-icon">
            <i class="fas fa-headset"></i>
        </div>
        <h3>Layanan 24/7</h3>
        <p>Customer service siap membantu Anda kapan saja</p>
    </div>
    <div class="feature">
        <div class="feature-icon">
            <i class="fas fa-tags"></i>
        </div>
        <h3>Harga Grosir</h3>
        <p>Dapatkan harga terbaik untuk pembelian dalam jumlah banyak</p>
    </div>
</div>

<!-- New Arrivals -->
<h2 class="section-title">
    <i class="fas fa-fire"></i>
    Produk Terbaru
</h2>

<div class="products-grid">
    @foreach($newArrivals as $product)
    <div class="product-card">
        <div class="product-image">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <i class="fas fa-box-open"></i>
            @endif
            <span class="product-badge" style="background: var(--secondary);">Baru!</span>
        </div>
        <div class="product-info">
            <div class="product-category">
                <i class="fas fa-tag"></i> {{ $product->category->name }}
            </div>
            <h3 class="product-name">{{ $product->name }}</h3>
            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="product-stock">
                <i class="fas fa-check-circle"></i>
                Stok: {{ $product->stock_qty }} unit
            </div>
            <a href="{{ route('products.show', $product->id) }}" class="product-btn">
                <i class="fas fa-eye"></i> Lihat Detail
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection
