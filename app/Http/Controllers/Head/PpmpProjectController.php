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
        $ppmp = PPMP::with('ppmpProjects')
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
        Log::info('PPMP Project Store Request:', ['data' => $request->all()]);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
            'category_id' => 'required|exists:ppmp_project_categories,id',
            'mode_of_procurement_id' => 'required|exists:mode_of_procurements,id',
            'status_id' => 'required|exists:ppmp_project_statuses,id',
            'type_id' => 'required|exists:project_types,id',
            'ppmp_id' => 'required|exists:ppmps,id',
        ]);
       
        Log::info('Validated Data:', $validated);

        try {
            $project = PpmpProject::create($validated);
            Log::info('PPMP Project Created:', ['id' => $project->id]);
            return redirect()->route('head.ppmps.show', ['ppmp_id' => $request->ppmp_id])
                ->with('success', 'PPMP Project created successfully!');
        } catch (\Exception $e) {
            Log::error('PPMP Project Store Error:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to save project.');
        }
    }

    public function show($id)
    {
        $project = PpmpProject::with(['ppmp', 'category', 'modeOfProcurement', 'status', 'type', 'appProject'])
                            ->findOrFail($id);
        $projects = AppProject::all(); // Fetch all APP projects
        $statuses = PpmpProjectStatus::all(); // Fetch statuses

        return view('head.ppmp_projects.show', compact('project', 'projects', 'statuses'));
    }


    public function edit($id)
    {
        $project = PpmpProject::with(['category', 'modeOfProcurement', 'status', 'type', 'appProject'])->findOrFail($id);
    
        return response()->json([
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

        return redirect()->route('head.ppmps.show', $project->ppmp_id)
                         ->with('success', 'PPMP Project updated successfully!');

    }

    public function destroy($id)
    {
        $project = PpmpProject::findOrFail($id);
        $ppmp_id = $project->ppmp_id; 
        $project->delete();

        return redirect()->route('head.ppmps.show', $ppmp_id)
                         ->with('success', 'PPMP Project deleted successfully!');

    }
    
}
