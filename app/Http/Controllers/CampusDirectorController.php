<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampusDirectorController extends Controller
{
    public function dashboard()
        {
            $campusDirectorId = Auth::id();

            $procurementData = \App\Models\AppProject::where('end_user_id', $campusDirectorId)
                ->whereNotNull('mode_id')
                ->whereNotNull('quarter')
                ->whereNotNull('status_id')
                ->selectRaw('mode_id, quarter, status_id, SUM(abc) as total_amount, COUNT(*) as project_count')
                ->groupBy('mode_id', 'quarter', 'status_id')
                ->with(['modeOfProcurement', 'status'])
                ->get();

            return view('campus_director.dashboard', compact('procurementData'));
        }
}
