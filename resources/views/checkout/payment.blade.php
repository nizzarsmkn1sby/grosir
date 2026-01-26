@extends('layouts.public')

@section('title', 'Pembayaran - GrosirKu')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8 text-center">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-credit-card text-3xl text-blue-600"></i>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Selesaikan Pembayaran</h2>
                <p class="text-gray-500 mb-8">Pesanan Anda telah berhasil dibuat. Silakan selesaikan pembayaran untuk memproses pesanan.</p>

                <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-100 text-left">
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-600">ID Pesanan</span>
                        <span class="font-semibold text-gray-900">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-600">Total Pembayaran</span>
                        <span class="font-bold text-blue-600 text-xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Metode Pembayaran</span>
                        <span class="text-gray-900">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <button id="pay-button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-1">
                        <i class="fas fa-shield-alt mr-2"></i> Bayar Sekarang
                    </button>
                    
                    <a href="{{ route('home') }}" class="block text-gray-500 hover:text-gray-700 font-medium transition-colors">
                        Bayar Nanti
                    </a>
                </div>
            </div>
            
            <div class="bg-blue-600 p-4 text-center">
                <p class="text-white text-sm opacity-90">
                    <i class="fas fa-lock mr-2"></i> Pembayaran Aman & Terenkripsi oleh Midtrans
                </p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-gray-400 text-sm">
                Butuh bantuan? <a href="#" class="text-blue-600 font-medium hover:underline">Hubungi Layanan Pelanggan</a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = "{{ route('home') }}?status=success";
            },
            onPending: function (result) {
                window.location.href = "{{ route('home') }}?status=pending";
            },
            onError: function (result) {
                window.location.href = "{{ route('home') }}?status=error";
            },
            onClose: function () {
                alert('Anda menutup popup pembayaran sebelum menyelesaikan transaksi.');
            }
        });
    });
</script>
@endpush
@endsection
