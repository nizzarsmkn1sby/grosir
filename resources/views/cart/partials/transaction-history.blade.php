<div class="mt-16">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-black text-slate-900 flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                <i class="fas fa-history text-white text-xl"></i>
            </div>
            Transaction History
        </h2>
        @if($orders->count() > 0)
        <a href="#" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm flex items-center gap-2 group">
            View All
            <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
        </a>
        @endif
    </div>

    @if($orders->count() > 0)
    <div class="grid gap-5">
        @foreach($orders as $order)
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:border-indigo-100 transition-all duration-300 group">
            <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                <!-- Order Icon & Info -->
                <div class="flex items-start gap-4 flex-1">
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl flex items-center justify-center border-2 border-white shadow-sm group-hover:scale-110 transition-transform">
                            @if($order->payment && $order->payment->status == 'completed')
                                <i class="fas fa-check-circle text-2xl text-emerald-500"></i>
                            @else
                                <i class="fas fa-exclamation-circle text-2xl text-rose-500"></i>
                            @endif
                        </div>
                        <!-- Status Badge on Icon -->
                        <div class="absolute -top-1 -right-1 w-5 h-5 rounded-full border-2 border-white shadow-sm
                            @if($order->payment && $order->payment->status == 'completed') bg-emerald-500
                            @else bg-rose-500 @endif">
                        </div>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            <h3 class="font-black text-lg text-slate-900">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
                            
                            <!-- Payment Status Badge Only -->
                            @if($order->payment && $order->payment->status == 'completed')
                                <span class="px-4 py-2 rounded-xl text-sm font-bold uppercase tracking-wider shadow-lg bg-gradient-to-r from-emerald-500 to-emerald-600 text-white flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i>
                                    PAID
                                </span>
                            @else
                                <span class="px-4 py-2 rounded-xl text-sm font-bold uppercase tracking-wider shadow-lg bg-gradient-to-r from-rose-500 to-rose-600 text-white flex items-center gap-2">
                                    <i class="fas fa-exclamation-circle"></i>
                                    UNPAID
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-2 text-sm text-slate-500 mb-3">
                            <i class="far fa-calendar text-indigo-400"></i>
                            <span class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            @if($order->payment && $order->payment->transaction_id)
                            <span class="mx-2 text-slate-300">•</span>
                            <i class="fas fa-receipt text-indigo-400"></i>
                            <span class="font-mono text-xs">{{ $order->payment->transaction_id }}</span>
                            @endif
                        </div>

                        <!-- Items Summary -->
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-2 flex items-center gap-2">
                                <i class="fas fa-box text-indigo-400"></i>
                                Items Purchased
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($order->orderItems->take(3) as $item)
                                    <div class="bg-white px-3 py-1.5 rounded-lg border border-slate-200 text-sm font-semibold text-slate-700 flex items-center gap-2">
                                        <span>{{ $item->product->name }}</span>
                                        <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full">×{{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                                @if($order->orderItems->count() > 3)
                                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-3 py-1.5 rounded-lg text-sm font-bold text-indigo-600">
                                        +{{ $order->orderItems->count() - 3 }} more
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Info & Actions -->
                <div class="flex items-center gap-4 lg:flex-col lg:items-end">
                    <div class="flex-1 lg:flex-none lg:text-right">
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1 flex items-center gap-2 lg:justify-end">
                            <i class="fas fa-wallet text-indigo-400"></i>
                            Total Payment
                        </p>
                        <p class="text-2xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </p>
                        @if($order->payment && $order->payment->payment_type)
                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1 lg:justify-end">
                            <i class="fas fa-credit-card text-indigo-400"></i>
                            {{ ucfirst(str_replace('_', ' ', $order->payment->payment_type)) }}
                        </p>
                        @endif
                    </div>

                    <a href="{{ route('order.details', $order->id) }}" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-indigo-600 hover:to-purple-600 text-white px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 flex items-center gap-2 group shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="fas fa-eye"></i>
                        <span>Details</span>
                        <i class="fas fa-chevron-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Payment Status Timeline (if paid) -->
            @if($order->payment && $order->payment->status == 'completed')
            <div class="mt-4 pt-4 border-t border-slate-100">
                <div class="flex items-center gap-3 text-sm">
                    <div class="flex items-center gap-2 text-emerald-600">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                        <i class="fas fa-check-circle"></i>
                        <span class="font-semibold">Payment Verified</span>
                    </div>
                    <span class="text-slate-300">•</span>
                    <span class="text-slate-500">
                        <i class="far fa-clock"></i>
                        {{ $order->payment->paid_at ? $order->payment->paid_at->diffForHumans() : 'Recently' }}
                    </span>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Pagination hint -->
    <div class="mt-6 text-center">
        <p class="text-sm text-slate-400">
            Showing {{ $orders->count() }} recent {{ Str::plural('transaction', $orders->count()) }}
        </p>
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-gradient-to-br from-slate-50 to-indigo-50 rounded-3xl p-16 text-center border-2 border-dashed border-slate-200">
        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
            <i class="fas fa-shopping-bag text-4xl text-slate-300"></i>
        </div>
        <h3 class="text-xl font-black text-slate-700 mb-2">No Transactions Yet</h3>
        <p class="text-slate-500 mb-6 max-w-md mx-auto">
            Your transaction history will appear here after you complete your first purchase. Start shopping now!
        </p>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">
            <i class="fas fa-shopping-cart"></i>
            Browse Products
        </a>
    </div>
    @endif
</div>
