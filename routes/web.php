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

Route::get('/', 'LoginController@index');
Route::post('/', 'LoginController@login');
Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@login');
Route::any('/logout', 'LoginController@logout');

//middle ware session check group  --> after login page
Route::group(['middleware' => 'usersession'], function () {
    Route::any('/users', 'UserController@index');
    Route::any('/datatable/users', 'UserController@usersDatatable');
    Route::any('/user-add', 'UserController@add');
    Route::any('/user-edit/{id}', 'UserController@edit');
    Route::any('/action/user-add', 'UserController@actionAdd');
    Route::any('/action/user-edit', 'UserController@actionEdit');
    Route::any('/action/user-status', 'UserController@actionStatus');

    Route::any('/roles', 'UserController@roles');
    Route::any('/datatable/roles', 'UserController@rolesDatatable');
    Route::any('/role-add', 'UserController@roleAdd');
    Route::any('/role-edit/{id}', 'UserController@roleEdit');
    Route::any('/role-permission/{id}', 'UserController@rolePermission');
    Route::any('/action/role-add', 'UserController@actionRoleAdd');
    Route::any('/action/role-edit', 'UserController@actionRoleEdit');
    Route::any('/action/role-permission', 'UserController@actionRolePermission');
    Route::any('/action/role-status', 'UserController@actionRoleStatus');
});
