<?php

namespace App\Http\Controllers\BacSec;

use App\Http\Controllers\Controller;
use App\Models\AppProject;
use App\Models\App;
use App\Models\PpmpProjectCategory;
use App\Models\AppProjectStatus;
use App\Models\SourceOfFund;
use App\Models\AppProjectStatusHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppProject2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index(Request $request)
    {
        $query = AppProject::query();
    
       // Apply filters if needed
        if ($request->filled('quarterFilter')) {
            $query->where('quarter', $request->quarterFilter);
        }
        if ($request->filled('source_filter')) {
            $query->where('fund_id', $request->source_filter);
        }
        if ($request->filled('statusFilter')) {
            $query->where('status_id', $request->statusFilter);
        }
        if ($request->filled('yearFilter')) {
            $query->whereYear('created_at', $request->yearFilter);
        }
        
        
        $projects = $query->with(['endUser', 'category', 'modeOfProcurement', 'status', 'sourceOfFund'])->get();

        $sources = SourceOfFund::all();
        $statuses = AppProjectStatus::all();
        $users = User::all();
    
        return view('bacsec.app_projects.index', compact('projects', 'sources', 'statuses', 'users'));
    }

    
    public function create()
    {
        $apps = App::all();
        $categories = PpmpProjectCategory::all();
        $statuses = AppProjectStatus::all();
        $funds = SourceOfFund::all();
        $users = User::all();

        return view('bacsec.app_projects.create', compact('apps', 'categories', 'statuses', 'funds', 'users'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'ppmp_id' => 'required|exists:ppmps,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'abc' => 'required|numeric|min:0',
            'quarter' => 'required|integer|min:1|max:4',
            'mode_id' => 'required|exists:mode_of_procurements,id',
            'app_id' => 'required|exists:apps,id',
            'category_id' => 'required|exists:ppmp_project_categories,id',
            'status_id' => 'required|exists:app_project_statuses,id',
            'fund_id' => 'required|exists:source_of_funds,id',
            'end_user_id' => 'required|exists:users,id',
        ]);

        AppProject::create($request->all());

        return redirect()->route('bacsec.app_projects.index')->with('success', 'APP Project created successfully!');
    }

    
    public function show(AppProject $appProject)
    {
        $project = AppProject::with(['endUser', 'category', 'modeOfProcurement', 'status', 'sourceOfFund', 'statusHistories.status', 'statusHistories.user'])->findOrFail($appProject->id);
        return view('bacsec.app_projects.show', compact('appProject'));
    }

    public function showToEdit($id)
    {
        $project = AppProject::with(['endUser', 'category', 'modeOfProcurement', 'status', 'sourceOfFund'])->findOrFail($id);

        $users = User::where('role_id', 2)->get();  

        return view('bacsec.app_projects.edit', compact('project', 'users'));
    }

    public function showToAdd($id)
    {
        $project = AppProject::with(['endUser', 'category', 'modeOfProcurement', 'status', 'sourceOfFund'])->findOrFail($id);
        return view('bacsec.app_projects.add', compact('project'));
    }

    public function edit(AppProject $appProject)
    {
        $apps = App::all();
        $categories = PpmpProjectCategory::all();
        $statuses = AppProjectStatus::all();
        $funds = SourceOfFund::all();
        $users = User::all();

        return view('bacsec.app_projects.edit', compact('appProject', 'apps', 'categories', 'statuses', 'funds', 'users'));
    }


  
    public function update(Request $request, AppProject $appProject)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'abc' => 'required|numeric|min:0',
            'quarter' => 'required|integer|min:1|max:4',
            'mode_id' => 'required|exists:mode_of_procurements,id',
            'app_id' => 'required|exists:apps,id',
            'category_id' => 'required|exists:ppmp_project_categories,id',
            'status_id' => 'required|exists:app_project_statuses,id',
            'fund_id' => 'required|exists:source_of_funds,id',
            'end_user_id' => 'required|exists:users,id',
        ]);

        $appProject->update($request->all());

        return redirect()->route('bacsec.app_projects.index')->with('success', 'APP Project updated successfully!');

        
        $project = AppProject::find($request->id);
        if ($project) {
            $project->title = $request->title;
            $project->abc = $request->amount;
            $project->remarks = $request->remarks;
            $project->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
        }


    public function destroy(AppProject $appProject)
    {
        $appProject->delete();
        return redirect()->route('bacsec.app_projects.index')->with('success', 'APP Project deleted successfully!');
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'status_id' => 'required|exists:app_project_statuses,id',
            'remarks' => 'required|string',
            'project_ids' => 'required|array',
            'project_ids.*' => 'exists:app_projects,id',
        ]);

        $statusId = $request->status_id;
        $remarks = $request->remarks;
        $updatedBy = Auth::user()->id; // Get the authenticated user's ID
        $updated_at = $request->updated_at; // Get the current timestamp

        foreach ($request->project_ids as $projectId) {
            // Update the project's status
            $project = AppProject::findOrFail($projectId);
            $project->update(['status_id' => $statusId, 'remarks' => $remarks]);

            // Save the status update in the history table
            AppProjectStatusHistory::create([
                'updated_at' => $updated_at, 
                'updated_by' => $updatedBy, 
                'app_project_id' => $projectId,
                'status_id' => $statusId,
                'remarks' => $remarks,
                'updated_by' => $updatedBy, 
            ]); 
        }

        return redirect()->back()->with('success', 'Projects updated successfully.');
    }
    
    

    public function savePr(Request $request, $id)
    {
        $request->validate([
            'pr_number' => 'required|unique:app_projects,pr_no', 
        ]);
    
        $project = AppProject::findOrFail($id);
    
        // Update the project's pr_no (correct column name)
        $project->pr_no = $request->pr_number;
        $project->save();
    
        return redirect()->route('bacsec.app_projects.index')
            ->with('success', 'PR Number created and saved to project successfully!');
    }

    public function saveEdit(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'final_abc' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
        ]);

        $project = AppProject::findOrFail($id);

        // Only updat  e if a new value is provided
        if ($request->filled('user_id')) {
            $project->end_user_id = $request->user_id;
        }

        if ($request->filled('final_abc')) {
            $project->abc = $request->final_abc;
        }

        if ($request->filled('remarks')) {
            $project->remarks = $request->remarks;
        }

        $project->save();

        return redirect()->route('bacsec.app_projects.index')
            ->with('success', 'Project details updated successfully!');
    }


}    
