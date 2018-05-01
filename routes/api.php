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

Route::group(['as' => 'api.', 'namespace' => 'Api'],
    function () {
        Route::get('/', 'HomeController@home');

        Route::middleware('auth:api')->group(function () {
            Route::resource('products', 'ProductController')->only('index', 'show', 'store', 'update', 'destroy');
        });
    });
