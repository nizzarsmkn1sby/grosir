@extends('layouts.public')

@section('title', 'Clear Cart - GrosirKu')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center">
        <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-exclamation-triangle text-3xl text-yellow-600"></i>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Keranjang Perlu Di-Reset</h2>
        <p class="text-gray-600 mb-8">
            Untuk memperbaiki masalah teknis, kami perlu me-reset keranjang belanja Anda. 
            Silakan tambahkan produk kembali ke keranjang.
        </p>

        <form action="{{ route('cart.force-clear') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all">
                <i class="fas fa-sync-alt mr-2"></i> Reset Keranjang & Mulai Belanja
            </button>
        </form>

        <a href="{{ route('home') }}" class="block mt-4 text-gray-500 hover:text-gray-700">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
