<div class="space-y-12">
    <!-- Terminal Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="text-[10px] font-black text-orange-500 uppercase tracking-[0.2em] mb-3 flex items-center gap-3">
                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                Archived Manifest Logs
            </div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Financial Records History</h2>
        </div>
        @if($orders->count() > 0)
        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest border border-slate-200 px-6 py-3 rounded-full">
            Total Validated Protocols: {{ $orders->count() }}
        </div>
        @endif
    </div>

    @if($orders->count() > 0)
    <div class="grid gap-6">
        @foreach($orders as $order)
        <div class="bg-white rounded-[32px] p-10 border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 group">
            <div class="flex flex-col lg:flex-row lg:items-center gap-12">
                <!-- Manifest Identity -->
                <div class="flex-shrink-0 lg:w-64">
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Manifest ID</div>
                    <div class="text-2xl font-black text-slate-900 group-hover:text-orange-500 transition-colors">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="mt-6 flex items-center gap-3 text-[10px] font-black text-slate-500 uppercase tracking-widest bg-slate-50 px-4 py-2 rounded-full w-fit border border-slate-100">
                        <i class="far fa-clock text-xs text-orange-500"></i>
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </div>
                </div>

                <!-- Status & Resource Pack -->
                <div class="flex-1 lg:border-l lg:border-slate-50 lg:pl-12">
                    <div class="flex items-center gap-5 mb-8">
                        @if($order->payment && $order->payment->status == 'completed')
                            <span class="px-5 py-2.5 bg-green-500/5 text-green-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-green-500/10 flex items-center gap-2">
                                <i class="fas fa-shield-check text-xs"></i> Verified Settlement
                            </span>
                        @else
                            <span class="px-5 py-2.5 bg-orange-500/5 text-orange-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-orange-500/10 flex items-center gap-2">
                                <i class="fas fa-terminal text-xs"></i> Pending Execution
                            </span>
                        @endif
                        
                        @if($order->payment && $order->payment->transaction_id)
                        <div class="hidden sm:flex items-center gap-2 text-[10px] font-mono text-slate-300 font-bold">
                            <i class="fas fa-fingerprint text-[8px]"></i>
                            {{ substr($order->payment->transaction_id, 0, 16) }}...
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-3">
                        @foreach($order->orderItems->take(4) as $item)
                            <div class="text-[11px] font-black text-slate-600 bg-slate-50 border border-slate-100 px-4 py-2 rounded-2xl flex items-center gap-3 transition-all hover:bg-white hover:shadow-lg">
                                <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
                                {{ $item->product->name }}
                                <span class="text-slate-300 font-black">× {{ $item->quantity }}</span>
                            </div>
                        @endforeach
                        @if($order->orderItems->count() > 4)
                            <div class="text-[10px] font-black text-orange-500 bg-orange-50 px-4 py-2 rounded-2xl flex items-center border border-orange-100">
                                +{{ $order->orderItems->count() - 4 }} More Manifests
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Financial Data & Actions -->
                <div class="flex-shrink-0 lg:text-right lg:border-l lg:border-slate-50 lg:pl-12">
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Net Valuation</div>
                    <div class="text-3xl font-black text-slate-900 mb-8">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                    
                    <a href="{{ route('order.details', $order->id) }}" class="inline-flex items-center gap-4 text-[10px] font-black uppercase tracking-widest bg-[#0f172a] text-white px-10 py-5 rounded-full hover:bg-orange-500 transition-all shadow-xl hover:shadow-orange-500/20 active:scale-95 group/btn">
                        Open Manifest Log
                        <i class="fas fa-external-link-alt text-[8px] opacity-20 group-hover/btn:opacity-100 group-hover/btn:translate-x-1 transition-all"></i>
                    </a>
                </div>
            </div>

            @if($order->payment && $order->payment->status == 'completed' && $order->payment->paid_at)
            <div class="mt-10 pt-8 border-t border-slate-50 flex items-center gap-4">
                <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center text-green-500 text-xs">
                    <i class="fas fa-check-double"></i>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Protocol finalized and funds settled to merchant on {{ $order->payment->paid_at->format('d M Y') }}</span>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="mt-12 flex justify-center">
        <div class="bg-slate-50 px-10 py-4 rounded-full border border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
            Data Synchronization Complete - {{ $orders->count() }} Manifests Loaded
        </div>
    </div>
    @else
    <!-- Premium Empty State -->
    <div class="bg-white rounded-[40px] p-24 text-center border-2 border-dashed border-slate-100 max-w-4xl mx-auto">
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-10 text-slate-200 text-4xl">
            <i class="fas fa-server"></i>
        </div>
        <h3 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Record Database Empty</h3>
        <p class="text-slate-400 font-bold mb-12 max-w-sm mx-auto text-sm leading-relaxed">
            No active manifest history detected. Initialize sourcing protocols to populate the terminal records.
        </p>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-4 bg-orange-500 text-white px-12 py-5 rounded-full font-black text-xs uppercase tracking-widest shadow-2xl shadow-orange-500/20 hover:bg-orange-600 transition-all hover:scale-105">
            <i class="fas fa-plus-circle text-base"></i>
            Initialize First Resource Acquisition
        </a>
    </div>
    @endif
</div>
