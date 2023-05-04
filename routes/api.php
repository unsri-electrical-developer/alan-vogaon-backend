<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GamesController;
use App\Http\Controllers\Api\GamesItemController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PaymentGatewayController;
use App\Http\Controllers\Api\SlidersController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    Route::get('/', [TestController::class, 'test']);
    Route::post('/login', [AuthController::class, 'login']);

});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/coba', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Users
    Route::apiResource('/users', UserController::class);

    // Category
    Route::apiResource('/category', CategoryController::class);

    // Games
    Route::apiResource('/games', GamesController::class);

    // Sliders
    Route::apiResource('/sliders', SlidersController::class);
    
    // Games Item / Products
    Route::apiResource('/games_item/{game_code}/products', GamesItemController::class);

    // Payment Gateway
    Route::apiResource('/payment_gateway', PaymentGatewayController::class);
});