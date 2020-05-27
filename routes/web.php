<?php

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

Route::get('/install', function() {
	\Artisan::call('migrate',
		array(
			'--path' => 'database/migrations',
			'--force' => true));
	return "done";

});

Route::get('/clear', function() {

	\Artisan::call('cache:clear');
	\Artisan::call('config:clear');
	\Artisan::call('config:cache');
	\Artisan::call('view:clear');

	return "Cleared!";

});

Route::get('/', function () {
	return view('welcome');
});

Route::get('login', [
	'as' => 'admin.login.index',
	'uses' => 'AppController@login',
]);