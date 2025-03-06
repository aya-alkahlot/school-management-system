<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    public function index()
    {
        return view('auth.selection');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
