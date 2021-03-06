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

Route::get('wechat', 'WechatController@serve');
Route::get('/add', 'FiveFuController@addCardList');
Route::group(['middleware' => ['wechat.oauth']], function () {
    Route::get('/', 'FiveFuController@index');
    Route::get('/lottery', 'FiveFuController@lottery');
    Route::post('/given', 'FiveFuController@given');
    Route::get('/receive', 'FiveFuController@receive')->name('receive');
});