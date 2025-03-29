<?php

namespace App\Http\Controllers\BacSec;

use App\Http\Controllers\Controller;
use App\Models\AppProject;
use App\Models\App;
use App\Models\PpmpProjectCategory;
use App\Models\AppProjectStatus;
use App\Models\SourceOfFund;
use App\Models\User;
use Illuminate\Http\Request;

class AppProject2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index(Request $request)
    {
        $query = AppProject::query();
    
        if ($request->filled('quarterFilter')) {
            $query->where('quarter', $request->quarterFilter);
        }
        
        $sources = SourceOfFund::all();
        $statuses = AppProjectStatus::all();
        $projects = $query->with(['app', 'category', 'status', 'fund', 'endUser'])->get();
    
        return view('bacsec.app_projects.index', compact('projects', 'sources', 'statuses'));
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
        return view('bacsec.app_projects.show', compact('appProject'));
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
    }

   
    public function destroy(AppProject $appProject)
    {
        $appProject->delete();
        return redirect()->route('bacsec.app_projects.index')->with('success', 'APP Project deleted successfully!');
    }
}
