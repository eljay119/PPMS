<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetOfficerController extends Controller
{
     public function dashboard()
        {
            $budgetOfficerId = Auth::id();

            $procurementData = \App\Models\AppProject::where('end_user_id', $budgetOfficerId)
                ->whereNotNull('mode_id')
                ->whereNotNull('quarter')
                ->whereNotNull('status_id')
                ->selectRaw('mode_id, quarter, status_id, SUM(abc) as total_amount, COUNT(*) as project_count')
                ->groupBy('mode_id', 'quarter', 'status_id')
                ->with(['modeOfProcurement', 'status'])
                ->get();

            return view('budget_officer.dashboard', compact('procurementData'));
        }
}
