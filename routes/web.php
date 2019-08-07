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

Route::get('/', 'MainController@index')->name('welcome');
Route::get('/merge', 'MainController@MurgeMuliple')->name('welcome.merge');

Route::post('/pdf','MainController@store')->name('save');
Route::post('/pdf/Multiple','MainController@MultipleUploads')->name('save.multiple');
Route::get('/img','MainController@Create');

