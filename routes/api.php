<?php

use Illuminate\Http\UploadedFile;
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
Route::namespace('App\Http\Controllers')->group(function () {
    //Auth Endpoints
    Route::post('/auth/login', 'AuthController');

    //Product Endpoints
    Route::post('/products', 'ProductController@store')->middleware('auth:sanctum');
    Route::post('/product/{product}', 'ProductController@show')->middleware('auth:sanctum');
    Route::delete('/product/{product}', 'ProductController@destroy')->middleware('auth:sanctum');
    Route::get('/products', 'ProductController@index')->middleware('auth:sanctum');
});
