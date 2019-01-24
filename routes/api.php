<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('payments/create', 'PaymentController@createOrder');
Route::post('payments/query', 'PaymentController@queryOrder');
Route::post('listen', 'PaymentController@listen');
Route::get('listen', 'PaymentController@listenGet');
