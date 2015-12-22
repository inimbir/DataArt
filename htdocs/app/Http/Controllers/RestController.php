<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RestController extends Controller
{
    public function __construct() {
        $this->middleware('guest');
    }

    public function main() {
        if (Session::has('username')) {
            return view('pages.main')->with([
                'username' => Session::get('username'),
                'usertype' => Session::get('usertype')
            ]);
        }
        return view('pages.main');
    }
    
    public function newpage() {
        if (Session::has('username')) {
            return view('pages.newpage')->with([
                'username' => Session::get('username'),
                'usertype' => Session::get('usertype')
            ]);
        }
        return view('pages.newpage');
    }

    public function rating() {
        if (Session::has('username')) {
            return view('pages.rating')->with([
                'username' => Session::get('username'),
                'usertype' => Session::get('usertype')
            ]);
        }
        return view('pages.rating');
    }

    public function signin() {
        $results =  DB::select('select type from users where login = ? and password = ?', [Request::get('Login'),md5(Request::get('Password'))]);
        if ($results == []) return -1;
        Session::put('username', Request::get('Login'));
        Session::put('usertype', $results[0]->type);
        return 1;
    }

    public function signout() {
        Session::flush();
    }

    public function register() {
        $login = Request::get('Login');
        $results = DB::select('select id from users where login = ?', [$login]);
        if ($results == []) {
            DB::insert('insert into users (login, password, type) values (?,?,?)', [$login, md5(Request::get('Password')), 0]);
            Session::put('username', $login);
            Session::put('usertype', 0);
            return 1;
        }
        return -1;
    }

    public function uploadPhoto() {
        $file = Request::file('0');
        $filename = Str::ascii($file->getClientOriginalName());
        $id = Request::get("id");
        $file->move('photos/' . $id, $filename);
        DB::insert('insert into photos (idR, filename) values (?, ?)', [$id, $filename]);
    }

    public function saveRest() {
        $name = Request::get('Name');
        $lat = Request::get('lat');
        $lng = Request::get('lng');
        $adr = Request::get('adr');
        $results = DB::select('select id from restaurants where name = ?', [$name]);
        if ($results != []) return -1;
        DB::insert('insert into restaurants (name,lat,lng,adress) values (?, ?, ?, ?)', [$name, $lat, $lng, $adr]);
        $results = DB::select('select id from restaurants where name = ?', [$name]);
        return $results[0]->id;
    }

    public function loadPhotos() {
        $rows = DB::select('select filename from photos where idR=?', [Request::get('id')]);
        if ($rows!=[]) {
            $result = "";
            foreach ($rows as $row) $result = ($result . $row->filename . '|');
            return substr($result, 0, -1);
        }
        return "../nopic.png";
    }
    public function loadRestaurantsForMap() {
        $rows = DB::select('select id, name, lat, lng from restaurants');
        $result = "";
        foreach ($rows as $row) $result = ($result . $row->id . ',' . $row->name . ',' . $row->lat . ',' . $row->lng . '|');
        return substr($result, 0, -1);
    }

    public function getRestInfo() {
        $result = DB::select('SELECT name, review FROM restaurants WHERE id=?', [Request::get('id')]);
        return ($result[0]->name . '|' . $result[0]->review);
    }

    public function countRests() {
        $rows = DB::select('SELECT id FROM restaurants');
        $result = "";
        foreach ($rows as $row) $result = $result . $row->id . '.';
        return substr($result, 0, -1);
    }

    public function updateReview()
    {
        DB::update('update restaurants set review=? where id=?', [Request::get('review'), Request::get('id')]);
    }

    public function loadRestaurantsSortedByGeneral() {
        $results = DB::select('select id, name, review, adress as address, ratingWhole as generalMark, ratingKitchen as kitchenMark, ratingInterier as interierMark, ratingService as serviceMark, img from restaurants
        left join (select idR,filename as img from photos) t on restaurants.id=t.idR group by id order by ratingWhole desc');
        foreach ($results as $result) {
            if ($result->img==null) $result->img="img/2.jpg";
            else $result->img="photos/" . $result->id . "/" . $result->img;
        }
        return json_encode($results);
    }

    public function loadRestaurantsSortedByKitchen() {
        $results = DB::select('select id, name, review, adress as address, ratingWhole as generalMark, ratingKitchen as kitchenMark, ratingInterier as interierMark, ratingService as serviceMark, img from restaurants
        left join (select idR,filename as img from photos) t on restaurants.id=t.idR group by id order by ratingKitchen desc');
        foreach ($results as $result) {
            if ($result->img==null) $result->img="img/2.jpg";
            else $result->img="photos/" . $result->id . "/" . $result->img;
        }
        return json_encode($results);
    }

    public function loadRestaurantsSortedByInterier() {
        $results = DB::select('select id, name, review, adress as address, ratingWhole as generalMark, ratingKitchen as kitchenMark, ratingInterier as interierMark, ratingService as serviceMark, img from restaurants
        left join (select idR,filename as img from photos) t on restaurants.id=t.idR group by id order by ratingInterier desc');
        foreach ($results as $result) {
            if ($result->img==null) $result->img="img/2.jpg";
            else $result->img="photos/" . $result->id . "/" . $result->img;
        }
        return json_encode($results);
    }

    public function loadRestaurantsSortedByService() {
        $results = DB::select('select id, name, review, adress as address, ratingWhole as generalMark, ratingKitchen as kitchenMark, ratingInterier as interierMark, ratingService as serviceMark, img from restaurants
        left join (select idR,filename as img from photos) t on restaurants.id=t.idR group by id order by ratingService desc');
        foreach ($results as $result) {
            if ($result->img==null) $result->img="img/2.jpg";
            else $result->img="photos/" . $result->id . "/" . $result->img;
        }
        return json_encode($results);
    }
    
    public function deleteRest() {
        DB::delete('delete from restaurants where id=?', [Request::get('id')]);
    }
}