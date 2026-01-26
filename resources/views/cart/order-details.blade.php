@extends('layouts.public')

@section('title', 'Order Invoice - GrosirKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-semibold mb-4 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Cart</span>
            </a>
            
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-black text-slate-900 mb-2">Order Invoice</h1>
                    <p class="text-slate-500">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                
                <!-- Payment Status Badge -->
                @if($order->payment && $order->payment->status == 'completed')
                    <span class="px-6 py-3 rounded-2xl text-base font-bold uppercase tracking-wider shadow-lg bg-gradient-to-r from-emerald-500 to-emerald-600 text-white flex items-center gap-2">
                        <i class="fas fa-check-circle text-xl"></i>
                        PAID
                    </span>
                @else
                    <span class="px-6 py-3 rounded-2xl text-base font-bold uppercase tracking-wider shadow-lg bg-gradient-to-r from-rose-500 to-rose-600 text-white flex items-center gap-2">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                        UNPAID
                    </span>
                @endif
            </div>
        </div>

        <!-- Main Invoice Card -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
            
            <!-- Invoice Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-3xl font-black mb-2">GrosirKu</h2>
                        <p class="text-indigo-100">Wholesale E-Commerce Platform</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-indigo-100 mb-1">Invoice Date</p>
                        <p class="text-lg font-bold">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer & Shipping Info -->
            <div class="p-8 grid md:grid-cols-2 gap-8 border-b border-slate-100">
                <!-- Customer Info -->
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="fas fa-user text-indigo-500"></i>
                        Customer Information
                    </h3>
                    <div class="bg-slate-50 rounded-xl p-4 space-y-2">
                        <p class="font-bold text-slate-900">{{ $order->user->name }}</p>
                        <p class="text-slate-600 text-sm">{{ $order->user->email }}</p>
                    </div>
                </div>

                <!-- Shipping Info -->
                @if($order->shipping)
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="fas fa-shipping-fast text-indigo-500"></i>
                        Shipping Address
                    </h3>
                    <div class="bg-slate-50 rounded-xl p-4 space-y-1 text-sm">
                        <p class="text-slate-700">{{ $order->shipping->address }}</p>
                        <p class="text-slate-700">{{ $order->shipping->city }}, {{ $order->shipping->state }}</p>
                        <p class="text-slate-700">{{ $order->shipping->postal_code }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Order Items -->
            <div class="p-8">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fas fa-box text-indigo-500"></i>
                    Order Items
                </h3>

                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                    <div class="bg-slate-50 rounded-xl p-4 flex items-center gap-4 hover:bg-slate-100 transition-colors">
                        <!-- Product Image -->
                        <div class="w-16 h-16 bg-white rounded-lg overflow-hidden border border-slate-200 flex-shrink-0">
                            @if($item->product->image_url)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100">
                                    <i class="fas fa-image text-indigo-300 text-xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-900 mb-1">{{ $item->product->name }}</h4>
                            <div class="flex items-center gap-4 text-sm text-slate-500">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-tag text-indigo-400"></i>
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-times text-slate-400"></i>
                                    {{ $item->quantity }} pcs
                                </span>
                            </div>
                        </div>

                        <!-- Subtotal -->
                        <div class="text-right">
                            <p class="text-xs text-slate-400 mb-1">Subtotal</p>
                            <p class="text-lg font-black text-indigo-600">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="p-8 bg-slate-50 border-t border-slate-200">
                <div class="max-w-md ml-auto space-y-3">
                    <!-- Subtotal -->
                    <div class="flex justify-between items-center text-slate-600">
                        <span>Subtotal</span>
                        <span class="font-semibold">Rp {{ number_format($order->orderItems->sum(fn($item) => $item->price * $item->quantity), 0, ',', '.') }}</span>
                    </div>

                    <!-- Shipping (if applicable) -->
                    <div class="flex justify-between items-center text-slate-600">
                        <span>Shipping</span>
                        <span class="font-semibold">Free</span>
                    </div>

                    <div class="border-t border-slate-300 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-slate-900">Total Payment</span>
                            <span class="text-2xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            @if($order->payment)
            <div class="p-8 border-t border-slate-200">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="fas fa-credit-card text-indigo-500"></i>
                    Payment Information
                </h3>

                <div class="bg-slate-50 rounded-xl p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Payment Method</span>
                        <span class="font-semibold text-slate-900">
                            {{ $order->payment->payment_type ? ucfirst(str_replace('_', ' ', $order->payment->payment_type)) : 'Midtrans' }}
                        </span>
                    </div>

                    @if($order->payment->transaction_id)
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Transaction ID</span>
                        <span class="font-mono text-sm text-slate-900">{{ $order->payment->transaction_id }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Payment Status</span>
                        @if($order->payment->status == 'completed')
                            <span class="px-3 py-1 rounded-lg bg-emerald-100 text-emerald-700 font-semibold text-sm">
                                Completed
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-lg bg-rose-100 text-rose-700 font-semibold text-sm">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        @endif
                    </div>

                    @if($order->payment->paid_at)
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Paid At</span>
                        <span class="font-semibold text-slate-900">{{ $order->payment->paid_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="p-8 bg-gradient-to-r from-slate-50 to-indigo-50 border-t border-slate-200">
                <div class="flex flex-wrap gap-4 justify-center">
                    @if($order->payment && $order->payment->status != 'completed')
                    <!-- Pay Now Button -->
                    <a href="{{ route('order.pay', $order->id) }}" class="px-8 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:scale-105">
                        <i class="fas fa-credit-card"></i>
                        <span>Pay Now</span>
                    </a>
                    
                    <!-- Info Box -->
                    <div class="px-6 py-4 bg-amber-50 border-2 border-amber-200 rounded-xl text-amber-700 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        <span class="font-semibold text-sm">Payment pending - Complete payment to process order</span>
                    </div>
                    @endif
                    
                    <!-- Print Invoice Button -->
                    <button onclick="window.print()" class="px-8 py-4 bg-white hover:bg-slate-50 text-slate-700 border-2 border-slate-200 rounded-xl font-bold shadow-sm hover:shadow-md transition-all flex items-center gap-2">
                        <i class="fas fa-print"></i>
                        <span>Print Invoice</span>
                    </button>
                </div>
            </div>

        </div>

        <!-- Footer Note -->
        <div class="mt-8 text-center text-sm text-slate-500">
            <p>Thank you for shopping with GrosirKu!</p>
            <p class="mt-1">For any questions, please contact our customer support.</p>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .max-w-4xl, .max-w-4xl * {
            visibility: visible;
        }
        .max-w-4xl {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        button, a[href*="checkout"] {
            display: none !important;
        }
    }
</style>
@endsection
