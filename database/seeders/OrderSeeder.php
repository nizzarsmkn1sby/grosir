<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentMethods = ['COD', 'Transfer Bank', 'E-Wallet', 'Credit Card'];

        // Create 20 sample orders
        for ($i = 1; $i <= 20; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];

            // Calculate order total
            $orderTotal = 0;
            $itemsCount = rand(1, 5); // 1-5 items per order

            $order = Order::create([
                'user_id' => $user->id,
                'status' => $status,
                'payment_method' => $paymentMethod,
                'total_price' => 0, // Will update after creating items
                'shipping_id' => null,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);

            // Create order items
            for ($j = 0; $j < $itemsCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 5);
                $price = $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $orderTotal += ($price * $quantity);
            }

            // Update order total
            $order->update(['total_price' => $orderTotal]);
        }
    }
}
