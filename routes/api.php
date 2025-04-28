<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post('/productStore', [ProductController::class, 'create']);
Route::get('/products', [ProductController::class, 'index']);
Route::delete('/product/delete/{product_id}', [ProductController::class, 'destroy']);
Route::get('/product/show/{product_id}', [ProductController::class, 'show']);

