<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/check-orders', function () {
    $orderCount = \App\Models\Order::whereNotNull('total_amount')->count();
    $totalSales = \App\Models\Order::whereNotNull('total_amount')->sum('total_amount');
    
    return response()->json([
        'orderCount' => $orderCount,
        'totalSales' => $totalSales
    ]);
});
