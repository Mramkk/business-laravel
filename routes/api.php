<?php

use App\Http\Controllers\Api\Business\ApiBusinessController;
use App\Http\Controllers\Api\User\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ApiUserController::class)->group(function () {
        Route::get('/user/data', 'data');
        Route::post('/user/logout', 'logout');
    });

    Route::controller(ApiBusinessController::class)->group(function () {
        Route::get('/business/data', 'data');
        Route::post('/business/save', 'save');
    });
});
Route::controller(ApiUserController::class)->group(function () {
    Route::post('/user/register', 'register');
    Route::post('/user/login', 'login');
});
