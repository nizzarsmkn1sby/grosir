<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request): JsonResponse
    {
        $query = Order::with(['user', 'shipping', 'orderItems.product', 'payment']);

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json($orders);
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping' => 'required|array',
            'shipping.address_line1' => 'required|string',
            'shipping.address_line2' => 'nullable|string',
            'shipping.city' => 'required|string',
            'shipping.province' => 'required|string',
            'shipping.postal_code' => 'required|string',
            'shipping.courier' => 'required|string',
            'shipping.cost' => 'required|numeric|min:0',
            'shipping.eta_estimation' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Create shipping record
            $shipping = Shipping::create($validated['shipping']);

            // Calculate total price
            $totalPrice = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Check stock availability
                if ($product->stock_qty < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                $itemPrice = $product->price * $item['quantity'];
                $totalPrice += $itemPrice;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];

                // Reduce stock
                $product->decrement('stock_qty', $item['quantity']);
            }

            // Add shipping cost
            $totalPrice += $shipping->cost;

            // Create order
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'status' => 'pending',
                'total_price' => $totalPrice,
                'shipping_id' => $shipping->id,
                'payment_method' => $validated['payment_method'] ?? null,
            ]);

            // Create order items
            foreach ($orderItems as $orderItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $orderItem['product_id'],
                    'quantity' => $orderItem['quantity'],
                    'price' => $orderItem['price'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Order created successfully',
                'data' => $order->load(['user', 'shipping', 'orderItems.product'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display the specified order
     */
    public function show(Order $order): JsonResponse
    {
        return response()->json($order->load(['user', 'shipping', 'orderItems.product', 'payment']));
    }

    /**
     * Update the specified order
     */
    public function update(Request $request, Order $order): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:pending,processing,shipped,delivered,cancelled',
            'payment_method' => 'nullable|string',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => $order->load(['user', 'shipping', 'orderItems.product', 'payment'])
        ]);
    }

    /**
     * Remove the specified order
     */
    public function destroy(Order $order): JsonResponse
    {
        // Only allow deletion of pending or cancelled orders
        if (!in_array($order->status, ['pending', 'cancelled'])) {
            return response()->json([
                'message' => 'Cannot delete order with status: ' . $order->status
            ], 422);
        }

        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully'
        ]);
    }
}
