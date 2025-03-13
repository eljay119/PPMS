<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use App\Models\PpmpProject;
use App\Models\PPMP;
use App\Models\PpmpProjectCategory;
use App\Models\ModeOfProcurement;
use App\Models\PpmpProjectStatus;
use App\Models\ProjectType;
use App\Models\AppProject;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PpmpProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($ppmp_id)
    {
        $ppmp = PPMP::with('ppmpProjects.category', 'ppmpProjects.modeOfProcurement', 'ppmpProjects.type', 'ppmpProjects.status', 'ppmpProjects.appProject')
                    ->findOrFail($ppmp_id);
    
        return view('head.ppmp_projects.index', compact('ppmp'));
    }    

    public function create($ppmp_id)
    {
        return view('head.ppmp_projects.create', [
            'ppmp_id' => $ppmp_id,
            'categories' => PpmpProjectCategory::all(),
            'modes' => ModeOfProcurement::all(),
            'statuses' => PpmpProjectStatus::all(),
            'types' => ProjectType::all(),
            'appProjects' => AppProject::all(),
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
            'category_id' => 'required|exists:ppmp_project_categories,id',
            'mode_of_procurement_id' => 'required|exists:mode_of_procurements,id',
            'status_id' => 'required|exists:ppmp_project_statuses,id',
            'type_id' => 'required|exists:project_types,id',
            'app_project_id' => 'required|exists:app_projects,id',
            'ppmp_id' => 'required|exists:ppmps,id',
        ]);

        // Explicitly set the PPMP ID
        $validated['ppmp_id'] = $request->ppmp_id;

        $project = PpmpProject::create($validated);

        Log::info($project);
        return redirect()->route('head.ppmp_projects.index', ['ppmp_id' => $request->ppmp_id])
                        ->with('success', 'PPMP Project created successfully!');
    }


    public function show($id)
    {
        $project = PpmpProject::with(['ppmp', 'category', 'modeOfProcurement', 'status', 'type', 'appProject'])
                              ->findOrFail($id);

        return view('head.ppmp_projects.show', compact('project'));
    }

    public function edit($id)
    {
        $project = PpmpProject::findOrFail($id);

        return view('head.ppmp_projects.edit', [
            'project' => $project,
            'categories' => PpmpProjectCategory::all(),
            'modes' => ModeOfProcurement::all(),
            'statuses' => PpmpProjectStatus::all(),
            'types' => ProjectType::all(),
            'appProjects' => AppProject::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
            'category_id' => 'required|exists:ppmp_project_categories,id',
            'mode_of_procurement_id' => 'required|exists:mode_of_procurements,id',
            'status_id' => 'required|exists:ppmp_project_statuses,id',
            'type_id' => 'required|exists:project_types,id',
            'app_project_id' => 'required|exists:app_projects,id',
        ]);

        $project = PpmpProject::findOrFail($id);
        $project->update($validated);

        return redirect()->route('head.ppmp_projects.index', $project->ppmp_id)
                         ->with('success', 'PPMP Project updated successfully!');
    }

    public function destroy($id)
    {
        $project = PpmpProject::findOrFail($id);
        $ppmp_id = $project->ppmp_id; // Get before deleting
        $project->delete();

        return redirect()->route('head.ppmp_projects.index', $ppmp_id)
                         ->with('success', 'PPMP Project deleted successfully!');
    }
}
