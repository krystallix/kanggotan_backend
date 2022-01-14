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
Route::group(['namespace' => '\App\Http\Controllers\Api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'AuthController@login');
        Route::post('/register', 'AuthController@register');
    });
    Route::group(['prefix' => 'nyadran'], function () {
        Route::get('/statistik', 'NyadranController@stats');
        Route::get('/all', 'NyadranController@index');
        Route::get('/show/{id}', 'NyadranController@show');
        Route::post('/search', 'NyadranController@search');
        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::group(['middleware' => ['role:Admin|Super Admin|Officer']], function () {
                Route::post('/store', 'NyadranController@store');
            });
        });
    });
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return [
        "user" => $request->user(),
        "roles" => $request->user()->roles
    ];
});
