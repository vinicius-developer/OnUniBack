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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('ong')->group(function () {
	Route::namespace('App\Http\Controllers\Users')
		->group(function () {
			Route::prefix('auth')
				->group(function () {
					Route::post('register', 'OngController@register');
					Route::post('login', 'OngController@login');
					Route::put('activate/{id}', 'OngController@activate');
				});

			Route::prefix('auth')
				->middleware('check-token')
				->group(function () {
					Route::get('logout', 'OngController@logout');
					Route::get('me', 'OngController@me');
				});
		});


	Route::middleware('check-token')
		->group(function () {
			Route::prefix('change')
				->namespace('App\Http\Controllers\Users')
				->group(function () {
					Route::post('image', 'OngController@changeImage');
					Route::put('info', 'OngController@changeInfo');
				});

			Route::prefix('wishlist')
				->namespace('App\Http\Controllers\Objects')
				->group(function () {
					Route::post('register', 'ListaPedidoOngController@register');
					Route::delete('delete/{id}', 'ListaPedidoOngController@delete');
					Route::get('index', 'ListaPedidoOngController@indexUsr');
				});
		});
});

Route::prefix('doador')->group(function () {
	Route::prefix('auth')
		->namespace('App\Http\Controllers\Users')
		->group(function () {
			Route::post('register', 'DoadorController@register');
			Route::post('login', 'DoadorController@login');
			Route::put('activate/{id}', 'DoadorController@activate');
		});

	Route::prefix('image')
		->namespace('App\Http\Controllers\Users')
		->middleware('check-token')
		->group(function () {
			Route::post('change', 'DoadorController@changeImage');
		});

	Route::prefix('auth')
		->namespace('App\Http\Controllers\Users')
		->middleware('check-token')
		->group(function () {
			Route::get('logout', 'DoadorController@logout');
			Route::get('me', 'DoadorController@me');
		});
});

Route::prefix('info')->middleware('check-token')->group(function () {
	Route::prefix('users')
		->namespace('App\Http\Controllers\Users')
		->group(function () {
			Route::prefix('ong')->group(function () {
				Route::get('list', 'OngController@index');
				Route::get('find/{id}', 'OngController@find');
			});
		});

	Route::prefix('objects')
		->namespace('App\Http\Controllers\Objects')
		->group(function () {
			Route::get('telephone/list/{id}', 'TelefoneController@indexDoa');
			Route::get('telephone/me/list', 'TelefoneController@indexOng');
			Route::get('address/list/{id}', 'EnderecoController@indexDoa');
			Route::get('address/me/list', 'EnderecoController@indexOng');
			Route::get('list/{id}', 'ListaPedidoOngController@indexDoa');
		});
});

Route::prefix('actions')->middleware('check-token')->group(function () {

	Route::prefix('report')
		->namespace('App\Http\Controllers\Actions')
		->group(function () {
			Route::post('register', 'ReportController@register');
			Route::get('findong/{id}', 'ReportController@findong');
			Route::get('finddoa/{id}', 'ReportController@finddoa');
		});

	Route::prefix('follow')
		->namespace('App\Http\Controllers\Actions')
		->group(function () {
			Route::get('switch/{id}', 'OngFavoritaController@switch');
			Route::get('index', 'OngFavoritaController@index');
			Route::get('find/{id}', 'OngFavoritaController@find');
		});
});
