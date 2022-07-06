<?php

namespace App\Http\Controllers;

use App\Models\FavoriteItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteItemController extends Controller
{
    public function store(Product $product) {
        $item = FavoriteItem::where([
            'user_id' => request()->user()->id,
            'product_id' => $product->id
        ])->first();

        if($item ?? false) {
            $item->delete();
            return ['msg' => 'Product removed from favorites list.'];
        } else {
            request()->user()->favorites()->create([
                'product_id' => $product->id
            ]);
            return ['msg' => 'Product added to favorites list.'];
        }
    }
}
