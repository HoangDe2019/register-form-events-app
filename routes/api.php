<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-info-join-events', [\App\Http\Controllers\API\UserController::class, 'index']);
Route::post('/register-form-event', [\App\Http\Controllers\API\UserController::class, 'registerEvent']);
Route::get('/get-info-join-event/{id}', [\App\Http\Controllers\API\UserController::class, 'getIdInfoUser']);
