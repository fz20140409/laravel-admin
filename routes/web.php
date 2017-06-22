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
    return view('welcome');
});
Route::group(['prefix'=>'admin','as'=>'admin.','namespace'=>'Admin'],function (){

    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login');
    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::get('home', 'HomeController@home')->name('home');

    Route::resource('user','UserController');
    Route::resource('role','RoleController');
    Route::get('role/permission/{id}','RoleController@permission')->name('role.permission');
    Route::resource('permission','PermissionController');

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
