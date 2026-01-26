<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get raw cart
        $cartRaw = Session::get('cart', []);
        
        // Log raw cart structure for debugging
        \Log::info('=== CHECKOUT DEBUG ===');
        \Log::info('Raw Cart Keys: ' . json_encode(array_keys($cartRaw)));
        
        // Validate and repair cart structure
        $repairedCart = [];
        $hasInvalidItems = false;
        
        foreach ($cartRaw as $key => $item) {
            // Check if item is valid
            if (is_array($item) && isset($item['id'], $item['name'], $item['price'], $item['quantity'])) {
                $repairedCart[$key] = $item;
            } else {
                $hasInvalidItems = true;
                \Log::warning("Invalid cart item detected and removed: " . json_encode(['key' => $key, 'item' => $item]));
            }
        }
        
        // If we found invalid items, update the session
        if ($hasInvalidItems) {
            Session::put('cart', $repairedCart);
            \Log::info('Cart repaired. Invalid items removed.');
        }
        
        // Normalize cart array - convert associative array to indexed array
        $cart = array_values($repairedCart);
        
        \Log::info('Final Cart Count: ' . count($cart));
        
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja Anda kosong!');
        }

        $subtotal = 0;
        foreach ($cart as $index => $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping = 0; 
        $total = $subtotal + $shipping;

        // Check for pending orders with same products
        $productIds = array_column($cart, 'id');
        $pendingOrders = \App\Models\Order::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'processing'])
            ->whereHas('orderItems', function($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            })
            ->with(['orderItems.product'])
            ->get();

        return view('checkout.index', compact('cart', 'subtotal', 'shipping', 'total', 'pendingOrders'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|string',
        ]);

        $cart = array_values(Session::get('cart', []));
        
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja Anda kosong!');
        }

        // Validate cart structure before processing
        $validCart = [];
        foreach ($cart as $item) {
            if (is_array($item) && isset($item['id'], $item['name'], $item['price'], $item['quantity'])) {
                $validCart[] = $item;
            } else {
                \Log::warning('Invalid cart item skipped during checkout:', ['item' => $item]);
            }
        }

        if (empty($validCart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda berisi data yang tidak valid. Silakan hapus dan tambahkan produk kembali.');
        }

        // Use validated cart
        $cart = $validCart;

        // ========================================
        // VALIDATE STOCK AVAILABILITY
        // ========================================
        foreach ($cart as $item) {
            $product = \App\Models\Product::find($item['id']);
            
            if (!$product) {
                return back()->with('error', "Produk {$item['name']} tidak ditemukan!")->withInput();
            }
            
            if (isset($product->is_available) && !$product->is_available) {
                return back()->with('error', "Produk {$item['name']} sedang tidak tersedia!")->withInput();
            }
            
            if (isset($product->stock) && $product->stock < $item['quantity']) {
                return back()->with('error', "Stock {$item['name']} tidak mencukupi! Tersedia: {$product->stock}, Diminta: {$item['quantity']}")->withInput();
            }
        }

        // ========================================
        // VALIDATE DUPLICATE CHECKOUT
        // Check if user already has pending/processing orders with same products
        // ========================================
        $productIds = array_column($cart, 'id');
        
        $existingOrders = \App\Models\Order::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'processing'])
            ->whereHas('orderItems', function($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            })
            ->with(['orderItems' => function($query) use ($productIds) {
                $query->whereIn('product_id', $productIds);
            }])
            ->get();

        if ($existingOrders->isNotEmpty()) {
            $duplicateProducts = [];
            foreach ($existingOrders as $order) {
                foreach ($order->orderItems as $item) {
                    if (in_array($item->product_id, $productIds)) {
                        $duplicateProducts[] = [
                            'name' => $item->product->name,
                            'order_id' => $order->id,
                            'status' => $order->status,
                        ];
                    }
                }
            }

            if (!empty($duplicateProducts)) {
                $productNames = array_unique(array_column($duplicateProducts, 'name'));
                $orderInfo = $duplicateProducts[0];
                
                return back()->with('error', 
                    "Anda sudah memiliki pesanan yang sedang diproses untuk produk: " . 
                    implode(', ', $productNames) . 
                    ". Order #" . str_pad($orderInfo['order_id'], 5, '0', STR_PAD_LEFT) . 
                    " (Status: {$orderInfo['status']}). Silakan selesaikan pembayaran atau tunggu pesanan sebelumnya selesai."
                )->withInput();
            }
        }

        try {
            DB::beginTransaction();

            // Calculate total and prepare item details
            $total_price = 0;
            $item_details = [];
            foreach ($cart as $item) {
                $total_price += ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
                $item_details[] = [
                    'id' => (string) $item['id'],
                    'price' => (int) ($item['price'] ?? 0),
                    'quantity' => (int) ($item['quantity'] ?? 0),
                    'name' => $item['name'] ?? 'Produk'
                ];
            }

            // Create Shipping first to get ID
            $shipping = \App\Models\Shipping::create([
                'address_line1' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'courier' => 'JNE', // Default or from request
                'cost' => 0, // Free for now
            ]);

            // Create Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total_price' => $total_price,
                'shipping_id' => $shipping->id,
                'payment_method' => $request->payment_method,
            ]);

            // Create Order Items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Create Payment placeholder
            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'amount' => $total_price,
                'status' => 'pending',
            ]);

            // Midtrans Configuration
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

            // Fix cURL error 60: SSL certificate problem in local environment
            // IMPORTANT: Initialize curlOptions properly to prevent "Undefined array key" errors
            if (config('app.env') === 'local') {
                \Midtrans\Config::$curlOptions = [
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTPHEADER => [], // Initialize to prevent undefined array key error
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => (int) $total_price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->phone ?? '',
                ],
                'item_details' => $item_details,
            ];

            // Log params for debugging
            \Log::info('Midtrans Params:', $params);
            \Log::info('Item Details:', ['items' => $item_details]);

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            DB::commit();

            // Clear cart
            Session::forget('cart');

            return view('checkout.payment', compact('order', 'snapToken'));

        } catch (\Exception $e) {
            \Log::error('Checkout Process Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
