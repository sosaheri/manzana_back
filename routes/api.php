<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Tymon\JWTAuth\Middleware\JWTVerify;
use Symfony\Component\HttpFoundation\Response;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('get_user', [AuthController::class, 'get_user']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy']);

    // Route::post('orders', [OrderController::class, 'create'])->name('orders.create');
    // Route::get('orders', [OrderController::class, 'all'])->name('orders.all');
});

Route::get('/status', function () {
        return response()->json(['status' => 'API active'], Response::HTTP_OK);
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Pagina no encontrada.',
    ], Response::HTTP_NOT_FOUND);
});
