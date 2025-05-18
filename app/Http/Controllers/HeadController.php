<?php

namespace App\Http\Controllers;

use App\Models\AppProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeadController extends Controller
{
 public function dashboard()
    {
        $headId = Auth::id();

        $procurementData = \App\Models\AppProject::where('end_user_id', $headId)
            ->whereNotNull('mode_id')
            ->whereNotNull('quarter')
            ->whereNotNull('status_id')
            ->selectRaw('mode_id, quarter, status_id, SUM(abc) as total_amount, COUNT(*) as project_count')
            ->groupBy('mode_id', 'quarter', 'status_id')
            ->with(['modeOfProcurement', 'status'])
            ->get();

        return view('head.dashboard', compact('procurementData'));
    }
}
