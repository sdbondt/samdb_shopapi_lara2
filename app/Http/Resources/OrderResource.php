<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'orderId' => $this->id,
            'amount' => $this->amount,
            'orderedAt' => $this->created_at,
            'products' => new OrderItemCollection($this->products)
        ];
    }
}
