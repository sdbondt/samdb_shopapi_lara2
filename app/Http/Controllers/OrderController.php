<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store() {
        $totalAmount = 0;
        foreach(request()->user()->cart as $p) {
            global $totalAmount;
            $totalAmount += $p->getTotalAmount();
        }
        $order = Order::create([
            'amount' => $totalAmount,
            'user_id' => request()->user()->id
        ]);

        foreach(request()->user()->cart as $p) {
            OrderItem::create([
                'order_id' => $order->id,
                'user_id' => request()->user()->id,
                'product_id' => $p->product->id,
                'quantity' => $p->quantity,
                'price' => $p->product->price,
                'amount' => $p->getTotalAmount(),
            ]);
            $p->delete();
        }
        return ['order' => $order];
    }

    public function index() {
        return [
            'orders' => new OrderCollection(request()->user()->orders)
        ];
    }

    public function show(Order $order) {
        $this->authorize('view', [Order::class, $order]);
        return ['order' => new OrderResource($order)];
    }
}
