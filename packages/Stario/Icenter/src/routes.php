<?php

use Illuminate\Http\Request;
Route::group([
	// 'middleware' => ['auth:api_manager'],
	'namespace' => 'Stario\\Icenter\\Controllers\\Api\\V1',
	'prefix' => 'api/v1',
], function () {
	Route::resource('admin', 'AdminController', ['except' => ['create', 'edit']]);
});

Route::group([
	'namespace' => 'Stario\\Icenter\\Controllers\\Api\\V1',
	'prefix' => 'api/v1',
	'middleware' => ['api'],
], function () {
	Route::post('auth', 'AdminAuthController@login');
	Route::put('auth', 'AdminAuthController@refreshToken');
});

Route::middleware('auth:api')->get('api/v1/user', function (Request $request) {
	return $request->user();
});
// 前端取得access_token后 放入localstorage 如果返回 401 用refresh_token 刷新一次
