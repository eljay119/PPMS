<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BacSecController extends Controller
{
    public function dashboard()
    {
        return view('bacsec.dashboard');
    }
}
