<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        // Fix cURL error 60 for local development
        if (config('app.env') === 'local') {
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ];
        }
    }

    public function notification(Request $request)
    {
        try {
            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $fraudStatus = $notification->fraud_status;

            // ========================================
            // SECURITY: Verify Midtrans Signature
            // ========================================
            $statusCode = $notification->status_code;
            $grossAmount = $notification->gross_amount;
            $serverKey = config('services.midtrans.server_key');
            
            // Create signature hash
            $mySignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            
            // Verify signature matches
            if ($mySignature !== $notification->signature_key) {
                \Log::error('⚠️ SECURITY ALERT: Invalid Midtrans signature detected!', [
                    'order_id' => $orderId,
                    'expected_signature' => $mySignature,
                    'received_signature' => $notification->signature_key,
                    'ip_address' => $request->ip(),
                    'timestamp' => now(),
                ]);
                
                return response()->json([
                    'message' => 'Invalid signature',
                    'status' => 'forbidden'
                ], 403);
            }
            
            \Log::info('✅ Midtrans signature verified successfully', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
            ]);

            // Extract actual order ID (remove timestamp suffix if exists)
            // Format: "3-1234567890" -> "3"
            $actualOrderId = explode('-', $orderId)[0];
            
            $order = Order::find($actualOrderId);

            if (!$order) {
                \Log::warning('Order not found for Midtrans notification', [
                    'order_id' => $orderId,
                    'actual_order_id' => $actualOrderId,
                ]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $order->update(['status' => 'pending']);
                    } else {
                        $this->markAsPaid($order, $notification);
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->markAsPaid($order, $notification);
            } elseif ($transactionStatus == 'pending') {
                $order->update(['status' => 'pending']);
            } elseif ($transactionStatus == 'deny') {
                $order->update(['status' => 'cancelled']);
            } elseif ($transactionStatus == 'expire') {
                $order->update(['status' => 'cancelled']);
            } elseif ($transactionStatus == 'cancel') {
                $order->update(['status' => 'cancelled']);
            }

            return response()->json(['message' => 'Notification processed']);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    private function markAsPaid($order, $notification)
    {
        \DB::transaction(function () use ($order, $notification) {
            // Update order status
            $order->update(['status' => 'processing']);
            
            // Reduce stock for each product
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                
                // Reduce stock
                $product->decrement('stock', $item->quantity);
                
                // Mark as unavailable if stock is 0 or less
                if ($product->stock <= 0) {
                    $product->update(['is_available' => false]);
                }
                
                \Log::info('📦 Stock reduced', [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity_sold' => $item->quantity,
                    'remaining_stock' => $product->stock,
                ]);
            }
            
            // Update payment with transaction details
            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment) {
                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'transaction_id' => $notification->transaction_id ?? null,
                    'payment_type' => $notification->payment_type ?? null,
                    'raw_response' => json_encode($notification),
                ]);
                
                \Log::info('💰 Payment completed successfully', [
                    'order_id' => $order->id,
                    'transaction_id' => $notification->transaction_id ?? 'N/A',
                    'payment_type' => $notification->payment_type ?? 'N/A',
                    'amount' => $order->total_price,
                ]);
            }
        });
    }
}
