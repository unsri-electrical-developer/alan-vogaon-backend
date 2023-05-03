<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    Route::get('/', [TestController::class, 'test']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
