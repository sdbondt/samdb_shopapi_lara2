<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'cart' => new CartItemCollection(request()->user()->cart),
            'favorites' => new FavoriteItemCollection(request()->user()->favorites),
            'orders' => new OrderCollection(request()->user()->orders),
        ];
    }
}
