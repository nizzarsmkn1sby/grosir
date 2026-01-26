@extends('layouts.public')

@section('title', 'Produk - GrosirKu')

@push('styles')
<style>
    /* Filter Section */
    .filter-section {
        background: white;
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
    }

    .filter-section h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .search-box {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .search-box input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
    }

    .search-box button {
        background: var(--primary);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-box button:hover {
        background: var(--primary-dark);
    }

    .category-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .category-filter {
        padding: 0.5rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 50px;
        text-decoration: none;
        color: var(--dark);
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .category-filter:hover,
    .category-filter.active {
        border-color: var(--primary);
        background: var(--primary);
        color: white;
    }

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
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
        text-decoration: none;
        display: inline-block;
    }

    .product-btn:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    /* Card Animation for Lazy Load */
    @keyframes card-fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .product-card {
        animation: card-fade-in 0.5s ease backwards;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
        box-shadow: var(--shadow);
    }

    .empty-state i {
        font-size: 5rem;
        color: var(--gray);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--gray);
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
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
<h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 2rem;">
    <i class="fas fa-shopping-bag"></i> Semua Produk
</h1>

<!-- Filter Section -->
<div class="filter-section">
    <h3><i class="fas fa-filter"></i> Filter & Pencarian</h3>
    
    <!-- Search Box -->
    <form action="{{ route('products.index') }}" method="GET" class="search-box">
        <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
        <button type="submit">
            <i class="fas fa-search"></i> Cari
        </button>
    </form>

    <!-- Category Filters -->
    <div class="category-filters">
        <a href="{{ route('products.index') }}" class="category-filter {{ !request('category') ? 'active' : '' }}">
            <i class="fas fa-th"></i> Semua Kategori
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('products.index', ['category' => $cat->id]) }}" 
           class="category-filter {{ request('category') == $cat->id ? 'active' : '' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>
</div>

<!-- Products Grid -->
@if($products->count() > 0)
<div class="products-grid" id="product-container">
    @include('products.partials.product-list', ['products' => $products])
</div>

<!-- Loading State & Observer -->
<div id="loading-trigger" class="mt-12 text-center" style="min-height: 100px;">
    <div id="loader" class="hidden">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-indigo-500 border-t-transparent"></div>
        <p class="mt-2 text-slate-500 font-medium">Loading more products...</p>
    </div>
    
    @if($products->hasMorePages())
        <button id="load-more-btn" class="product-btn" style="padding: 1rem 3rem;">
            <i class="fas fa-plus-circle mr-2"></i> Load More Products
        </button>
    @else
        <p id="no-more-products" class="text-slate-400 font-medium py-8">
            <i class="fas fa-check-circle mr-2"></i> You've reached the end of our catalog.
        </p>
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
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const html = await response.text();
            
            // Append new items
            container.insertAdjacentHTML('beforeend', html);

            // Update URL for next page from a hidden meta-link or similar
            // Since we're just getting HTML, we need to extract the next link.
            // A more robust way: Return JSON with HTML and metadata.
            // For now, let's just increment the page number manually or check if HTML is empty.
            
            const url = new URL(nextPageUrl);
            let page = parseInt(url.searchParams.get('page')) + 1;
            url.searchParams.set('page', page);
            nextPageUrl = url.toString();

            if (html.trim() === "") {
                nextPageUrl = null;
                trigger.innerHTML = '<p class="text-slate-400 font-medium py-8"><i class="fas fa-check-circle mr-2"></i> No more products to show.</p>';
            }

        } catch (error) {
            console.error('Error loading products:', error);
            if (loadMoreBtn) loadMoreBtn.classList.remove('hidden');
        } finally {
            isLoading = false;
            loader.classList.add('hidden');
        }
    }

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', loadMore);
    }

    // Infinite Scroll Implementation (Intersection Observer)
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && nextPageUrl && !isLoading) {
            loadMore();
        }
    }, {
        rootMargin: '200px'
    });

    observer.observe(trigger);
</script>
@endpush
@else
<!-- Empty State -->
<div class="empty-state">
    <i class="fas fa-search"></i>
    <h3>Produk Tidak Ditemukan</h3>
    <p>Maaf, tidak ada produk yang sesuai dengan pencarian Anda.</p>
    <a href="{{ route('products.index') }}" class="product-btn" style="display: inline-block;">
        <i class="fas fa-arrow-left"></i> Kembali ke Semua Produk
    </a>
</div>
@endif
@endsection
