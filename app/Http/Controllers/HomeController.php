<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home.landing');
    }

    public function services()
    {
        return view('frontend.home.services');
    }
}
