<?php

namespace App\Http\Controllers;


class WelcomeController extends Controller
{
    public function __construct() {
        $this->middleware('guest');
    }
}