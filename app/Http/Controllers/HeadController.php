<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HeadController extends Controller
{
    public function dashboard()
    {
        return view('head.dashboard');
    }
}
