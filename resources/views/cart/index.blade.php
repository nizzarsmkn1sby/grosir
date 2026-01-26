@extends('layouts.public')

@section('title', 'Keranjang Belanja - GrosirKu')

@push('styles')
<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.3);
        --accent-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --card-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    [x-cloak] { display: none !important; }

    /* New Premium Sub-Navbar Style */
    .cart-page-v2 {
        background: #f8fafc;
        min-height: 100vh;
    }

    .sub-navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2.5rem 0;
        margin-bottom: 0;
        box-shadow: 0 10px 15px -10px rgba(0,0,0,0.1);
    }

    .tab-switcher-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        padding: 0.4rem;
        border-radius: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: flex;
        gap: 0.5rem;
    }

    .tab-trigger {
        padding: 0.75rem 1.5rem;
        border-radius: 1rem;
        font-weight: 700;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
        border: none;
        background: transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .tab-trigger:hover {
        color: white;
        background: rgba(255, 255, 255, 0.05);
    }

    .tab-trigger.active {
        background: white;
        color: #764ba2;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .count-badge {
        background: #ef4444;
        color: white;
        font-size: 0.7rem;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    /* Premium Sub-Navbar Style */
    .sub-navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 3rem 0;
        margin-top: -2rem; /* Pull up to match navbar flush if main has padding */
        box-shadow: 0 10px 30px -10px rgba(102, 126, 234, 0.5);
    }

    /* Reset negative margin if navbar is already flush */
    body main { padding-top: 0 !important; }

    .tab-switcher-container {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        padding: 0.5rem;
        border-radius: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        gap: 0.5rem;
    }

    .tab-trigger {
        padding: 0.85rem 2rem;
        border-radius: 1.125rem;
        font-weight: 800;
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.9);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        background: transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.875rem;
    }

    .tab-trigger:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }

    .tab-trigger.active {
        background: white;
        color: #764ba2;
        box-shadow: 0 15px 25px -5px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .count-badge {
        background: #ff4757;
        color: white;
        font-size: 0.75rem;
        min-width: 20px;
        height: 20px;
        padding: 0 6px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        box-shadow: 0 4px 6px rgba(255, 71, 87, 0.3);
    }

    .cart-page-content {
        min-height: 100vh;
        background: #f8fafc;
    }

    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2.5rem;
        align-items: start;
    }

    .cart-items-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .cart-card {
        background: white;
        border-radius: 1.5rem;
        padding: 1.5rem;
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 2rem;
        align-items: center;
        box-shadow: var(--card-shadow);
        border: 1px solid #f1f5f9;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .cart-card:hover { transform: translateY(-4px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08); }

    .item-image-wrapper { width: 120px; height: 120px; background: #f1f5f9; border-radius: 1rem; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .item-image-wrapper i { font-size: 2.5rem; color: #94a3b8; }
    .item-details h3 { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem; }
    .item-price { font-size: 1.1rem; color: #64748b; font-weight: 500; }
    .item-subtotal { font-size: 1.25rem; font-weight: 800; color: #6366f1; margin-top: 0.75rem; }

    .item-actions { display: flex; flex-direction: column; align-items: flex-end; justify-content: space-between; height: 100%; gap: 1rem; }

    .qty-switcher { display: flex; align-items: center; background: #f1f5f9; border-radius: 0.75rem; padding: 0.25rem; }
    .qty-btn { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; background: white; border: none; border-radius: 0.5rem; color: #1e293b; cursor: pointer; font-weight: bold; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .qty-btn:hover { background: #6366f1; color: white; }
    .qty-input { width: 50px; text-align: center; background: transparent; border: none; font-weight: 700; color: #1e293b; font-size: 1rem; }

    .btn-remove-v2 { color: #ef4444; background: #fef2f2; border: none; width: 40px; height: 40px; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .btn-remove-v2:hover { background: #ef4444; color: white; }

    .checkout-sidebar { background: white; border-radius: 2rem; padding: 2.5rem; box-shadow: var(--card-shadow); border: 1px solid #f1f5f9; position: sticky; top: 100px; }
    .summary-title { font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 1.25rem; color: #64748b; font-weight: 500; }
    .summary-divider { height: 1px; background: #f1f5f9; margin: 1.5rem 0; }
    .total-row { display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-top: 1rem; }

    .btn-checkout-v2 { width: 100%; background: var(--accent-gradient); color: white; padding: 1.25rem; border: none; border-radius: 1.25rem; font-size: 1.125rem; font-weight: 700; cursor: pointer; margin-top: 2rem; transition: all 0.3s; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3); text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.75rem; }
    .btn-checkout-v2:hover { transform: scale(1.02); box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.4); }

    .empty-state-v2 { background: white; border-radius: 3rem; padding: 6rem 2rem; text-align: center; box-shadow: var(--card-shadow); }
    .empty-state-v2 i { font-size: 6rem; margin-bottom: 2rem; background: var(--accent-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .empty-state-v2 h2 { font-size: 2rem; font-weight: 800; color: #1e293b; margin-bottom: 1rem; }
    .empty-state-v2 p { color: #64748b; font-size: 1.125rem; margin-bottom: 3rem; }
    .btn-explore { display: inline-flex; align-items: center; gap: 0.75rem; background: #1e293b; color: white; padding: 1rem 2.5rem; border-radius: 1.25rem; font-weight: 700; text-decoration: none; transition: background 0.2s; }
    .btn-explore:hover { background: #0f172a; }

    @media (max-width: 1024px) { .cart-grid { grid-template-columns: 1fr; } .checkout-sidebar { position: static; } }
    @media (max-width: 640px) { .cart-card { grid-template-columns: 80px 1fr; gap: 1rem; } .item-image-wrapper { width: 80px; height: 80px; } .item-actions { grid-column: span 2; flex-direction: row; align-items: center; height: auto; border-top: 1px solid #f1f5f9; padding-top: 1rem; } }
</style>
@endpush

@section('header')
<!-- Premium Sub-Navbar / Dash Header -->
<div class="sub-navbar" x-data="{ activeTab: 'cart' }" @tab-change.window="activeTab = $event.detail">
    <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="page-title-section">
            <h1 class="text-3xl font-black text-white">Shopping Terminal</h1>
            <p class="text-indigo-100 text-sm opacity-80">Manage items & track account history</p>
        </div>

        <!-- Modern Tab Toggle -->
        <div class="tab-switcher-wrapper">
            <div class="tab-switcher-container">
                <button 
                    @click="$dispatch('tab-change', 'cart')" 
                    :class="activeTab === 'cart' ? 'active' : ''"
                    class="tab-trigger">
                    <i class="fas fa-shopping-basket"></i>
                    <span>My Cart</span>
                    @if(count($cart) > 0)
                        <span class="count-badge">{{ count($cart) }}</span>
                    @endif
                </button>
                <button 
                    @click="$dispatch('tab-change', 'history')" 
                    :class="activeTab === 'history' ? 'active' : ''"
                    class="tab-trigger">
                    <i class="fas fa-history"></i>
                    <span>Order History</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="cart-page-content" x-data="{ activeTab: 'cart' }" @tab-change.window="activeTab = $event.detail">
    <!-- Content Area -->
    <div class="py-12">
        <!-- Cart Items Tab -->
        <div x-show="activeTab === 'cart'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
            @include('cart.partials.cart-items')
        </div>

        <!-- Transaction History Tab -->
        <div x-show="activeTab === 'history'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
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
