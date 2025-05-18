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
        $prSubmittedStatusId = AppProjectStatus::where('name', 'PR Submitted')->first()->id;
        if (!$prSubmittedStatusId) {
            return redirect()->back()->with('error', 'The status "PR Submitted" does not exist.');
        }
        
        $projects = AppProject::with(['app', 'category', 'status', 'sourceOfFund', 'endUser', 'modeOfProcurement', 'projectType'])
        ->where('status_id', $prSubmittedStatusId)
        ->whereNull('certified_at')
        ->get();

        $funds = SourceOfFund::all();

        return view('budget_officer.submitted_projects.index', compact('projects', 'funds'));
    }

    
    public function certify(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:app_projects,id',
        ]);
    
        $project = AppProject::findOrFail($request->project_id);

        $certifiedStatus = AppProjectStatus::where('name', 'Certified Available Funds')->first();

        if (!$certifiedStatus) {
            return redirect()->back()->with('error', 'The status "Certified Available Funds" does not exist.');
        }
        
        $project->status_id = $certifiedStatus->id;
        $project->certified_at = now();
        $project->save();
    
        return redirect()->route('budget_officer.submitted_projects.index')
            ->with('success', 'Project certified successfully!');

    }

    public function certifiedProjects()
    {
        $certifiedStatus = AppProjectStatus::where('name', 'Certified Available Funds')->first();
    
        if (!$certifiedStatus) {
            return redirect()->back()->with('error', 'The status "Certified Available Funds" does not exist.');
        }
    
        $projects = AppProject::with(['app', 'category', 'status', 'sourceOfFund', 'endUser', 'modeOfProcurement', 'projectType'])
            ->where('status_id', $certifiedStatus->id)
            ->get();
    
        return view('budget_officer.certified_projects.index', compact('projects'));
    }

    
}