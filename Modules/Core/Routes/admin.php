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

Route::prefix('category/{code}')->group(function() {
	Route::get('/', 'UserController@index')->name('admin.users.index');
	Route::get('create', [
		'as' => 'admin.users.create',
		'uses' => 'UserController@create',
		'middleware' => 'can:admin.users.create',
	]);
});