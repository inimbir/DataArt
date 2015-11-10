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

    public function upload() {
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
        $results = DB::select('select id from restaurants where name = ?', [$name]);
        if ($results != []) return -1;
        DB::insert('insert into restaurants (name,lat,lng) values (?, ?, ?)', [$name, $lat, $lng]);
        $results = DB::select('select id from restaurants where name = ?', [$name]);
        return $results[0]->id;
    }
}