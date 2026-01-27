@extends('layouts.public')

@section('title', 'Terminal Keranjang - Sourcing Ecosystem')

@push('styles')
<style>
    /* Premium Cart Terminal Styles */
    .cart-terminal-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .terminal-header-module {
        background: #0f172a;
        padding: 5rem 0;
        margin-bottom: 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        position: relative;
        overflow: hidden;
    }

    .terminal-header-module::before {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translateX(-50%);
        width: 1000px;
        height: 100px;
        background: var(--alibaba-orange);
        filter: blur(120px);
        opacity: 0.1;
    }

    .terminal-header-title h1 {
        color: white;
        font-size: 3rem;
        font-weight: 900;
        letter-spacing: -0.04em;
        line-height: 1;
    }

    .terminal-header-subtitle {
        color: #64748b;
        font-weight: 700;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .terminal-tabs-nav {
        background: rgba(255, 255, 255, 0.03);
        padding: 8px;
        border-radius: 100px;
        display: inline-flex;
        gap: 12px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
    }

    .terminal-tab-btn {
        padding: 1rem 2.5rem;
        border-radius: 100px;
        color: #94a3b8;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        background: transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .terminal-tab-btn:hover {
        color: white;
        background: rgba(255, 255, 255, 0.02);
    }

    .terminal-tab-btn.active {
        background: var(--alibaba-orange);
        color: white;
        box-shadow: 0 15px 30px rgba(255, 80, 0, 0.25);
    }

    /* Tab Counters */
    .tab-counter {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 10px;
        padding: 4px 8px;
        border-radius: 100px;
        font-weight: 900;
    }

    .terminal-tab-btn.active .tab-counter {
        background: white;
        color: var(--alibaba-orange);
    }
</style>
@endpush

@section('header')
<div class="terminal-header-module" x-data="{ activeTab: 'cart' }" @tab-change.window="activeTab = $event.detail">
    <div class="container mx-auto px-8 flex flex-col lg:flex-row justify-between items-center gap-12">
        <div class="terminal-header-title">
            <div class="terminal-header-subtitle">
                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                Secure Transaction Protocols
            </div>
            <h1 class="mt-4">Sourcing Terminal</h1>
        </div>

        <div class="terminal-tabs-nav">
            <button 
                @click="$dispatch('tab-change', 'cart')" 
                :class="activeTab === 'cart' ? 'active' : ''"
                class="terminal-tab-btn">
                <i class="fas fa-microchip"></i>
                <span>Active Cart</span>
                @if(count($cart) > 0)
                    <span class="tab-counter">{{ count($cart) }}</span>
                @endif
            </button>
            <button 
                @click="$dispatch('tab-change', 'history')" 
                :class="activeTab === 'history' ? 'active' : ''"
                class="terminal-tab-btn">
                <i class="fas fa-server"></i>
                <span>Manifest History</span>
            </button>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="cart-terminal-container" x-data="{ activeTab: 'cart' }" @tab-change.window="activeTab = $event.detail">
    <div class="py-20">
        <!-- Section: Active Cart -->
        <div x-show="activeTab === 'cart'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-12" x-transition:enter-end="opacity-100 translate-y-0">
            @include('cart.partials.cart-items')
        </div>

        <!-- Section: Manifest History -->
        <div x-show="activeTab === 'history'" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-12" x-transition:enter-end="opacity-100 translate-y-0">
            @include('cart.partials.transaction-history')
        </div>
    </div>
</div>

<script>
    function incrementQty(btn) {
        const input = btn.previousElementSibling;
        input.value = parseInt(input.value) + 1;
        input.dispatchEvent(new Event('change'));
    }

    function decrementQty(btn) {
        const input = btn.nextElementSibling;
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            input.dispatchEvent(new Event('change'));
        }
    }
</script>
@endsection
