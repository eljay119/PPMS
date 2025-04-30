<?php

namespace App\Http\Controllers\BudgetOfficer;

use App\Http\Controllers\Controller;
use App\Models\AppProject;
use App\Models\App;
use App\Models\PpmpProjectCategory;
use App\Models\AppProjectStatus;
use App\Models\SourceOfFund;
use App\Models\User;
use Illuminate\Http\Request;

class AppProject5Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        $projects = AppProject::with(['app', 'category', 'status', 'sourceOfFund', 'endUser', 'modeOfProcurement', 'projectType'])->get();
        $funds = SourceOfFund::all();

        return view('budget_officer.submitted_projects.index', compact('projects', 'funds'));
    }

    
    public function certify(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:app_projects,id',
        ]);
    
        $project = AppProject::findOrFail($request->project_id);
    
        // Perform the certification logic (e.g., update a "certified_at" timestamp)
        $project->certified_at = now();
        $project->save();
    
        return redirect()->route('budget_officer.submitted_projects.index')
            ->with('success', 'Project certified successfully!');
    }

    public function certifiedProjects()
    {
        $projects = AppProject::with(['app', 'category', 'status', 'sourceOfFund', 'endUser', 'modeOfProcurement', 'projectType'])
            ->whereNotNull('certified_at')
            ->get();
    
        return view('budget_officer.certified_projects.index', compact('projects'));
    }

    
}