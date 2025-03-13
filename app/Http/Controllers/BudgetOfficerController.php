<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudgetOfficerController extends Controller
{
    public function dashboard()
    {
        return view('budget_officer.dashboard');
    }
}
