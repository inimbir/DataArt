<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'RestController@main');

Route::get('rating', 'RestController@rating');

Route::get('contact', 'WelcomeController@contact');

Route::post('signin', 'RestController@signin');

Route::post('signout', 'RestController@signout');

Route::post('register', 'RestController@register');

Route::post('upload', 'RestController@upload');

Route::post('saveRest', 'RestController@saveRest');