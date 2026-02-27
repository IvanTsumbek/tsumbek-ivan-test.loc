<?php

namespace App\Http\Controllers\Api;

use App\Application\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        readonly OrderService $orderService
    )
    {
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $perPage = (int) $request->get('per_page', 10);

        $orders = $this->orderService->getOrders($userId, $perPage);

        return OrderResource::collection($orders);
    }

    public function show(Request $request, int $id)
    {
        $userId = $request->user()->id;

        $order = $this->orderService->getOrderById($id, $userId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return new OrderResource($order);
    }
}