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

    public function rating() {
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
        $result = "";
        foreach ($rows as $row) $result = ($result . $row->filename . '|');
        return substr($result, 0, -1);;
    }
    public function loadRestaurantsForMap() {
        $rows = DB::select('select id, name, lat, lng from restaurants');
        $result = "";
        foreach($rows as $row) $result = ($result . $row->id . ',' . $row->name . ',' . $row->lat . ',' . $row->lng . '|');
        return substr($result, 0, -1);
    }

    public function loadRestaurantsForRatingList() {
        $results = DB::select('select name, review, adress from restaurants where id=?', [Request::get('id')]);
        $file=file_get_contents('rest-example.html');
        $file=str_replace('#NAME', $results[0]->name, $file);
        $file=str_replace('#ID', Request::get('id'), $file);
        $file=str_replace('#REVIEW',$results[0]->review, $file);
        $file=str_replace('#ADRESS',$results[0]->adress, $file);
        return $file;
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
}