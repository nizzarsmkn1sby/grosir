@extends('layouts.public')

@section('title', 'Terminal Checkout - Secure Protocol')

@push('styles')
<style>
    /* Premium Checkout Terminal Styles */
    .checkout-terminal-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 10rem;
    }

    .checkout-header-terminal {
        background: #0f172a;
        padding: 4rem 0;
        margin-bottom: 5rem;
        position: relative;
        overflow: hidden;
    }

    .checkout-header-terminal::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 80, 0, 0.3), transparent);
    }

    .terminal-step-card {
        background: white;
        border-radius: 40px;
        padding: 4rem;
        border: 1px solid #f1f5f9;
        box-shadow: var(--shadow-premium);
        margin-bottom: 3rem;
    }

    .step-indicator-terminal {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 3.5rem;
    }

    .step-badge-terminal {
        width: 40px;
        height: 40px;
        background: var(--alibaba-orange);
        color: white;
        border-radius: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 0.875rem;
        box-shadow: 0 10px 20px rgba(255, 80, 0, 0.2);
    }

    .step-title-terminal {
        font-size: 1.5rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.03em;
    }

    .terminal-label {
        font-[10px];
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        margin-bottom: 1rem;
        display: block;
    }

    .terminal-input {
        width: 100%;
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        border-radius: 20px;
        padding: 1.25rem 1.5rem;
        font-weight: 700;
        color: #0f172a;
        transition: all 0.3s;
    }

    .terminal-input:focus {
        border-color: var(--alibaba-orange);
        background: white;
        outline: none;
        box-shadow: 0 0 0 5px rgba(255, 80, 0, 0.05);
    }

    .payment-module-terminal {
        background: #0f172a;
        border-radius: 32px;
        padding: 3rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .payment-grid-terminal {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        margin-top: 2.5rem;
    }

    .payment-option-terminal {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 20px;
        text-align: center;
        transition: all 0.3s;
    }

    .payment-option-terminal i {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: var(--alibaba-orange);
    }

    .payment-option-terminal span {
        display: block;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
    }

    .checkout-sidebar-dark {
        background: #0f172a;
        border-radius: 40px;
        padding: 3rem;
        color: white;
        position: sticky;
        top: 140px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 30px 60px rgba(0,0,0,0.2);
    }

    .btn-checkout-primary {
        @extend .btn-terminal-primary;
        width: 100%;
        margin-top: 3rem;
    }

    @media (max-width: 1024px) {
        .checkout-sidebar-dark { position: static; }
        .terminal-step-card { padding: 2.5rem; }
    }
</style>
@endpush

@section('content')
<div class="checkout-terminal-wrapper">
    <!-- Header -->
    <div class="checkout-header-terminal">
        <div class="container mx-auto px-8">
            <div class="text-[10px] font-black text-orange-500 uppercase tracking-[0.3em] mb-4">Transaction Protocol v.1.20</div>
            <h1 class="text-4xl font-black text-white tracking-tight">Secure Checkout Interface</h1>
        </div>
    </div>

    <div class="container mx-auto px-8">
        {{-- Protocol Error Handling --}}
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
        <div class="bg-red-500/5 border border-red-500/10 p-10 rounded-[40px] mb-12 flex items-center gap-10">
            <div class="w-20 h-20 bg-red-500 rounded-3xl flex items-center justify-center text-white text-3xl shadow-lg shadow-red-500/20">
                <i class="fas fa-shield-virus"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-black text-slate-900 mb-2">Protocol Desynchronization</h3>
                <p class="text-slate-500 font-bold text-sm mb-6">Critical data mismatch detected in current manifest. Please reset protocol environment to proceed.</p>
                <form action="{{ route('cart.force-clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-slate-900 text-white font-black py-4 px-10 rounded-full text-[10px] uppercase tracking-widest hover:bg-orange-500 transition-all">
                        Reset Environment
                    </button>
                </form>
            </div>
        </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <div class="lg:col-span-8">
                    <!-- Step 1: Logistics -->
                    <div class="terminal-step-card">
                        <div class="step-indicator-terminal">
                            <div class="step-badge-terminal">01</div>
                            <div class="step-title-terminal">Logistics Data Entry</div>
                        </div>
                        
                        <div class="mb-10">
                            <label class="terminal-label">Primary Destination Address</label>
                            <textarea name="address" class="terminal-input" rows="4" placeholder="Detailed logistics drop-off point..." required>{{ old('address') }}</textarea>
                            @error('address') <p class="text-red-500 text-[10px] mt-2 font-black uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            <div>
                                <label class="terminal-label">Operational City</label>
                                <input type="text" name="city" class="terminal-input" placeholder="City hub..." value="{{ old('city') }}" required>
                                @error('city') <p class="text-red-500 text-[10px] mt-2 font-black uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="terminal-label">Regional Province</label>
                                <input type="text" name="province" class="terminal-input" placeholder="Province..." value="{{ old('province') }}" required>
                                @error('province') <p class="text-red-500 text-[10px] mt-2 font-black uppercase">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="w-full md:w-1/2">
                            <label class="terminal-label">Zone Code (Postal)</label>
                            <input type="text" name="postal_code" class="terminal-input" placeholder="00000" value="{{ old('postal_code') }}" required>
                            @error('postal_code') <p class="text-red-500 text-[10px] mt-2 font-black uppercase">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Step 2: Payment Protocol -->
                    <div class="terminal-step-card">
                        <div class="step-indicator-terminal">
                            <div class="step-badge-terminal">02</div>
                            <div class="step-title-terminal">Escrow Settlement Protocol</div>
                        </div>
                        
                        <div class="payment-module-terminal">
                            <div class="flex items-center gap-6 mb-10">
                                <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center text-3xl shadow-inner border border-white/5">
                                    <i class="fas fa-fingerprint text-orange-500"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-white">Encrypted Gateway Active</h3>
                                    <p class="text-slate-400 font-bold text-sm">Automated settlement via Midtrans Secure Node</p>
                                </div>
                            </div>

                            <div class="payment-grid-terminal">
                                <div class="payment-option-terminal">
                                    <i class="fas fa-university"></i>
                                    <span>Bank Transfer</span>
                                </div>
                                <div class="payment-option-terminal">
                                    <i class="fas fa-credit-card"></i>
                                    <span>Cards</span>
                                </div>
                                <div class="payment-option-terminal">
                                    <i class="fas fa-wallet"></i>
                                    <span>E-Wallet</span>
                                </div>
                                <div class="payment-option-terminal">
                                    <i class="fas fa-store"></i>
                                    <span>OTC Hubs</span>
                                </div>
                            </div>

                            <div class="mt-10 flex items-center gap-4 text-[10px] font-black text-slate-500 uppercase tracking-widest bg-white/5 p-6 rounded-2xl">
                                <i class="fas fa-info-circle text-orange-500 text-sm"></i>
                                Multiple gateway nodes will be available for final selection in the next stage.
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" value="midtrans">
                    </div>
                </div>

                <!-- Sidebar: Summary Terminal -->
                <div class="lg:col-span-4">
                    <div class="checkout-sidebar-dark">
                        <h3 class="text-xl font-black mb-10 pb-6 border-b border-white/10 uppercase tracking-widest">Manifest Review</h3>
                        
                        <div class="space-y-6 mb-10 max-h-[400px] overflow-y-auto pr-4 custom-scrollbar">
                            @foreach($cart as $item)
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="text-[11px] font-black text-white leading-tight mb-1">{{ $item['name'] ?? 'Undefined Resource' }}</div>
                                    <div class="text-[9px] font-black text-slate-500 uppercase tracking-widest">BATCH SIZE: {{ $item['quantity'] ?? 0 }}</div>
                                </div>
                                <div class="text-[11px] font-black text-orange-500">
                                    IDR {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="pt-8 border-t border-white/10 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Gross Valuation</span>
                                <span class="text-sm font-bold">IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Logistics Fee</span>
                                <span class="text-[10px] font-black text-green-500 uppercase bg-green-500/10 px-3 py-1 rounded-full">Automated</span>
                            </div>
                        </div>
                        
                        <div class="my-10 border-t border-dashed border-white/10"></div>
                        
                        <div class="space-y-1 mb-10">
                            <div class="text-[10px] font-black text-orange-500 uppercase tracking-[0.2em]">Net Capital Total</div>
                            <div class="text-3xl font-black">IDR {{ number_format($total, 0, ',', '.') }}</div>
                        </div>

                        <button type="submit" class="btn-terminal-primary w-full mt-10">
                            <i class="fas fa-bolt"></i>
                            Execute Settlement
                        </button>
                        
                        <div class="mt-12 text-center">
                            <div class="flex items-center justify-center gap-3 text-[9px] font-black text-slate-500 uppercase tracking-widest mb-4">
                                <i class="fas fa-shield-alt text-orange-500"></i>
                                Ecosystem Trust Protocol Active
                            </div>
                            <p class="text-[9px] text-slate-500 font-bold leading-relaxed">
                                Execution of this protocol constitutes formal acceptance of the Wholesale Terminal v.1.0 Service Agreements.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
