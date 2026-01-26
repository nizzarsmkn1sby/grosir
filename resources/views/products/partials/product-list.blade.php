@foreach($products as $product)
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
