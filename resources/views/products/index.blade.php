@extends('layouts.public')

@section('title', 'Katalog Sourcing - GrosirKu')

@push('styles')
<style>
    /* Premium Products Terminal Styles */
    .filter-section {
        background: white;
        padding: 3rem;
        border-radius: 32px;
        box-shadow: var(--shadow-premium);
        margin-bottom: 4rem;
        border: 1px solid #f1f5f9;
    }

    .search-box-terminal {
        display: flex;
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        border-radius: 100px;
        overflow: hidden;
        margin-bottom: 3rem;
        max-width: 600px;
        transition: all 0.3s ease;
    }

    .search-box-terminal:focus-within {
        border-color: var(--alibaba-orange);
        box-shadow: 0 0 0 4px rgba(255, 80, 0, 0.1);
        background: white;
    }

    .search-box-terminal input {
        flex: 1;
        padding: 1rem 2rem;
        border: none;
        background: transparent;
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        outline: none;
    }

    .search-box-terminal button {
        background: var(--alibaba-orange);
        color: white;
        padding: 0 2.5rem;
        border: none;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 0.75rem;
        cursor: pointer;
        transition: background 0.3s;
    }

    .search-box-terminal button:hover {
        background: #ff6a00;
    }

    .cat-filter-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .cat-pill {
        padding: 0.75rem 2rem;
        border: 1px solid #f1f5f9;
        border-radius: 100px;
        text-decoration: none !important;
        color: #64748b;
        font-size: 0.8125rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
    }

    .cat-pill:hover {
        border-color: var(--alibaba-orange);
        color: var(--alibaba-orange);
        background: #fff7f2;
    }

    .cat-pill.active {
        background: var(--alibaba-orange);
        border-color: var(--alibaba-orange);
        color: white;
        box-shadow: 0 10px 20px rgba(255, 80, 0, 0.2);
    }

    /* Terminal Loading */
    .terminal-loader {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
        padding: 4rem 0;
    }

    .loader-spin {
        width: 40px;
        height: 40px;
        border: 4px solid #f1f5f9;
        border-top: 4px solid var(--alibaba-orange);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Empty Manifest */
    .empty-manifest {
        text-align: center;
        padding: 10rem 2rem;
        background: white;
        border-radius: 40px;
        border: 1px solid #f1f5f9;
    }

    .empty-manifest i {
        font-size: 4rem;
        color: #f1f5f9;
        margin-bottom: 2.5rem;
    }

    .empty-manifest h3 {
        font-size: 1.75rem;
        font-weight: 900;
        margin-bottom: 1rem;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .empty-manifest p {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 3rem;
    }
</style>
@endpush

@section('content')
<div class="alibaba-section-title">
    <span class="text-2xl font-black">Master Manifest</span>
    <span class="text-[10px] font-black text-gray-400 border border-gray-200 px-3 py-1 rounded-full uppercase tracking-widest">{{ $products->total() }} Produk Terdaftar</span>
</div>

<!-- Filter Terminal -->
<div class="filter-section">
    <div class="mb-10 flex items-center gap-3">
        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-white text-xs">
            <i class="fas fa-terminal"></i>
        </div>
        <span class="text-sm font-black uppercase tracking-widest text-slate-800">Protokol Filter & Pencarian</span>
    </div>
    
    <!-- Search Box Terminal -->
    <form action="{{ route('products.index') }}" method="GET" class="search-box-terminal">
        <input type="text" name="search" placeholder="Input identitas produk..." value="{{ request('search') }}">
        <button type="submit">
            Eksekusi Cari
        </button>
    </form>

    <!-- Category Pills Terminal -->
    <div class="cat-filter-pills">
        <a href="{{ route('products.index') }}" class="cat-pill {{ !request('category') ? 'active' : '' }}">
            <i class="fas fa-layer-group mr-2"></i> Semua Manifest
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('products.index', ['category' => $cat->id]) }}" 
           class="cat-pill {{ request('category') == $cat->id ? 'active' : '' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>
</div>

<!-- Grid Terminal -->
@if($products->count() > 0)
<div class="alibaba-products" id="product-container">
    @include('products.partials.product-list', ['products' => $products])
</div>

<!-- Sentinel Loader -->
<div id="loading-trigger" class="terminal-loader">
    <div id="loader" class="hidden">
        <div class="loader-spin"></div>
        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">Synchronizing Data...</p>
    </div>
    
    @if($products->hasMorePages())
        <button id="load-more-btn" class="prod-action font-black uppercase tracking-widest" style="max-width: 400px; margin: 0 auto; display: block; background: white !important; border: 1px solid #f1f5f9 !important;">
            <i class="fas fa-plus-circle mr-2 text-orange-500"></i> Muat Manifest Lainnya
        </button>
    @else
        <div id="no-more-products" class="py-12 flex flex-col items-center">
            <div class="w-16 h-1 bg-f1f5f9 rounded-full mb-6"></div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">End of Manifest - All data synchronized</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
    let nextPageUrl = "{{ $products->nextPageUrl() }}";
    const container = document.getElementById('product-container');
    const loader = document.getElementById('loader');
    const loadMoreBtn = document.getElementById('load-more-btn');
    const trigger = document.getElementById('loading-trigger');
    let isLoading = false;

    async function loadMore() {
        if (!nextPageUrl || isLoading) return;

        isLoading = true;
        if (loadMoreBtn) loadMoreBtn.classList.add('hidden');
        loader.classList.remove('hidden');

        try {
            const response = await fetch(nextPageUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) throw new Error('Network synchronization error');

            const html = await response.text();
            container.insertAdjacentHTML('beforeend', html);
            
            const url = new URL(nextPageUrl);
            let page = parseInt(url.searchParams.get('page')) + 1;
            url.searchParams.set('page', page);
            nextPageUrl = url.toString();

            if (html.trim() === "") {
                nextPageUrl = null;
                trigger.innerHTML = '<p class="text-[10px] font-black text-gray-400 uppercase tracking-widest py-10"><i class="fas fa-check-circle mr-2 text-green-500"></i> Full Database Synchronized</p>';
            }

        } catch (error) {
            console.error('Terminal Error:', error);
            if (loadMoreBtn) loadMoreBtn.classList.remove('hidden');
        } finally {
            isLoading = false;
            loader.classList.add('hidden');
        }
    }

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', loadMore);
    }

    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && nextPageUrl && !isLoading) {
            loadMore();
        }
    }, { rootMargin: '300px' });

    observer.observe(trigger);
</script>
@endpush
@else
<div class="empty-manifest">
    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8">
        <i class="fas fa-search-minus text-slate-200 text-3xl"></i>
    </div>
    <h3>Manifest Tidak Ditemukan</h3>
    <p>Data identifikasi produk tidak terdeteksi dalam database pusat.</p>
    <a href="{{ route('products.index') }}" class="btn-terminal-primary">
        <i class="fas fa-undo mr-2"></i> Reset Protokol
    </a>
</div>
@endif
@endsection
