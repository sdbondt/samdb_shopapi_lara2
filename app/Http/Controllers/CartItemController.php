<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItemCollection;
use App\Http\Resources\CartItemResource;
use App\Models\CartItem;
use App\Models\Product;

class CartItemController extends Controller
{
    public function store(Product $product) {
        $cartItemExists = CartItem::where([
            'product_id' => $product->id,
            'user_id' => request()->user()->id
        ])->exists();

        if($cartItemExists) {
            return [
                'msg' => 'Product already in cart.'
            ];
        } else {
            request()->validate([
                'quantity' => ['sometimes', 'numeric', 'min:1', 'max:100']
            ]);
            $cartItemQuantity = request('quantity') ? request('quantity') : 1;
            request()->user()->cart()->create([
                'product_id' => $product->id,
                'quantity' => $cartItemQuantity
            ]);
            return ['msg' => 'Product got added to cart.'];
        }
    }

    public function update(CartItem $cartItem) {
        $this->authorize('update', [CartItem::class, $cartItem]);
        request()->validate([
            'quantity' => ['sometimes', 'numeric', 'min:-100', 'max:100']
        ]);
        $updateQuantity = $cartItem->quantity + request('quantity') > 100 ? 100: ($cartItem->quantity + request('quantity') < 1 ? 1: $cartItem->quantity + request('quantity'));
        $cartItem->update([
            'quantity' => $updateQuantity
        ]);
        return [
            'msg' => 'Product quantity in cart got updated.',
            'cartItem' => new CartItemResource($cartItem)
        ];
    }

    public function delete(CartItem $cartItem) {
        $this->authorize('delete', [CartItem::class, $cartItem]);
        $cartItem->delete();
        return ['msg' => 'Product got deleted from cart.'];
    }

    public function deleteAll() {
        request()->user()->cart()->delete();
        return ['msg' => 'No more items in cart.'];
    }

    public function show(CartItem $cartItem) {
        $this->authorize('view', [CartItem::class, $cartItem]);
        return [
            'cartItem' => new CartItemResource($cartItem)
        ];
    }

    public function index() {
        return ['cart' => new CartItemCollection(request()->user()->cart)];
    }
}
