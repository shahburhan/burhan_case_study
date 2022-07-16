<?php

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
Route::namespace('App\Http\Controllers')->middleware('api')->group(function () {
    //Auth Endpoints
    Route::post('/auth/login', 'AuthController');

    //Product Endpoints
    Route::post('/products', 'ProductController@store')->middleware('auth:sanctum');
    Route::post('/product/{product}', 'ProductController@show')->middleware('auth:sanctum');
    Route::delete('/product/{product}', 'ProductController@destroy')->middleware('auth:sanctum');
    Route::get('/products', 'ProductController@index')->middleware('auth:sanctum');

    //Cart Endpoints
    Route::post('/cart/{product}', 'CartController@store')->middleware('auth_session:sanctum');
    Route::put('/cart/{cart}', 'CartController@update')->middleware('auth_session:sanctum');
    Route::delete('/cart/{cart}', 'CartController@destroy')->middleware('auth_session:sanctum');
    Route::get('/cart', 'CartController@index')->middleware('auth_session:sanctum');
});
