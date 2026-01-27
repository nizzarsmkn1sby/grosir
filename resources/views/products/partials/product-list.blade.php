@foreach($products as $product)
<div class="alibaba-prod-card">
    <a href="{{ route('products.show', $product->id) }}">
        <div class="prod-img-wrapper">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            @else
                <i class="fas fa-box-open"></i>
            @endif
            @if($product->stock_qty < 10)
                <div class="absolute top-2 right-2 bg-red-600 text-white px-2 py-0.5 text-[10px] rounded font-bold">STOK TIPIS</div>
            @endif
        </div>
    </a>
    <div class="prod-content">
        <a href="{{ route('products.show', $product->id) }}" class="no-underline text-inherit">
            <h3 class="prod-name">{{ $product->name }}</h3>
            <div class="prod-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="prod-moq">Min. Order: 1 unit</div>
        </a>
        <a href="{{ route('products.show', $product->id) }}" class="btn-terminal-primary w-full mt-4">
            Buka Terminal Produk
        </a>
    </div>
</div>
@endforeach
