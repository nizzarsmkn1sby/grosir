@if(count($cart) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Terminal Items Manifest -->
        <div class="lg:col-span-8">
            <div class="space-y-6">
                @foreach($cart as $item)
                <div class="bg-white rounded-[32px] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all flex flex-col md:flex-row items-center gap-8">
                    <!-- Image Module -->
                    <div class="w-32 h-32 bg-slate-50 rounded-2xl flex items-center justify-center flex-shrink-0 border border-slate-100 overflow-hidden">
                        @if(isset($item['image']))
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-industry text-3xl text-slate-100"></i>
                        @endif
                    </div>
                    
                    <!-- Content Module -->
                    <div class="flex-1 text-center md:text-left">
                        <div class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-1">Batch Unit Resource</div>
                        <h3 class="text-xl font-black text-slate-900 mb-2">{{ $item['name'] ?? 'Undefined Resource' }}</h3>
                        <div class="text-sm font-bold text-slate-400">Exchange Rate: Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }} / Unit</div>
                        
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-8 mt-8">
                            <!-- Qty Control Terminal -->
                            <div class="bg-slate-50 p-1 rounded-full flex items-center border border-slate-100">
                                <form action="{{ route('cart.update', $item['id'] ?? 0) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-900 hover:bg-orange-500 hover:text-white transition-all" onclick="decrementQty(this)">
                                        <i class="fas fa-minus text-[10px]"></i>
                                    </button>
                                    <input type="number" name="quantity" value="{{ $item['quantity'] ?? 1 }}" min="1" readonly class="w-16 bg-transparent text-center font-black text-slate-900 border-none outline-none focus:ring-0" onchange="this.form.submit()">
                                    <button type="button" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-900 hover:bg-orange-500 hover:text-white transition-all" onclick="incrementQty(this)">
                                        <i class="fas fa-plus text-[10px]"></i>
                                    </button>
                                </form>
                            </div>

                            <form action="{{ route('cart.remove', $item['id'] ?? 0) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] font-black text-slate-300 hover:text-red-500 uppercase tracking-widest transition-all flex items-center gap-2 group">
                                    <i class="fas fa-trash-alt opacity-20 group-hover:opacity-100"></i> Drop Manifest
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Price Column -->
                    <div class="md:text-right pt-6 md:pt-0 border-t md:border-none border-slate-50 w-full md:w-auto">
                        <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Total Valuation</div>
                        <div class="text-2xl font-black text-slate-900">Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Global Protocols -->
            <div class="mt-12 flex flex-col md:flex-row justify-between items-center px-8 text-center gap-6">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-[10px] font-black text-slate-300 hover:text-red-600 uppercase tracking-widest transition-all flex items-center gap-3">
                        <i class="fas fa-power-off text-xs opacity-20"></i> Purge All Manifests
                    </button>
                </form>
                <a href="{{ route('products.index') }}" class="text-[10px] font-black text-slate-900 hover:text-orange-600 uppercase tracking-widest transition-all flex items-center gap-3 bg-white px-8 py-3 rounded-full border border-slate-200">
                    <i class="fas fa-plus-circle text-xs text-orange-500"></i> Open Manifest Hub
                </a>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="lg:col-span-4">
            <div class="bg-[#0f172a] rounded-[40px] p-10 text-white sticky top-32 border border-white/5 shadow-2xl overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500 blur-[80px] opacity-20"></div>
                
                <h3 class="text-xl font-black mb-10 pb-6 border-b border-white/10 uppercase tracking-wider">Financial Summary</h3>
                
                <div class="space-y-6">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active Manifests</span>
                        <span class="text-sm font-bold">{{ count($cart) }} Items</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Gross Valuation</span>
                        <span class="text-sm font-bold text-slate-300">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Logistic Protocol</span>
                        <span class="text-[10px] font-black text-green-500 bg-green-500/10 px-3 py-1 rounded-full uppercase">Integrated</span>
                    </div>
                </div>
                
                <div class="my-10 border-t border-dashed border-white/10"></div>
                
                <div class="space-y-2 mb-12">
                    <div class="text-[10px] font-black text-orange-500 uppercase tracking-[0.2em]">Net Capital Expenditure</div>
                    <div class="text-4xl font-black">Rp {{ number_format($total, 0, ',', '.') }}</div>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn-terminal-primary w-full py-6">
                    <i class="fas fa-shield-check text-base"></i> Execute Protocol
                </a>
                
                <div class="mt-12 pt-10 border-t border-white/5">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center flex-shrink-0 text-orange-500">
                            <i class="fas fa-fingerprint shadow-glow"></i>
                        </div>
                        <div class="text-[10px] leading-relaxed text-slate-400 font-bold">
                            <span class="text-white block mb-1">Trade Protection Active</span>
                            Encryption protocols secured. Order manifest fully compliant with wholesale terminal v.1.0 standards.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="text-center py-24 bg-white rounded-[40px] border border-slate-100 shadow-sm max-w-4xl mx-auto">
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-10 text-slate-100 text-4xl">
            <i class="fas fa-box-open"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">Manifest is Offline</h2>
        <p class="text-slate-400 font-bold mb-12 max-w-xs mx-auto text-sm leading-relaxed">System has not detected any active resource identification packets in the current session.</p>
        <a href="{{ route('products.index') }}" class="btn-terminal-primary">
            Initialize Sourcing Hub <i class="fas fa-bolt"></i>
        </a>
    </div>
@endif
