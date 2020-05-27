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
Route::get('login', 'AuthController@getLogin')->name('admin.login');
Route::post('login', 'AuthController@login')->name('admin.login');
Route::get('logout', 'AuthController@logout');
Route::prefix('users')->group(function() {
	Route::get('/', [
		'as' => 'admin.users.index',
		'uses' => 'UserController@index',
		'middleware' => 'can:admin.users.index',
	]);
	Route::get('create', [
		'as' => 'admin.users.create',
		'uses' => 'UserController@create',
		'middleware' => 'can:admin.users.create',
	]);

	Route::post('user', [
		'as' => 'admin.users.store',
		'uses' => 'UserController@store',
		'middleware' => 'can:admin.users.create',
	]);

	Route::get('edit/{id}', [
		'as' => 'admin.users.edit',
		'uses' => 'UserController@edit',
		'middleware' => 'can:admin.users.edit',
	]);

	Route::post('{id}', [
		'as' => 'admin.users.update',
		'uses' => 'UserController@update',
		'middleware' => 'can:admin.users.edit',
	]);

	Route::post('destroys', [
		'as' => 'admin.users.destroy',
		'uses' => 'UserController@destroy',
		'middleware' => 'can:admin.users.destroy',
	]);

	Route::get('{id}/show', [
		'as' => 'admin.users.show',
		'uses' => 'UserController@show',
		'middleware' => 'can:admin.users.show',
	]);

});

Route::prefix('role')->group(function() {
	Route::get('/', [
		'as' => 'admin.roles.index',
		'uses' => 'RoleController@index',
		'middleware' => 'can:admin.roles.index',
	]);
	Route::post('/', [
		'as' => 'admin.roles.index',
		'uses' => 'RoleController@table',
		'middleware' => 'can:admin.roles.index',
	]);
	Route::get('create', [
		'as' => 'admin.roles.create',
		'uses' => 'RoleController@create',
		'middleware' => 'can:admin.roles.create',
	]);

	Route::post('store', [
		'as' => 'admin.roles.store',
		'uses' => 'RoleController@store',
		'middleware' => 'can:admin.roles.create',
	]);

	Route::get('edit/{id}', [
		'as' => 'admin.roles.edit',
		'uses' => 'RoleController@edit',
		'middleware' => 'can:admin.roles.edit',
	]);

	Route::post('status', [
		'as' => 'admin.roles.status',
		'uses' => 'RoleController@status',
		'middleware' => 'can:admin.roles.create',
	]);

	Route::post('update/{id}', [
		'as' => 'admin.roles.update',
		'uses' => 'RoleController@update',
		'middleware' => 'can:admin.roles.edit',
	]);

	Route::post('destroy', [
		'as' => 'admin.roles.destroy',
		'uses' => 'RoleController@destroy',
		'middleware' => 'can:admin.roles.destroy',
	]);

	Route::get('{id}/show', [
		'as' => 'admin.roles.show',
		'uses' => 'RoleController@show',
		'middleware' => 'can:admin.roles.show',
	]);
});

Route::prefix('departments')->group(function() {
	Route::get('/', [
		'as' => 'admin.departments.index',
		'uses' => 'DepartmentController@index',
		'middleware' => 'can:admin.departments.index',
	]);
	Route::post('/', [
		'as' => 'admin.departments.index',
		'uses' => 'DepartmentController@table',
		'middleware' => 'can:admin.departments.index',
	]);
	Route::get('create', [
		'as' => 'admin.departments.create',
		'uses' => 'DepartmentController@create',
		'middleware' => 'can:admin.departments.create',
	]);

	Route::post('store', [
		'as' => 'admin.departments.store',
		'uses' => 'DepartmentController@store',
		'middleware' => 'can:admin.departments.create',
	]);

	Route::get('edit/{id}', [
		'as' => 'admin.departments.edit',
		'uses' => 'DepartmentController@edit',
		'middleware' => 'can:admin.departments.edit',
	]);

	Route::post('status', [
		'as' => 'admin.departments.status',
		'uses' => 'DepartmentController@status',
		'middleware' => 'can:admin.departments.create',
	]);

	Route::post('update/{id}', [
		'as' => 'admin.departments.update',
		'uses' => 'DepartmentController@update',
		'middleware' => 'can:admin.departments.edit',
	]);

	Route::post('destroy', [
		'as' => 'admin.departments.destroy',
		'uses' => 'DepartmentController@destroy',
		'middleware' => 'can:admin.departments.destroy',
	]);

	Route::get('{id}/show', [
		'as' => 'admin.departments.show',
		'uses' => 'DepartmentController@show',
		'middleware' => 'can:admin.departments.show',
	]);
});

Route::prefix('positions')->group(function() {
	Route::get('/', [
		'as' => 'admin.positions.index',
		'uses' => 'PositionController@index',
		'middleware' => 'can:admin.positions.index',
	]);
	Route::post('/', [
		'as' => 'admin.positions.index',
		'uses' => 'PositionController@table',
		'middleware' => 'can:admin.positions.index',
	]);
	Route::get('create', [
		'as' => 'admin.positions.create',
		'uses' => 'PositionController@create',
		'middleware' => 'can:admin.positions.create',
	]);

	Route::post('store', [
		'as' => 'admin.positions.store',
		'uses' => 'PositionController@store',
		'middleware' => 'can:admin.positions.create',
	]);

	Route::get('edit/{id}', [
		'as' => 'admin.positions.edit',
		'uses' => 'PositionController@edit',
		'middleware' => 'can:admin.positions.edit',
	]);

	Route::post('status', [
		'as' => 'admin.positions.status',
		'uses' => 'PositionController@status',
		'middleware' => 'can:admin.positions.create',
	]);

	Route::post('update/{id}', [
		'as' => 'admin.positions.update',
		'uses' => 'PositionController@update',
		'middleware' => 'can:admin.positions.edit',
	]);

	Route::post('destroy', [
		'as' => 'admin.positions.destroy',
		'uses' => 'PositionController@destroy',
		'middleware' => 'can:admin.positions.destroy',
	]);

	Route::get('{id}/show', [
		'as' => 'admin.positions.show',
		'uses' => 'PositionController@show',
		'middleware' => 'can:admin.positions.show',
	]);
});

Route::prefix('employees')->group(function() {
	Route::get('/', 'EmployeeController@index');
});