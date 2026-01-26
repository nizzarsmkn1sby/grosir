@if(count($cart) > 0)
    <div class="cart-grid">
        <div class="cart-items-container">
            @foreach($cart as $item)
            <div class="cart-card">
                <div class="item-image-wrapper">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                
                <div class="item-details">
                    <h3>{{ $item['name'] ?? 'Produk' }}</h3>
                    <div class="item-price">Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</div>
                    <div class="item-subtotal">Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}</div>
                </div>
                
                <div class="item-actions">
                    <form action="{{ route('cart.remove', $item['id'] ?? 0) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-remove-v2" title="Remove Item">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                    
                    <div class="qty-switcher">
                        <form action="{{ route('cart.update', $item['id'] ?? 0) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PATCH')
                            <button type="button" class="qty-btn" onclick="decrementQty(this)">-</button>
                            <input type="number" name="quantity" value="{{ $item['quantity'] ?? 1 }}" min="1" class="qty-input" onchange="this.form.submit()">
                            <button type="button" class="qty-btn" onclick="incrementQty(this)">+</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="mt-8 flex justify-between items-center px-4">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-slate-400 hover:text-rose-500 font-semibold transition-colors flex items-center gap-2">
                        <i class="fas fa-trash"></i> Clear All Cart
                    </button>
                </form>
                <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800 font-bold transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Continue Shopping
                </a>
            </div>
        </div>

        <div class="checkout-sidebar">
            <h3 class="summary-title">
                <i class="fas fa-receipt text-indigo-500"></i>
                Order Summary
            </h3>
            
            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            
            <div class="summary-row">
                <span>Estimated Shipping</span>
                <span class="text-green-500 font-bold">FREE</span>
            </div>
            
            <div class="summary-row">
                <span>Tax (0%)</span>
                <span>Rp 0</span>
            </div>
            
            <div class="summary-divider"></div>
            
            <div class="total-row">
                <span>Grand Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <a href="{{ route('checkout.index') }}" class="btn-checkout-v2">
                Proceed to Checkout
                <i class="fas fa-chevron-right ml-2"></i>
            </a>
            
            <div class="mt-6 flex items-center justify-center gap-4">
                <i class="fab fa-cc-visa text-slate-300 text-2xl"></i>
                <i class="fab fa-cc-mastercard text-slate-300 text-2xl"></i>
                <i class="fab fa-cc-paypal text-slate-300 text-2xl"></i>
            </div>
            
            <p class="text-center text-slate-400 text-sm mt-6">
                <i class="fas fa-lock mr-1"></i> Secure 256-bit SSL encrypted payment
            </p>
        </div>
    </div>
@else
    <div class="empty-state-v2">
        <i class="fas fa-shopping-cart"></i>
        <h2>Your cart is empty</h2>
        <p>Looks like you haven't added anything to your cart yet.</p>
        <a href="{{ route('products.index') }}" class="btn-explore">
            Explore Products
        </a>
    </div>
@endif
