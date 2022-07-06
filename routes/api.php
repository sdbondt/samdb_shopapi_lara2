<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\FavoriteItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Resources\FavoriteItemCollection;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/profile', [AuthController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product:slug}', [ProductController::class, 'show']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::delete('/products/{product:slug}', [ProductController::class, 'destroy']);
    Route::patch('/products/{product:slug}', [ProductController::class, 'update']);

    Route::post('/products/{product:slug}/favorite', [FavoriteItemController::class, 'store']);

    Route::post('/products/{product:slug}/cart', [CartItemController::class, 'store']);
    Route::get('/cart/{cartItem}', [CartItemController::class, 'show']);
    Route::get('/cart', [CartItemController::class, 'index']);
    Route::patch('/cart/{cartItem}', [CartItemController::class, 'update']);
    Route::delete('/cart/{cartItem}', [CartItemController::class, 'delete']);
    Route::delete('/cart', [CartItemController::class, 'deleteAll']);

    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
});

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
