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
    return redirect()->route('login');
});

Route::get('/login',['as' => 'login','uses' => 'UserController@viewLogin']);
Route::post('/login',['as' => 'user.login','uses' => 'UserController@login_action']);

Route::group(['middleware' => ['admin.auth']],function(){

	Route::get('/home',['as' => 'home','uses' => 'HomeController@index']);
	Route::get('/logout',['as' => 'logout','uses' => 'UserController@logout']);
	//Route::resource('devices', 'DeviceController');
	//Route::resource('pushers', 'PusherController');

});







