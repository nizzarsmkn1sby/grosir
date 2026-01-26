@extends('layouts.public')

@section('title', $product->name . ' - GrosirKu')

@push('styles')
<style>
    .product-detail {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: var(--shadow);
        margin-bottom: 3rem;
    }

    .product-image-large {
        width: 100%;
        height: 500px;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8rem;
        color: var(--gray);
    }

    .product-image-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 1rem;
    }

    .product-details-content h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .product-category-badge {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .product-price-large {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1.5rem;
    }

    .product-meta {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--light);
        border-radius: 0.5rem;
    }

    .product-meta-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1rem;
    }

    .product-meta-item i {
        color: var(--primary);
        width: 24px;
    }

    .product-description {
        margin-bottom: 2rem;
    }

    .product-description h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .product-description p {
        color: var(--gray);
        line-height: 1.8;
    }

    .add-to-cart-section {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem;
    }

    .quantity-selector button {
        background: var(--primary);
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 0.25rem;
        cursor: pointer;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-selector input {
        width: 60px;
        text-align: center;
        border: none;
        font-size: 1.125rem;
        font-weight: 600;
    }

    .add-to-cart-btn {
        flex: 1;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 1.125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .add-to-cart-btn:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    .login-prompt {
        background: #fef3c7;
        border: 2px solid #f59e0b;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .login-prompt p {
        margin-bottom: 1rem;
        color: #92400e;
        font-weight: 500;
    }

    .login-prompt a {
        background: var(--primary);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        margin: 0 0.5rem;
    }

    /* Related Products */
    .related-products {
        margin-top: 4rem;
    }

    .related-products h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    @media (max-width: 768px) {
        .product-detail {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .product-image-large {
            height: 300px;
        }

        .add-to-cart-section {
            flex-direction: column;
        }

        .quantity-selector {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<nav style="margin-bottom: 2rem;">
    <a href="{{ route('home') }}" style="color: var(--gray); text-decoration: none;">Home</a>
    <span style="margin: 0 0.5rem; color: var(--gray);">/</span>
    <a href="{{ route('products.index') }}" style="color: var(--gray); text-decoration: none;">Products</a>
    <span style="margin: 0 0.5rem; color: var(--gray);">/</span>
    <span style="color: var(--dark); font-weight: 600;">{{ $product->name }}</span>
</nav>

<!-- Product Detail -->
<div class="product-detail">
    <!-- Product Image -->
    <div class="product-image-large">
        @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        @else
            <i class="fas fa-box-open"></i>
        @endif
    </div>

    <!-- Product Details -->
    <div class="product-details-content">
        <span class="product-category-badge">
            <i class="fas fa-tag"></i> {{ $product->category->name }}
        </span>
        
        <h1>{{ $product->name }}</h1>
        
        <div class="product-price-large">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </div>

        <!-- Product Meta -->
        <div class="product-meta">
            <div class="product-meta-item">
                <i class="fas fa-barcode"></i>
                <span><strong>SKU:</strong> {{ $product->sku }}</span>
            </div>
            <div class="product-meta-item">
                <i class="fas fa-box"></i>
                <span><strong>Stok:</strong> {{ $product->stock_qty }} unit tersedia</span>
            </div>
            <div class="product-meta-item">
                <i class="fas fa-weight"></i>
                <span><strong>Berat:</strong> {{ $product->weight }} gram</span>
            </div>
        </div>

        <!-- Description -->
        <div class="product-description">
            <h3><i class="fas fa-info-circle"></i> Deskripsi Produk</h3>
            <p>{{ $product->description ?? 'Produk berkualitas dengan harga grosir terbaik. Cocok untuk kebutuhan usaha dan rumah tangga Anda.' }}</p>
        </div>

        <!-- Add to Cart Section -->
        @guest
        <div class="login-prompt">
            <p><i class="fas fa-lock"></i> Anda harus login terlebih dahulu untuk membeli produk ini</p>
            <a href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a href="{{ route('register') }}">
                <i class="fas fa-user-plus"></i> Register
            </a>
        </div>
        @else
        <div class="add-to-cart-section">
            <div class="quantity-selector">
                <button type="button" onclick="decreaseQty()">
                    <i class="fas fa-minus"></i>
                </button>
                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_qty }}" readonly>
                <button type="button" onclick="increaseQty()">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="flex: 1;">
                @csrf
                <input type="hidden" name="quantity" id="quantity-input" value="1">
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-cart"></i>
                    Tambah ke Keranjang
                </button>
            </form>
        </div>
        @endguest
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<div class="related-products">
    <h2><i class="fas fa-boxes"></i> Produk Terkait</h2>
    
    <div class="products-grid">
        @foreach($relatedProducts as $related)
        <div class="product-card">
            <div class="product-image">
                @if($related->image_url)
                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <i class="fas fa-box-open"></i>
                @endif
            </div>
            <div class="product-info">
                <div class="product-category">
                    <i class="fas fa-tag"></i> {{ $related->category->name }}
                </div>
                <h3 class="product-name">{{ $related->name }}</h3>
                <div class="product-price">Rp {{ number_format($related->price, 0, ',', '.') }}</div>
                <div class="product-stock">
                    <i class="fas fa-check-circle"></i>
                    Stok: {{ $related->stock_qty }} unit
                </div>
                <a href="{{ route('products.show', $related->id) }}" class="product-btn">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    const maxQty = {{ $product->stock_qty }};
    
    function increaseQty() {
        const input = document.getElementById('quantity');
        const hiddenInput = document.getElementById('quantity-input');
        if (parseInt(input.value) < maxQty) {
            input.value = parseInt(input.value) + 1;
            hiddenInput.value = input.value;
        }
    }
    
    function decreaseQty() {
        const input = document.getElementById('quantity');
        const hiddenInput = document.getElementById('quantity-input');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            hiddenInput.value = input.value;
        }
    }
</script>
@endpush
