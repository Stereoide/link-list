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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/links/collect', 'LinkController@collectLinks')->name('collectLinks');
Route::post('/links/collect', 'LinkController@processCollectedLinks')->name('processCollectedLinks');
Route::resource('/links', 'LinkController');
