<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Middleware; 

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Ensure you have this Blade template
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();

        $redirectRoutes = [
            'admin' => '/admin',
            'head' => '/head',
            'bacsec' => '/bacsec',
            'budget_officer' => '/budget_officer',
            'campus_director' => '/campus_director',
        ];

        return redirect($redirectRoutes[$user->role] ?? '/default-dashboard');
    }

    return back()->withErrors(['email' => 'Invalid credentials.']);
}

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
