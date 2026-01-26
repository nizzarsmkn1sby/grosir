<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\PaymentController;

// Socialite Routes
Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('social.callback');

// Midtrans Notification
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])->name('midtrans.notification');

// DEVELOPMENT ONLY - Manual trigger payment completion
// Use this when webhook cannot reach localhost
Route::get('/dev/complete-payment/{orderId}', function($orderId) {
    if (config('app.env') !== 'local') {
        abort(404);
    }
    
    $order = \App\Models\Order::find($orderId);
    
    if (!$order) {
        return redirect()->back()->with('error', 'Order not found!');
    }
    
    if ($order->status !== 'pending') {
        return redirect()->back()->with('info', "Order #{$orderId} is already {$order->status}");
    }
    
    // Simulate Midtrans notification
    $fakeNotification = (object) [
        'order_id' => $order->id,
        'transaction_id' => 'DEV-TEST-' . time(),
        'transaction_status' => 'settlement',
        'payment_type' => 'credit_card',
        'gross_amount' => $order->total_price,
        'signature_key' => 'dev-bypass', // For dev only
    ];
    
    // Call markAsPaid directly using reflection
    $controller = new \App\Http\Controllers\Web\PaymentController();
    $reflection = new \ReflectionClass($controller);
    $method = $reflection->getMethod('markAsPaid');
    $method->setAccessible(true);
    
    try {
        $method->invoke($controller, $order, $fakeNotification);
        
        return redirect('/cart')->with('success', "✅ Payment completed for Order #{$orderId}! Stock has been reduced.");
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
})->name('dev.complete-payment');

/*
|--------------------------------------------------------------------------
| Public Routes (Guest dapat akses)
|--------------------------------------------------------------------------
*/

// Homepage - Tampilkan produk featured
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products - Guest bisa lihat semua produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Categories - Guest bisa lihat per kategori
Route::get('/category/{category}', [ProductController::class, 'category'])->name('products.category');

/*
|--------------------------------------------------------------------------
| Protected Routes (Harus login)
|--------------------------------------------------------------------------
*/

// Cart - Harus login untuk akses cart
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/force-clear', [CartController::class, 'forceClear'])->name('cart.force-clear');
    
    // Order Details/Invoice
    Route::get('/order/{order}', [CartController::class, 'orderDetails'])->name('order.details');
    
    // Pay for existing unpaid order
    Route::get('/order/{order}/pay', [CartController::class, 'payOrder'])->name('order.pay');
});

// Checkout - Harus login untuk checkout
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    
    // Handle GET requests to checkout/process (redirect to checkout page)
    Route::get('/checkout/process', function() {
        return redirect()->route('checkout.index')->with('info', 'Please complete the checkout form to proceed with payment.');
    });
    
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Dashboard - Hanya untuk Admin
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

// Profile - Harus login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
