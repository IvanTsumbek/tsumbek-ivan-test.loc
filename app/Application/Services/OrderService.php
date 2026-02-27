<?php

namespace App\Application\Services;

use App\Application\Repositories\OrderRepository;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        readonly OrderRepository $repo
    )
    {
    }

    public function getOrders(int $userId, int $perPage = 10)
    {
        return $this->repo
            ->getUserOrders($userId)
            ->paginate($perPage);
    }

    public function getOrderById(int $orderId, int $userId)
    {
        return $this->repo->findUserOrder($orderId, $userId);
    }

    // public function createOrder(int $userId, array $items)
    // {
    //     return DB::transaction(function () use ($userId, $items) {

    //         $total = 0;
    //         $orderItems = [];

    //         foreach ($items as $item) {
    //             $product = Product::findOrFail($item['product_id']);

    //             $quantity = $item['quantity'] ?? 1;
    //             $price = $product->price;

    //             $total += $price * $quantity;

    //             $orderItems[] = [
    //                 'product_id' => $product->id,
    //                 'quantity' => $quantity,
    //                 'price' => $price,
    //             ];
    //         }

    //         $order = $this->repo->create([
    //             'user_id' => $userId,
    //             'total_amount' => $total,
    //         ]);

    //         foreach ($orderItems as $item) {
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 ...$item
    //             ]);
    //         }

    //         return $order->load('items.product');
    //     });
    // }
}