<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth:web')->group(function(){
	Route::get('/', 		'DashboardController@index')->name('owner');

	/*website*/
	Route::get('bayar', 		'SubscriptionController@bayar')->name('owner.subscription.pay');
	Route::get('lunas', 		'SubscriptionController@lunas')->name('owner.subscription.paid');

	Route::prefix('tagihan/{id}')->group(function(){
	  Route::get('/',			['uses' => 'SubscriptionController@get',	'as' => 'owner.subscription.get']);
	  Route::post('/',			['uses' => 'SubscriptionController@post',	'as' => 'owner.subscription.post']);
	  Route::delete('/',		['uses' => 'SubscriptionController@delete',	'as' => 'owner.subscription.delete']);
	});

	Route::prefix('akses/{id}')->group(function(){
	  Route::get('/',			['uses' => 'AccessController@get',			'as' => 'owner.access.get']);
	  Route::get('{email}', 	['uses' => 'AccessController@show',			'as' => 'owner.access.show']);
	  Route::post('/',			['uses' => 'AccessController@post',			'as' => 'owner.access.post']);
	  Route::post('{email}',		['uses' => 'AccessController@delete',		'as' => 'owner.access.delete']);
	});

	Route::prefix('endpoint/{id}')->group(function(){
	  Route::get('/',			['uses' => 'EndpointController@get',		'as' => 'owner.endpoint.get']);
	  Route::post('/',			['uses' => 'EndpointController@post',		'as' => 'owner.endpoint.post']);
	  Route::get('{name}',		['uses' => 'EndpointController@delete',		'as' => 'owner.endpoint.delete']);
	});
});
