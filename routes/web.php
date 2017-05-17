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

Route::group(['middleware' => 'auth'], function(){
	Route::resource('user', 'UserController');
	Route::resource('feed', 'FeedController');

	Route::get('/home', 'UserController@index')->name('home');
	Route::get('/admin', 'UserController@index');
	Route::get('/', 'UserController@index');
});

Auth::routes();
