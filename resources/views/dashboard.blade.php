@extends('layouts.public')

@section('title', 'Dashboard - GrosirKu')

@push('styles')
<style>
    .dashboard-container {
        max-width: 1600px;
        margin: 0 auto;
    }

    /* Header */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 1.5rem;
        margin-bottom: 3rem;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
    }

    .dashboard-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .dashboard-header p {
        font-size: 1.125rem;
        opacity: 0.95;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: white;
        border-radius: 1.25rem;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--color-start), var(--color-end));
    }

    .stat-card.primary {
        --color-start: #667eea;
        --color-end: #764ba2;
    }

    .stat-card.success {
        --color-start: #10b981;
        --color-end: #059669;
    }

    .stat-card.warning {
        --color-start: #f59e0b;
        --color-end: #d97706;
    }

    .stat-card.danger {
        --color-start: #ef4444;
        --color-end: #dc2626;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .stat-card.primary .stat-icon {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        color: #667eea;
    }

    .stat-card.success .stat-icon {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
        color: #10b981;
    }

    .stat-card.warning .stat-icon {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1));
        color: #f59e0b;
    }

    .stat-card.danger .stat-icon {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
        color: #ef4444;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .stat-trend.up {
        color: #10b981;
    }

    .stat-trend.down {
        color: #ef4444;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #1f2937;
    }

    .stat-label {
        color: #6b7280;
        font-size: 1rem;
        font-weight: 500;
    }

    /* Financial Report */
    .financial-report {
        background: white;
        border-radius: 1.25rem;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 3rem;
    }

    .financial-report h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: #1f2937;
    }

    .financial-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .financial-item {
        padding: 1.5rem;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border-radius: 1rem;
        border-left: 4px solid;
    }

    .financial-item.revenue {
        border-left-color: #10b981;
    }

    .financial-item.expense {
        border-left-color: #ef4444;
    }

    .financial-item.profit {
        border-left-color: #667eea;
    }

    .financial-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }

    .financial-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }

    /* Transaction History */
    .transaction-history {
        background: white;
        border-radius: 1.25rem;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 3rem;
    }

    .transaction-history h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: #1f2937;
    }

    .transaction-filters {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.75rem 1.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        background: white;
        color: #6b7280;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        border-color: #667eea;
        background: #667eea;
        color: white;
    }

    .transaction-table {
        width: 100%;
        border-collapse: collapse;
    }

    .transaction-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .transaction-table th {
        color: white;
        padding: 1.25rem 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: sticky;
        top: 0;
        z-index: 10;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .transaction-table th:first-child {
        border-top-left-radius: 0.75rem;
    }

    .transaction-table th:last-child {
        border-top-right-radius: 0.75rem;
    }

    .transaction-table td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .transaction-table tr:hover {
        background: #f9fafb;
    }

    .badge {
        padding: 0.375rem 0.875rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge.completed {
        background: #d1fae5;
        color: #065f46;
    }

    .badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge.cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge.processing {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        color: #6b7280;
    }

    /* Charts Container */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .chart-card {
        background: white;
        border-radius: 1.25rem;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .chart-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #1f2937;
    }

    @media (max-width: 768px) {
        .dashboard-header h1 {
            font-size: 2rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .financial-grid {
            grid-template-columns: 1fr;
        }

        .charts-grid {
            grid-template-columns: 1fr;
        }

        .transaction-table {
            font-size: 0.875rem;
        }

        .transaction-filters {
            flex-direction: column;
        }

        .filter-btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <h1><i class="fas fa-chart-line"></i> Dashboard Analytics</h1>
        <p>Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>! Berikut ringkasan bisnis Anda.</p>
    </div>

    @php
        $totalOrders = \App\Models\Order::count();
        $totalProducts = \App\Models\Product::count();
        $totalUsers = \App\Models\User::count();
        $totalRevenue = \App\Models\Order::where('status', 'delivered')->sum('total_price');
        
        // Calculate trends (dummy for now, can be real calculation)
        $ordersTrend = '+12%';
        $revenueTrend = '+23%';
        $usersTrend = '+8%';
        $productsTrend = '+5%';
    @endphp

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $ordersTrend }}</span>
                </div>
            </div>
            <div class="stat-value">{{ number_format($totalOrders) }}</div>
            <div class="stat-label">Total Orders</div>
        </div>

        <div class="stat-card success">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $revenueTrend }}</span>
                </div>
            </div>
            <div class="stat-value">Rp {{ number_format($totalRevenue / 1000000, 1) }}M</div>
            <div class="stat-label">Total Revenue</div>
        </div>

        <div class="stat-card warning">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $usersTrend }}</span>
                </div>
            </div>
            <div class="stat-value">{{ number_format($totalUsers) }}</div>
            <div class="stat-label">Total Customers</div>
        </div>

        <div class="stat-card danger">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $productsTrend }}</span>
                </div>
            </div>
            <div class="stat-value">{{ number_format($totalProducts) }}</div>
            <div class="stat-label">Total Products</div>
        </div>
    </div>

    <!-- Financial Report -->
    <div class="financial-report">
        <h2><i class="fas fa-chart-pie"></i> Laporan Keuangan</h2>
        
        @php
            $totalRevenue = \App\Models\Order::where('status', 'delivered')->sum('total_price');
            $totalExpense = 0; // Bisa dihitung dari cost produk
            $totalProfit = $totalRevenue - $totalExpense;
        @endphp

        <div class="financial-grid">
            <div class="financial-item revenue">
                <div class="financial-label">
                    <i class="fas fa-arrow-up"></i> Total Pendapatan
                </div>
                <div class="financial-value">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>
            </div>

            <div class="financial-item expense">
                <div class="financial-label">
                    <i class="fas fa-arrow-down"></i> Total Pengeluaran
                </div>
                <div class="financial-value">
                    Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </div>
            </div>

            <div class="financial-item profit">
                <div class="financial-label">
                    <i class="fas fa-chart-line"></i> Laba Bersih
                </div>
                <div class="financial-value">
                    Rp {{ number_format($totalProfit, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div style="padding: 1.5rem; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 1rem; border-left: 4px solid #0ea5e9;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <i class="fas fa-info-circle" style="font-size: 2rem; color: #0ea5e9;"></i>
                <div>
                    <strong style="color: #0c4a6e; font-size: 1.125rem;">Profit Margin: {{ $totalRevenue > 0 ? number_format(($totalProfit / $totalRevenue) * 100, 1) : 0 }}%</strong>
                    <p style="color: #075985; margin-top: 0.25rem;">Performa keuangan bulan ini sangat baik!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="transaction-history">
        <h2><i class="fas fa-history"></i> Riwayat Transaksi</h2>
        
        <!-- Filters -->
        <div class="transaction-filters">
            <button class="filter-btn active">Semua</button>
            <button class="filter-btn">Delivered</button>
            <button class="filter-btn">Shipped</button>
            <button class="filter-btn">Processing</button>
            <button class="filter-btn">Pending</button>
            <button class="filter-btn">Cancelled</button>
        </div>

        @php
            $transactions = \App\Models\Order::with('user')->latest()->take(10)->get();
        @endphp

        @if($transactions->count() > 0)
        <div style="overflow-x: auto; border-radius: 0.75rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $order)
                    <tr>
                        <td><strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <strong>{{ $order->user->name }}</strong>
                                    <div style="font-size: 0.875rem; color: #6b7280;">{{ $order->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                        <td>{{ ucfirst($order->payment_method ?? 'COD') }}</td>
                        <td>
                            @if($order->status == 'delivered')
                                <span class="badge completed">Delivered</span>
                            @elseif($order->status == 'shipped')
                                <span class="badge processing">Shipped</span>
                            @elseif($order->status == 'processing')
                                <span class="badge processing">Processing</span>
                            @elseif($order->status == 'pending')
                                <span class="badge pending">Pending</span>
                            @else
                                <span class="badge cancelled">Cancelled</span>
                            @endif
                        </td>
                        <td>
                            <button style="background: #667eea; color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600;">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Belum Ada Transaksi</h3>
            <p>Transaksi akan muncul di sini setelah ada order</p>
        </div>
        @endif
    </div>
</div>
@endsection
