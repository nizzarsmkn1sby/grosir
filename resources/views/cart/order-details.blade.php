@extends('layouts.public')

@section('title', 'Order Invoice - GrosirKu')

@section('content')
<div class="min-h-screen bg-[#f9fafb] py-16">
    <div class="max-w-5xl mx-auto px-6">
        <!-- Breadcrumb & Status -->
        <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-sm font-black text-gray-400 uppercase tracking-widest hover:text-orange-500 transition-colors mb-6">
                    <i class="fas fa-arrow-left text-[10px]"></i>
                    Kembali ke Terminal
                </a>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">Invoice Sourcing</h1>
                <p class="text-gray-500 font-bold mt-2">ID Transaksi: <span class="text-orange-600">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></p>
            </div>
            
            @if($order->payment && $order->payment->status == 'completed')
                <div class="px-8 py-3 bg-emerald-50 text-emerald-600 rounded-full text-xs font-black uppercase tracking-[0.2em] border border-emerald-100 flex items-center gap-3">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    VERIFIED & PAID
                </div>
            @else
                <div class="px-8 py-3 bg-orange-50 text-orange-600 rounded-full text-xs font-black uppercase tracking-[0.2em] border border-orange-100 flex items-center gap-3">
                    <span class="w-2 h-2 bg-orange-500 rounded-full shadow-[0_0_10px_rgba(255,80,0,0.5)]"></span>
                    AWAITING PAYMENT
                </div>
            @endif
        </div>

        <!-- Main Invoice Core -->
        <div class="bg-white rounded-[32px] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            
            <!-- Invoice Header Bar -->
            <div class="bg-[#1a1a1a] p-12 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <div class="text-3xl font-black tracking-tighter text-orange-500 mb-2">GrosirKu.</div>
                        <p class="text-gray-400 text-xs font-black uppercase tracking-widest">Premium Wholesale Terminal</p>
                    </div>
                    <div class="text-right">
                        <div class="text-[10px] font-black text-orange-500 uppercase tracking-[0.2em] mb-2">Tanggal Terbit</div>
                        <div class="text-xl font-black">{{ $order->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Client & Sourcing Matrix -->
            <div class="p-12 grid md:grid-cols-2 gap-12 border-b border-gray-50">
                <div>
                    <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3">
                        <i class="fas fa-building text-orange-500"></i>
                        Informasi Client
                    </h3>
                    <div class="space-y-1">
                        <div class="text-lg font-black text-gray-900">{{ $order->user->name }}</div>
                        <div class="text-gray-500 font-bold text-sm">{{ $order->user->email }}</div>
                    </div>
                </div>

                @if($order->shipping)
                <div>
                    <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3">
                        <i class="fas fa-map-marker-alt text-orange-500"></i>
                        Destinasi Logistik
                    </h3>
                    <div class="text-sm font-bold text-gray-600 leading-relaxed bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        {{ $order->shipping->address }}<br>
                        {{ $order->shipping->city }}, {{ $order->shipping->state }} - {{ $order->shipping->postal_code }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Manifest Items -->
            <div class="p-12">
                <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                    <i class="fas fa-list-ul text-orange-500"></i>
                    Manifest Pengadaan Barang
                </h3>

                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center gap-6 p-6 rounded-3xl border border-gray-50 hover:border-orange-100 hover:bg-orange-50/10 transition-all duration-300">
                        <div class="w-20 h-20 rounded-2xl bg-gray-50 border border-gray-100 flex-shrink-0 flex items-center justify-center overflow-hidden">
                            @if($item->product->image_url)
                                <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-box text-2xl text-gray-200"></i>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <div class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-1">{{ $item->product->category->name ?? 'Kategori' }}</div>
                            <h4 class="text-lg font-black text-gray-900">{{ $item->product->name }}</h4>
                            <div class="text-xs font-bold text-gray-400 mt-2">Unit Price: Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>

                        <div class="text-center px-6">
                            <div class="text-[10px] font-black text-gray-300 uppercase mb-1">Quantity</div>
                            <div class="text-lg font-black text-gray-900">{{ $item->quantity }} <span class="text-xs text-gray-400">Unit</span></div>
                        </div>

                        <div class="text-right pl-6 border-l border-gray-100">
                            <div class="text-[10px] font-black text-gray-300 uppercase mb-1">Total</div>
                            <div class="text-xl font-black text-orange-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Financial Recap -->
            <div class="px-12 py-10 bg-gray-50/50 border-t border-gray-50">
                <div class="max-w-xs ml-auto space-y-4">
                    <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-widest">
                        <span>Subtotal Manifest</span>
                        <span class="text-gray-900 font-black">Rp {{ number_format($order->orderItems->sum(fn($item) => $item->price * $item->quantity), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xs font-bold text-gray-400 uppercase tracking-widest">
                        <span>Biaya Logistik</span>
                        <span class="text-emerald-600 font-black">FREE SOURCING</span>
                    </div>
                    <div class="pt-6 mt-6 border-t border-gray-200 flex justify-between items-end">
                        <div class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Grand Total</div>
                        <div class="text-4xl font-black text-gray-900 tracking-tighter">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Payment Protocol -->
            @if($order->payment)
            <div class="p-12 border-t border-gray-50 bg-white">
                <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                    <i class="fas fa-shield-check text-orange-500"></i>
                    Protokol Pembayaran Terverifikasi
                </h3>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Metode Bayar</span>
                            <span class="text-sm font-black text-gray-900">{{ $order->payment->payment_type ? ucfirst(str_replace('_', ' ', $order->payment->payment_type)) : 'Gateway Sistem' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status Kliring</span>
                            @if($order->payment->status == 'completed')
                                <span class="bg-emerald-500 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest">TERVERIFIKASI</span>
                            @else
                                <span class="bg-orange-500 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest">PENDING</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100 flex flex-col justify-center">
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Internal Transaction Hash</div>
                        <div class="text-xs font-mono font-bold text-gray-600 break-all">{{ $order->payment->transaction_id ?? 'HASH_PENDING_RECORDS' }}</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Operations -->
            <div class="p-12 bg-white border-t border-gray-50 flex items-center justify-between gap-6">
                <div>
                    @if($order->payment && $order->payment->status != 'completed')
                        <div class="flex items-center gap-4">
                            <a href="{{ route('order.pay', $order->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white px-10 py-5 rounded-full font-black text-sm uppercase tracking-widest shadow-2xl shadow-orange-500/20 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center gap-3">
                                <i class="fas fa-credit-card"></i>
                                Bayar Pesanan Sekarang
                            </a>
                            <div class="text-[10px] font-black text-orange-600 uppercase tracking-widest animate-pulse">Menunggu Settle Dana</div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 text-emerald-600">
                            <i class="fas fa-check-double"></i>
                            <span class="text-xs font-black uppercase tracking-widest">Transaksi Selesai & Terverifikasi</span>
                        </div>
                    @endif
                </div>

                <button onclick="window.print()" class="p-5 bg-gray-900 text-white rounded-full hover:bg-orange-600 transition-all shadow-xl hover:shadow-orange-500/20 group">
                    <i class="fas fa-print group-hover:scale-110 transition-transform"></i>
                </button>
            </div>

        </div>

        <div class="mt-12 text-center">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Official GrosirKu Sourcing Terminal Record</p>
            <p class="text-gray-300 text-[10px] mt-2">© 2024 Premium Wholesale Marketplace Ecosystem. All records are digitally signed.</p>
        </div>
    </div>
</div>

<style>
    @media print {
        body { background: white !important; }
        .min-h-screen { py-0 !important; }
        nav, footer, .mb-12 a, .operations button, .px-12 a, .p-12 button { display: none !important; }
        .bg-white { shadow-none !important; border-none !important; }
        .shadow-2xl { box-shadow: none !important; }
    }
</style>
@endsection
