<?php

namespace App\Application\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function query()
    {
        return Order::query();
    }

    public function getUserOrders(int $userId)
    {
        return $this->query()
            ->where('user_id', $userId)
            ->with('items.product')
            ->latest();
    }

    public function findUserOrder(int $orderId, int $userId)
    {
        return $this->query()
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->with('items.product')
            ->first();
    }
}