@extends('layouts.public')

@section('title', $product->name . ' - Produk Terminal')

@push('styles')
<style>
    /* Premium Product Terminal Styles */
    .product-detail {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6rem;
        background: white;
        padding: 4rem;
        border-radius: 40px;
        box-shadow: var(--shadow-premium);
        margin-bottom: 5rem;
        border: 1px solid #f1f5f9;
        align-items: start;
    }

    .image-terminal-wrapper {
        position: sticky;
        top: 140px;
    }

    .image-terminal {
        width: 100%;
        aspect-ratio: 1/1;
        background: #f8fafc;
        border-radius: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.05);
    }

    .image-terminal img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .image-terminal:hover img {
        transform: scale(1.1);
    }

    .terminal-category-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--alibaba-orange);
        background: #fff7f2;
        padding: 0.625rem 1.5rem;
        border-radius: 100px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 2rem;
        border: 1px solid rgba(255, 80, 0, 0.1);
    }

    .detail-terminal-content h1 {
        font-size: 3.5rem;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 2rem;
        line-height: 1;
        letter-spacing: -0.04em;
    }

    .price-terminal-module {
        background: #0f172a;
        padding: 3rem;
        border-radius: 32px;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }

    .price-terminal-module::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: var(--alibaba-orange);
        filter: blur(80px);
        opacity: 0.1;
    }

    .price-terminal-label {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.2em;
    }

    .price-terminal-value {
        font-size: 3.5rem;
        font-weight: 900;
        color: white;
        letter-spacing: -0.02em;
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .price-terminal-currency {
        font-size: 1.5rem;
        color: var(--alibaba-orange);
        font-weight: 800;
    }

    .spec-matrix {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin-bottom: 4rem;
        padding: 2rem;
        background: #f8fafc;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
    }

    .matrix-cell {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .matrix-label {
        font-size: 10px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.15em;
    }

    .matrix-value {
        font-size: 0.9375rem;
        font-weight: 700;
        color: #1e293b;
    }

    .terminal-description-head {
        font-size: 0.75rem;
        font-weight: 900;
        margin-bottom: 1.5rem;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 12px;
        text-transform: uppercase;
        letter-spacing: 0.2em;
    }

    .purchase-terminal-zone {
        margin-top: 4rem;
        padding-top: 3rem;
        border-top: 1px solid #f1f5f9;
    }

    .qty-terminal-control {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    .qty-terminal-input {
        display: flex;
        align-items: center;
        background: #f8fafc;
        padding: 8px;
        border-radius: 100px;
    }

    .qty-terminal-btn {
        width: 48px;
        height: 48px;
        border-radius: 100px;
        border: none;
        background: white;
        color: #0f172a;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }

    .qty-terminal-btn:hover {
        background: var(--alibaba-orange);
        color: white;
        transform: scale(1.1);
    }

    .qty-terminal-field {
        width: 80px;
        text-align: center;
        background: transparent;
        border: none;
        font-weight: 900;
        font-size: 1.25rem;
        color: #0f172a;
    }

    .btn-terminal-submit {
        width: 100%;
        background: var(--alibaba-orange);
        color: white;
        padding: 1.5rem;
        border-radius: 100px;
        font-weight: 900;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 20px 40px rgba(255, 80, 0, 0.25);
    }

    .btn-terminal-submit:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px rgba(255, 80, 0, 0.35);
        background: #ff6a00;
    }

    .auth-terminal-gate {
        background: #f8fafc;
        padding: 3rem;
        border-radius: 32px;
        text-align: center;
        border: 2px dashed #e2e8f0;
    }

    .btn-gate {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 3rem;
        border-radius: 100px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 0.75rem;
        transition: all 0.3s;
    }

    @media (max-width: 1024px) {
        .product-detail { grid-template-columns: 1fr; padding: 2.5rem; gap: 4rem; }
        .detail-terminal-content h1 { font-size: 2.5rem; }
        .price-terminal-value { font-size: 2.5rem; }
    }
</style>
@endpush

@section('content')
<!-- Terminal Navigation -->
<nav class="flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] mb-12">
    <a href="{{ route('home') }}" class="text-gray-400 hover:text-orange-500 transition-colors">Digital Ecosystem</a>
    <i class="fas fa-circle text-[4px] text-gray-300"></i>
    <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-orange-500 transition-colors">Manifest Hub</a>
    <i class="fas fa-circle text-[4px] text-gray-300"></i>
    <span class="text-orange-500">Resource #{{ $product->sku }}</span>
</nav>

<div class="product-detail">
    <!-- Image Terminal -->
    <div class="image-terminal-wrapper">
        <div class="image-terminal">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            @else
                <i class="fas fa-industry text-6xl text-slate-100"></i>
            @endif
        </div>
    </div>

    <!-- Interface Terminal -->
    <div class="detail-terminal-content">
        <div class="terminal-category-pill">
            <i class="fas fa-hashtag text-[10px]"></i> {{ $product->category->name }}
        </div>
        
        <h1>{{ $product->name }}</h1>
        
        <div class="price-terminal-module">
            <div class="price-terminal-label">Unit Exchange Rate</div>
            <div class="price-terminal-value">
                <span class="price-terminal-currency">IDR</span>{{ number_format($product->price, 0, ',', '.') }}
            </div>
            <div class="mt-4 flex items-center gap-2">
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-ping"></div>
                <span class="text-[10px] font-black text-green-500 uppercase tracking-widest">Protocol Active / Quality Verified</span>
            </div>
        </div>

        <div class="spec-matrix">
            <div class="matrix-cell">
                <span class="matrix-label">Resource ID</span>
                <span class="matrix-value text-orange-600 font-black">{{ $product->sku }}</span>
            </div>
            <div class="matrix-cell">
                <span class="matrix-label">Current Availability</span>
                <span class="matrix-value font-black">{{ $product->stock_qty }} Units</span>
            </div>
            <div class="matrix-cell">
                <span class="matrix-label">Net Mass</span>
                <span class="matrix-value">{{ $product->weight }} grams</span>
            </div>
            <div class="matrix-cell">
                <span class="matrix-label">Status</span>
                <span class="matrix-value flex items-center gap-2"><div class="w-2 h-2 bg-orange-500 rounded-full"></div> New Release</span>
            </div>
        </div>

        <div class="terminal-description-head">
            <i class="fas fa-file-alt"></i> Documentation Log
        </div>
        <div class="text-slate-500 leading-relaxed font-medium text-sm">
            {{ $product->description ?? 'Identifikasi produk wholesale premium dengan standar manufaktur global. Protokol kualitas terverifikasi untuk distribusi jaringan ekosistem bisnis.' }}
        </div>

        <div class="purchase-terminal-zone">
            @guest
            <div class="auth-terminal-gate">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8">Access Restricted - Authorization Required</p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="{{ route('login') }}" class="btn-gate bg-white text-slate-900 border border-slate-200 hover:border-slate-900">Login Protocol</a>
                    <a href="{{ route('register') }}" class="btn-gate bg-orange-500 text-white hover:bg-orange-600">Secure Register</a>
                </div>
            </div>
            @else
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <div class="qty-terminal-control">
                    <span class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Quantity Batch:</span>
                    <div class="qty-terminal-input">
                        <button type="button" class="qty-terminal-btn" onclick="decreaseQty()">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <input type="number" id="quantity" class="qty-terminal-field" value="1" min="1" max="{{ $product->stock_qty }}" readonly>
                        <button type="button" class="qty-terminal-btn" onclick="increaseQty()">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>
                
                <input type="hidden" name="quantity" id="quantity-input" value="1">
                <button type="submit" class="btn-terminal-primary w-full py-5">
                    <i class="fas fa-bolt"></i>
                    Execute Order Protocol
                </button>
            </form>
            @endguest
        </div>
    </div>
</div>

<!-- Cross-Reference Manifest -->
@if($relatedProducts->count() > 0)
<div class="alibaba-section-title">
    <span class="text-2xl font-black">Cross-Reference Manifest</span>
    <a href="{{ route('products.index') }}" class="more-link font-black">Open Hub <i class="fas fa-external-link-alt ml-2 text-[10px]"></i></a>
</div>

<div class="alibaba-products mb-24">
    @foreach($relatedProducts as $related)
    <div class="alibaba-prod-card shadow-sm hover:shadow-xl transition-all">
        <a href="{{ route('products.show', $related->id) }}">
            <div class="prod-img-wrapper">
                @if($related->image_url)
                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}">
                @else
                    <i class="fas fa-industry text-4xl opacity-10"></i>
                @endif
                @if($related->stock_qty < 10)
                    <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 text-[8px] font-black rounded-full">CRITICAL STOCK</div>
                @endif
            </div>
        </a>
        <div class="prod-content">
            <a href="{{ route('products.show', $related->id) }}" class="no-underline text-inherit">
                <div class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-2">{{ $related->category->name }}</div>
                <h3 class="prod-name font-black">{{ $related->name }}</h3>
                <div class="prod-price font-black mt-4">Rp {{ number_format($related->price, 0, ',', '.') }}</div>
            </a>
            <a href="{{ route('products.show', $related->id) }}" class="prod-action mt-6 font-black hover:bg-orange-500 hover:text-white transition-all">
                Open Resource
            </a>
        </div>
    </div>
    @endforeach
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
