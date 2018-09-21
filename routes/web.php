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

Route::get('/', function () {
    return view('home');
});

Route::resource('members', 'MemberController');

Route::post('roles', [
	'as' => 'roles.store',
	'uses' => 'RoleController@store'
]);

Route::delete('roles/{memberId}/{projectId}', [
	'as' => 'roles.destroy',
	'uses' => 'RoleController@destroy'
]);

Route::resource('projects', 'ProjectController');

