<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch all users along with their office data
        $users = User::with('office')->get(); 
        

        return view('admin.dashboard', compact('users'));
    }
}
