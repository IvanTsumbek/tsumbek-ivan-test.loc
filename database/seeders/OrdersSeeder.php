<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@example.com')->first();
        $products = Product::query()->take(2)->get();

        if (!$user || $products->count() < 2) {
            return;
        }

        $existingOrderIds = Order::where('user_id', $user->id)->pluck('id');
        if ($existingOrderIds->isNotEmpty()) {
            OrderItem::whereIn('order_id', $existingOrderIds)->delete();
            Order::whereIn('id', $existingOrderIds)->delete();
        }

        $firstProduct = $products[0];
        $secondProduct = $products[1];
        $totalAmount = ($firstProduct->price * 1) + ($secondProduct->price * 2);

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $firstProduct->id,
            'quantity' => 1,
            'price' => $firstProduct->price,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $secondProduct->id,
            'quantity' => 2,
            'price' => $secondProduct->price,
        ]);
    }
}
