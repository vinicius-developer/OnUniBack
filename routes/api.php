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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->middleware('api')->namespace('App\Http\Controllers\Auth')->group(function() {
	Route::prefix('ong')->group(function() {
		Route::post('register', 'OngController@register');
		Route::get('activate/{id}', 'OngController@activate');
		Route::post('login', 'OngController@login');
	});
});


/*/api/auth/ong/register

