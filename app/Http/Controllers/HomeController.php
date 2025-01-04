<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  
    public function index()
    {
        return view('auth.selection');
    }
  
   
    public function login()
    {
        return view('auth.login'); 
    }

    public function dashboard()
    {
        return view('dashboard'); 
    }
}
