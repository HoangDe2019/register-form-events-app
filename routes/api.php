<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;
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

//public
Route::get('/get-info-join-events', [\App\Http\Controllers\API\UserController::class, 'index']);
Route::post('/register-form-event', [\App\Http\Controllers\API\UserController::class, 'registerEvent']);
Route::get('/get-info-join-event/{id}', [\App\Http\Controllers\API\UserController::class, 'getIdInfoUser']);
Route::get('/get-event-types', [UserController::class, 'getALlEventTypes']);


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

    //login and validate
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/change-pass', [AuthController::class, 'changePassWord']);
});

//auth
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('user','App\Http\Controllers\UserController@getAuthenticatedUser');
    Route::delete('/remove-event-user/{id}', [UserController::class, 'destroyEvent']);
    Route::delete('/remove-type-event/{id}', [UserController::class, 'deleteEventType']);
    Route::post('/generate-event-type', [UserController::class, 'storeEventType']);
    Route::get('/generate-event-type', [UserController::class, 'storeEventType']);
});

