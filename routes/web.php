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

Route::get('/', function () {
	abort(503);
});

Route::get('/homepage', function () {
    return view('web.index');
});

Route::get('dashboard', 'WebsiteController@dashboard')->name('dashboard')->middleware('subscription');

Route::get('member', function () {
    return view('web.index');
})->name('member');

//HANYA KEBUTUHAN TESTING
Route::get('registering', 'WebsiteController@registering')->name('registering')->middleware('guest');
Route::get('signin', 'WebsiteController@signin')->name('signin')->middleware('guest');
Route::post('registered', 'WebsiteController@registered')->name('registered');

Route::get('verified/{uuid}/{token}', 'WebsiteController@verified')->name('verified');

Route::get('inviting/{website}/{token}', 'WebsiteController@inviting')->name('inviting');
Route::post('invited/{website}/{token}', 'WebsiteController@invited')->name('invited');

Route::get('subscribing', 'WebsiteController@subscribing')->middleware('auth:web')->name('subscribing');
Route::post('subscribed', 'WebsiteController@subscribed')->middleware('auth:web')->name('subscribed');

Route::get('/api/sync/lazada', function () {
	$url 	= str_replace(request()->getHost(), request()->subdomain, route('tswirl.apisync.lazada', ['code' => request()->code]));
	return redirect($url);
});
