<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);

// Protected routes (need authentication)
Route::middleware('auth:sanctum')->group(function () {

    // Book management (only sellers)
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // Cart
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::get('/cart', [CartController::class, 'view']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);

    // Orders
    Route::post('/orders/place', [OrderController::class, 'place']);
    Route::get('/orders', [OrderController::class, 'view']);

    // Admin-only routes
    Route::get('/admin/users', [AdminController::class, 'users']);
    Route::get('/admin/orders', [AdminController::class, 'orders']);
});
