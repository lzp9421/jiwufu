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

Route::get('/', 'FiveFuController@index');
Route::get('wechat', 'WechatController@serve');
Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('/user', 'fiveFuController@info');
});