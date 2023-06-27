<?php

use App\Http\Controllers\Api\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
  

Route::get('/', [HomeController::class, 'noRoute']);
Route::get('/image/{img}', [TestController::class, 'getImage']);
Route::get('/image/{folder}/{img}', [TestController::class, 'getImage']);
