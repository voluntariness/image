<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', 'HomeController@index');
Route::get('/{key}', 'HomeController@image');
Route::post('/upload', 'HomeController@upload');
Route::post('/imgs', 'HomeController@imgs');
