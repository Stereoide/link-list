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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/links/collect', 'LinkController@collectLinks')->name('links.collect');
    Route::post('/links/collect', 'LinkController@processCollectedLinks')->name('links.processCollected');
    Route::get('/links/{link}/follow', 'LinkController@follow')->name('links.follow');
    Route::get('/links/{link}/dismiss', 'LinkController@dismiss')->name('links.dismiss');
    Route::get('/links/{link}/star', 'LinkController@star')->name('links.star');
    Route::get('/links/{link}/unstar', 'LinkController@unstar')->name('links.unstar');

    Route::get('/links/read', 'LinkController@read')->name('links.read');
    Route::get('/links/notread', 'LinkController@notRead')->name('links.unread');
    Route::get('/links/starred', 'LinkController@starred')->name('links.starred');
    Route::get('/links/notstarred', 'LinkController@notStarred')->name('links.notstarred');
    Route::get('/links/dismissed', 'LinkController@dismissed')->name('links.dismissed');
    Route::get('/links/notdismissed', 'LinkController@notDismissed')->name('links.notdismissed');

    Route::resource('/links', 'LinkController');
});