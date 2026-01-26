<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        // Get raw cart with product IDs as keys
        $cartRaw = Session::get('cart', []);
        
        // Normalize to indexed array for consistent view access
        $cart = array_values($cartRaw);
        
        $total = 0;

        foreach ($cart as $item) {
            if (is_array($item) && isset($item['price'], $item['quantity'])) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        // Fetch user's transaction history
        $orders = \App\Models\Order::where('user_id', auth()->id())
            ->with(['orderItems.product', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        return view('cart.index', compact('cart', 'total', 'orders'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, Product $product)
    {
        $cart = Session::get('cart', []);

        $quantity = $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image_url,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity', 1);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diupdate!');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        Session::forget('cart');

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan!');
    }

    /**
     * Force clear cart and redirect to products
     */
    public function forceClear()
    {
        Session::forget('cart');
        Session::flush(); // Clear all session data to ensure clean state

        return redirect()->route('products.index')->with('success', 'Keranjang telah di-reset. Silakan tambahkan produk kembali.');
    }

    /**
     * Display order details/invoice
     */
    public function orderDetails(\App\Models\Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Load all relationships
        $order->load(['orderItems.product', 'payment', 'shipping', 'user']);

        return view('cart.order-details', compact('order'));
    }

    /**
     * Initiate payment for unpaid order
     */
    public function payOrder(\App\Models\Order $order)
    {
        // Ensure user can only pay their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        // Check if order is already paid
        if ($order->payment && $order->payment->status == 'completed') {
            return redirect()->route('order.details', $order->id)
                ->with('info', 'This order has already been paid.');
        }

        // Load necessary relationships
        $order->load(['user', 'orderItems.product']);

        // Generate Midtrans Snap Token
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

        // Fix cURL error 60 for local development
        if (config('app.env') === 'local') {
            \Midtrans\Config::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ];
        }

        // Create unique order_id for Midtrans (append timestamp to avoid duplicate)
        $uniqueOrderId = $order->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $uniqueOrderId,
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
            'item_details' => $order->orderItems->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'price' => (int) $item->price,
                    'quantity' => $item->quantity,
                    'name' => $item->product->name,
                ];
            })->toArray(),
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return view('checkout.payment', compact('order', 'snapToken'));
        } catch (\Exception $e) {
            return redirect()->route('order.details', $order->id)
                ->with('error', 'Failed to initiate payment: ' . $e->getMessage());
        }
    }
}
