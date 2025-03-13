<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampusDirectorController extends Controller
{
    public function dashboard()
    {
        return view('campus_director.dashboard');
    }
}
