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
Route::get('test', function() {
    return view('test');
});

Route::get('/', 'RestController@main');

Route::get('rating', 'RestController@rating');

Route::post('signin', 'RestController@signin');

Route::post('signout', 'RestController@signout');

Route::post('register', 'RestController@register');

Route::post('upload', 'RestController@uploadPhoto');

Route::post('saveRest', 'RestController@saveRest');

Route::post('loadPhotos', 'RestController@loadPhotos');

Route::post('loadRestaurantsForMap', 'RestController@loadRestaurantsForMap');

Route::post('loadRestaurantsSortedByGeneral', 'RestController@loadRestaurantsSortedByGeneral');

Route::post('loadRestaurantsSortedByKitchen', 'RestController@loadRestaurantsSortedByKitchen');

Route::post('loadRestaurantsSortedByInterier', 'RestController@loadRestaurantsSortedByInterier');

Route::post('loadRestaurantsSortedByService', 'RestController@loadRestaurantsSortedByService');

Route::post('getRestInfo', 'RestController@getRestInfo');

Route::post('countRests', 'RestController@countRests');

Route::post('updateReview', 'RestController@updateReview');

Route::get('getCoords', function() {
    $id = Request::get('id');
    $results = DB::select('select lat, lng from restaurants where id = ?', [$id]);
    if ($results == []) return 0;
    $res = $results[0]->lat . "|" . $results[0]->lng;
    return $res;
});

Route::get('getAdr/{adr}', function($adr) {
    $adr = explode(',', $adr);
    $json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . $adr[0] . ',' . $adr[1] . '&sensor=true&language=ru');
    return $json;
});

Route::get('getLabel', function() {
    $id = Request::get("id");
    $user = Session::get('username');
    $results = DB::select('select text from labels where idR = ? and login = ?', [$id, $user]);
    if ($results==[]) {
        DB::insert("insert into labels (idR, login, text) values (?, ?, NULL)", [$id, $user]);
        return "";
    }
    return $results[0]->text;
});

Route::get('setLabel', function() {
    $id = Request::get("id");
    $text = Request::get("text");
    $user = Session::get('username');
    DB::update("update labels set text=? where idR=? and login=?", [$text, $id, $user]);
});

Route::get('isAdmin', function() {
    return Session::get('usertype');
});

Route::get('showOnMap', function() {
    if (Session::has('username')) {
        return view('pages.main')->with([
            'username' => Session::get('username'),
            'usertype' => Session::get('usertype'),
            'id' => Request::get('idR')
        ]);
    }
    return view('pages.main')->with([
        'id' => Request::get('idR')
    ]);
});

Route::get('saveRestaurantRating', function() {
    DB::update("update restaurants set ratingWhole=?, ratingKitchen=?, ratingInterier=?, ratingService=? where id=?", [
            Request::get('generalMark'),
            Request::get('kitchenMark'),
            Request::get('interierMark'),
            Request::get('serviceMark'),
            Request::get('idR')
    ]);
});