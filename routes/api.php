<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Routes for user registration and login.
|
*/
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
|
| These routes are protected by the Sanctum middleware.
|
*/
Route::middleware('auth:sanctum')->group(function () {

    // Authentication again :)
    Route::post('logout', [AuthController::class, 'logout']);
    
//The apis documentaion in the README.md
    /*
    |--------------------------------------------------------------------------
    | Product API Routes
    |--------------------------------------------------------------------------
    */
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | Cart API Routes
    |--------------------------------------------------------------------------
    */
    Route::post('cart', [CartController::class, 'addToCart']);
    Route::delete('cart/{cartItemId}', [CartController::class, 'removeFromCart']);

    /*
    |--------------------------------------------------------------------------
    | Order API Routes
    |--------------------------------------------------------------------------
    */
    Route::get('orders', [OrderController::class, 'getUserOrders']);
    Route::post('checkout', [OrderController::class, 'checkout']);
    Route::put('/orders/{orderId}', [OrderController::class, 'updateOrder']);
    Route::delete('orders/{orderId}', [OrderController::class, 'deleteOrder']);
});
