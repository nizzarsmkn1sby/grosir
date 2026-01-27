@extends('layouts.public')

@section('title', 'Admin Terminal - GrosirKu')

@push('styles')
<style>
    :root {
        --alibaba-orange: #FF5000;
        --alibaba-orange-hover: #E64500;
        --terminal-dark: #0f172a;
    }

    .dashboard-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Header */
    .dashboard-header {
        background: var(--terminal-dark);
        color: white;
        padding: 4rem;
        border-radius: 32px;
        margin-bottom: 4rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 30px 60px -12px rgba(15, 23, 42, 0.3);
    }

    .dashboard-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 400px;
        height: 100%;
        background: radial-gradient(circle at center, rgba(255, 80, 0, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    .dashboard-header h1 {
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 0.75rem;
        letter-spacing: -0.04em;
    }

    .dashboard-header p {
        font-size: 1.25rem;
        opacity: 0.6;
        font-weight: 500;
    }

    .header-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 2rem;
        color: var(--alibaba-orange);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 4rem;
    }

    .stat-card-premium {
        background: white;
        border-radius: 24px;
        padding: 2.5rem;
        border: 1px solid #f1f5f9;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .stat-card-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.08);
        border-color: var(--alibaba-orange);
    }

    .stat-icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--terminal-dark);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .stat-card-premium:hover .stat-icon-wrapper {
        background: var(--alibaba-orange);
        color: white;
    }

    .stat-value {
        font-size: 3rem;
        font-weight: 900;
        color: var(--terminal-dark);
        letter-spacing: -0.02em;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1rem;
        font-weight: 700;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .trend-indicator {
        font-size: 0.75rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 100px;
        background: #f0fdf4;
        color: #16a34a;
    }

    /* Financial Terminal */
    .financial-terminal {
        background: white;
        border-radius: 32px;
        padding: 4rem;
        border: 1px solid #f1f5f9;
        margin-bottom: 4rem;
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 900;
        letter-spacing: -0.02em;
        margin-bottom: 3rem;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .financial-matrix {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2.5rem;
    }

    .matrix-item {
        padding: 2.5rem;
        border-radius: 24px;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
    }

    .matrix-label {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
        margin-bottom: 1rem;
        display: block;
    }

    .matrix-value {
        font-size: 2rem;
        font-weight: 900;
        color: var(--terminal-dark);
    }

    /* History Table */
    .terminal-table-wrapper {
        background: white;
        border-radius: 32px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }

    .terminal-table {
        width: 100%;
        border-collapse: collapse;
    }

    .terminal-table th {
        background: #f8fafc;
        padding: 1.5rem 2rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        border-bottom: 1px solid #f1f5f9;
    }

    .terminal-table td {
        padding: 1.75rem 2rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--terminal-dark);
    }

    .terminal-table tr:last-child td {
        border-bottom: none;
    }

    .terminal-table tr:hover {
        background: #fcfdfe;
    }

    .order-id-badge {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8125rem;
        color: var(--alibaba-orange);
        background: #fff7f2;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
    }

    .status-badge-premium {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.6875rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-delivered { background: #f0fdf4; color: #16a34a; }
    .status-processing { background: #eff6ff; color: #2563eb; }
    .status-pending { background: #fffbeb; color: #d97706; }

    .btn-terminal-action {
        padding: 10px 20px;
        border-radius: 12px;
        background: var(--terminal-dark);
        color: white;
        font-size: 0.8125rem;
        font-weight: 800;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-terminal-action:hover {
        background: var(--alibaba-orange);
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(255, 80, 0, 0.2);
    }

    @media (max-width: 1024px) {
        .dashboard-header { padding: 2.5rem; }
        .dashboard-header h1 { font-size: 2.25rem; }
        .financial-terminal { padding: 2rem; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="header-badge">
        <span class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
        Sistem Analytics Aktif
    </div>
    
    <div class="dashboard-header">
        <h1>Admin Control Terminal.</h1>
        <p>Ringkasan real-time aktivitas ekosistem GrosirKu.</p>
    </div>

    @php
        $totalOrders = \App\Models\Order::count();
        $totalProducts = \App\Models\Product::count();
        $totalUsers = \App\Models\User::count();
        $totalRevenue = \App\Models\Order::where('status', 'delivered')->sum('total_price');
    @endphp

    <div class="stats-grid">
        <div class="stat-card-premium">
            <div class="stat-icon-wrapper">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-value">{{ number_format($totalOrders) }}</div>
            <div class="stat-label">
                Total Orders 
                <span class="trend-indicator"><i class="fas fa-arrow-up"></i> 12.5%</span>
            </div>
        </div>

        <div class="stat-card-premium">
            <div class="stat-icon-wrapper">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-value">Rp {{ number_format($totalRevenue / 1000000, 1) }}M</div>
            <div class="stat-label">
                Volume Revenue
                <span class="trend-indicator"><i class="fas fa-arrow-up"></i> 24.8%</span>
            </div>
        </div>

        <div class="stat-card-premium">
            <div class="stat-icon-wrapper">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-value">{{ number_format($totalUsers) }}</div>
            <div class="stat-label">Verified Users</div>
        </div>
    </div>

    <div class="financial-terminal">
        <div class="section-title">
            <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center text-white text-sm">
                <i class="fas fa-wallet"></i>
            </div>
            Financial Recap Protocol
        </div>
        
        <div class="financial-matrix">
            <div class="matrix-item">
                <span class="matrix-label">Gross Revenue</span>
                <div class="matrix-value text-emerald-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
            <div class="matrix-item">
                <span class="matrix-label">Operating Costs</span>
                <div class="matrix-value">Rp 0</div>
            </div>
            <div class="matrix-item">
                <span class="matrix-label">Net Net Profit</span>
                <div class="matrix-value text-orange-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="terminal-table-wrapper">
        <div class="p-8 border-b border-gray-100 flex items-center justify-between bg-white">
            <div class="text-sm font-black uppercase tracking-widest text-gray-400">Log Transaksi Terakhir</div>
            <a href="#" class="text-xs font-black text-orange-600 uppercase tracking-widest hover:underline">Lihat Semua Protokol</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="terminal-table">
                <thead>
                    <tr>
                        <th>Protokol ID</th>
                        <th>Entitas Client</th>
                        <th>Timestamp</th>
                        <th>Valuasi</th>
                        <th>State</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $transactions = \App\Models\Order::with('user')->latest()->take(8)->get();
                    @endphp
                    @foreach($transactions as $order)
                    <tr>
                        <td><span class="order-id-badge">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                        <td>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-900 flex items-center justify-center text-white text-xs font-black">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black">{{ $order->user->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $order->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-500 font-bold">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="font-black text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            @if($order->status == 'delivered')
                                <span class="status-badge-premium status-delivered"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> DELIVERED</span>
                            @elseif($order->status == 'pending')
                                <span class="status-badge-premium status-pending"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> PENDING</span>
                            @else
                                <span class="status-badge-premium status-processing"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> {{ strtoupper($order->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('order.details', $order->id) }}" class="btn-terminal-action">
                                <i class="fas fa-expand-alt"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
