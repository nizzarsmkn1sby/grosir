@extends('layouts.public')

@section('title', 'Checkout - GrosirKu')

@push('styles')
<style>
    .checkout-page {
        padding: 4rem 0;
        background: #f8fafc;
        min-height: 100vh;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2.5rem;
        align-items: start;
    }

    .checkout-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        margin-bottom: 2rem;
    }

    .checkout-card h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        transition: all 0.2s;
        font-family: inherit;
    }

    .form-input:focus {
        border-color: #6366f1;
        outline: none;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
    }

    .payment-option {
        position: relative;
    }

    .payment-option input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .payment-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        padding: 1.25rem;
        border: 2px solid #e2e8f0;
        border-radius: 1rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .payment-option input:checked + .payment-label {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.05);
        color: #6366f1;
    }

    .payment-label i {
        font-size: 1.5rem;
    }

    /* Order Summary Sidebar */
    .summary-sidebar {
        background: white;
        border-radius: 2rem;
        padding: 2rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        position: sticky;
        top: 100px;
    }

    .sidebar-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        color: #64748b;
    }

    .sidebar-total {
        display: flex;
        justify-content: space-between;
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid #f1f5f9;
    }

    .btn-complete {
        width: 100%;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
        padding: 1.25rem;
        border: none;
        border-radius: 1.25rem;
        font-size: 1.125rem;
        font-weight: 700;
        cursor: pointer;
        margin-top: 2rem;
        transition: all 0.3s;
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
    }

    .btn-complete:hover {
        transform: scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.4);
    }

    @media (max-width: 1024px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
        .summary-sidebar {
            position: static;
        }
    }
</style>
@endpush

@section('content')
<div class="checkout-page">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-extrabold mb-8 text-slate-800">Complete Your Order</h1>

        {{-- Cart Error Detection & Fix --}}
        @php
            $hasError = false;
            foreach($cart as $item) {
                if (!is_array($item) || !isset($item['id'], $item['name'], $item['price'], $item['quantity'])) {
                    $hasError = true;
                    break;
                }
            }
        @endphp

        @if($hasError)
        <div class="bg-red-50 border-l-4 border-red-500 p-6 mb-8 rounded-lg">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 text-2xl mr-4 mt-1"></i>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-red-800 mb-2">Keranjang Bermasalah Terdeteksi</h3>
                    <p class="text-red-700 mb-4">
                        Data keranjang Anda mengalami masalah teknis. Silakan reset keranjang dan tambahkan produk kembali.
                    </p>
                    <form action="{{ route('cart.force-clear') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition-all">
                            <i class="fas fa-sync-alt mr-2"></i> Reset Keranjang Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- Pending Orders Warning --}}
        @if(isset($pendingOrders) && $pendingOrders->isNotEmpty())
        <div class="bg-amber-50 border-l-4 border-amber-500 p-6 mb-8 rounded-lg shadow-sm">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-amber-500 text-2xl mr-4 mt-1"></i>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-amber-800 mb-2">⚠️ Pending Order Detected</h3>
                    <p class="text-amber-700 mb-4">
                        You have existing orders with some of these products that are still being processed:
                    </p>
                    
                    @foreach($pendingOrders as $order)
                    <div class="bg-white rounded-lg p-4 mb-3 border border-amber-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-slate-800">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                @if($order->status == 'pending') bg-amber-100 text-amber-700
                                @else bg-blue-100 text-blue-700 @endif">
                                {{ $order->status }}
                            </span>
                        </div>
                        <div class="text-sm text-slate-600">
                            <i class="far fa-clock mr-1"></i>
                            {{ $order->created_at->diffForHumans() }}
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach($order->orderItems as $item)
                            <span class="bg-amber-50 text-amber-700 px-2 py-1 rounded text-xs font-semibold">
                                {{ $item->product->name }} (×{{ $item->quantity }})
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-4 p-3 bg-amber-100 rounded-lg">
                        <p class="text-sm text-amber-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Note:</strong> If you proceed with this checkout, you may have duplicate orders. 
                            Please complete or cancel your pending orders first, or remove duplicate items from your cart.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="checkout-grid">
                
                <div class="checkout-main">
                    
                    <!-- Shipping Section -->
                    <div class="checkout-card">
                        <h2><i class="fas fa-truck text-indigo-500"></i> Shipping Address</h2>
                        
                        <div class="form-group">
                            <label class="form-label">Full Address</label>
                            <textarea name="address" class="form-input" rows="3" placeholder="Street name, building number, district..." required>{{ old('address') }}</textarea>
                            @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-input" placeholder="e.g. Jakarta Selatan" value="{{ old('city') }}" required>
                                @error('city') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Province</label>
                                <input type="text" name="province" class="form-input" placeholder="e.g. DKI Jakarta" value="{{ old('province') }}" required>
                                @error('province') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-input" placeholder="12345" value="{{ old('postal_code') }}" required>
                            @error('postal_code') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Payment Info Section -->
                    <div class="checkout-card">
                        <h2><i class="fas fa-shield-alt text-indigo-500"></i> Secure Payment</h2>
                        
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 border-2 border-indigo-100">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fas fa-lock text-2xl text-indigo-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-slate-800 mb-1">Payment via Midtrans</h3>
                                    <p class="text-sm text-slate-600">
                                        Secure payment gateway with multiple payment options
                                    </p>
                                </div>
                            </div>

                            <div class="bg-white rounded-xl p-4 mb-4">
                                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-3">Available Payment Methods:</p>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex items-center gap-2 text-sm text-slate-700">
                                        <i class="fas fa-university text-indigo-500"></i>
                                        <span>Bank Transfer</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-slate-700">
                                        <i class="fas fa-credit-card text-indigo-500"></i>
                                        <span>Credit/Debit Card</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-slate-700">
                                        <i class="fas fa-wallet text-indigo-500"></i>
                                        <span>E-Wallet (GoPay, OVO)</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-slate-700">
                                        <i class="fas fa-store text-indigo-500"></i>
                                        <span>Retail Stores</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 text-sm text-slate-600">
                                <i class="fas fa-info-circle text-indigo-500"></i>
                                <span>You'll choose your preferred payment method in the next step</span>
                            </div>
                        </div>

                        <!-- Hidden input for backend compatibility -->
                        <input type="hidden" name="payment_method" value="midtrans">
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="summary-sidebar">
                    <h3 class="text-xl font-extrabold mb-6 text-slate-800">Order Summary</h3>
                    
                    @foreach($cart as $item)
                    <div class="flex justify-between text-sm mb-3">
                        <span class="text-slate-600">{{ $item['name'] ?? 'Produk' }} (x{{ $item['quantity'] ?? 0 }})</span>
                        <span class="font-bold">Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}</span>
                    </div>
                    @endforeach

                    <div class="h-px bg-slate-100 my-4"></div>

                    <div class="sidebar-item">
                        <span>Subtotal</span>
                        <span class="font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="sidebar-item">
                        <span>Shipping</span>
                        <span class="text-green-500 font-bold">FREE</span>
                    </div>
                    
                    <div class="sidebar-total">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn-complete">
                        Place Order Now
                    </button>
                    
                    <p class="text-slate-400 text-xs text-center mt-6">
                        By placing an order, you agree to our Terms & Conditions.
                    </p>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
