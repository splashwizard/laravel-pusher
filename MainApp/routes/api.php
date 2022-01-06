<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('devices', 'DeviceAPIController');

Route::resource('pushers', 'PusherAPIController');
Route::resource('pushersnew', 'PusherNewAPIController');

Route::post('pushers/register','PusherAPIController@register');
Route::post('pushersnew/register','PusherNewAPIController@register');

Route::get('pushers/devices/refresh','PusherAPIController@refresh');
Route::get('pushersnew/devices/refresh','PusherNewAPIController@refresh');
