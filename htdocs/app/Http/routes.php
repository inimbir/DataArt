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

Route::post('signin', 'RestController@signin');

Route::post('signout', 'RestController@signout');

Route::post('register', 'RestController@register');

Route::post('upload', 'RestController@uploadPhoto');

Route::post('saveRest', 'RestController@saveRest');

Route::post('loadPhotos', 'RestController@loadPhotos');

Route::post('loadRestaurantsForMap', 'RestController@loadRestaurantsForMap');

Route::post('loadRestaurantsForRatingList', 'RestController@loadRestaurantsForRatingList');

Route::post('getRestInfo', 'RestController@getRestInfo');

Route::post('countRests', 'RestController@countRests');

Route::post('updateReview', 'RestController@updateReview');

Route::get('getAdr/{adr}', function($adr) {
    $adr = explode(',', $adr);
    $json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $adr[0] . ',' . $adr[1] . '&sensor=true&language=ru');
    return $json;
});