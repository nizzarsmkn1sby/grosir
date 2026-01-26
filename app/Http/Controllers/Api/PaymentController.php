<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments
     */
    public function index(Request $request): JsonResponse
    {
        $query = Payment::with('order.user');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by order
        if ($request->has('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        $payments = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json($payments);
    }

    /**
     * Store a newly created payment
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        // Check if payment already exists
        if ($order->payment) {
            return response()->json([
                'message' => 'Payment already exists for this order'
            ], 422);
        }

        // Verify amount matches order total
        if ($validated['amount'] != $order->total_price) {
            return response()->json([
                'message' => 'Payment amount does not match order total'
            ], 422);
        }

        $payment = Payment::create([
            'order_id' => $validated['order_id'],
            'amount' => $validated['amount'],
            'method' => $validated['method'],
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Payment created successfully',
            'data' => $payment->load('order')
        ], 201);
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment): JsonResponse
    {
        return response()->json($payment->load('order.user'));
    }

    /**
     * Update the specified payment (e.g., confirm payment)
     */
    public function update(Request $request, Payment $payment): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $payment->update($validated);

        // If payment is confirmed, update order status
        if ($validated['status'] === 'paid') {
            $payment->update(['paid_at' => now()]);
            $payment->order->update(['status' => 'processing']);
        }

        // If payment failed, you might want to restore stock
        if ($validated['status'] === 'failed') {
            $payment->order->update(['status' => 'cancelled']);
        }

        return response()->json([
            'message' => 'Payment updated successfully',
            'data' => $payment->load('order')
        ]);
    }

    /**
     * Remove the specified payment
     */
    public function destroy(Payment $payment): JsonResponse
    {
        // Only allow deletion of pending payments
        if ($payment->status !== 'pending') {
            return response()->json([
                'message' => 'Cannot delete payment with status: ' . $payment->status
            ], 422);
        }

        $payment->delete();

        return response()->json([
            'message' => 'Payment deleted successfully'
        ]);
    }
}
