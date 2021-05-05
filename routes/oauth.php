<?php

use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;

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

Passport::routes();

Route::middleware('auth:api')->delete('oauth/revoke', function (Request $request) {
	Auth::guard('web')->logoutOtherDevices(request()->input('password'));

	$tokens 	= Token::where('user_id', Auth::id())->where('revoked', 0)->get();
	foreach ($tokens as $token) {
		$token->revoke();
	}
    return response()->json([
        'status' => true,
        'data'   => [],
        'message'=> 'Berhasil logout dari semua device',
    ]);
});