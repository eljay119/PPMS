<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        
        $users = User::with(['role', 'office'])->get();
        

        return view('admin.dashboard', compact('users'));
    }
}
