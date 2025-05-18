<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use App\Models\AppProject;
use App\Models\App;
use App\Models\PpmpProjectCategory;
use App\Models\AppProjectStatus;
use App\Models\SourceOfFund;
use App\Notifications\AppProjectUpdatedNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AppProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $funds = SourceOfFund::all();
        $projects = AppProject::with(['app', 'category', 'status', 'sourceOfFund', 'endUser'])
        ->where('end_user_id', Auth::id())
        ->get();
        return view('head.app_projects.index', compact('projects', 'funds'));
    }

    // Show the form for creating a new APP Project
    public function create()
    {
        $apps = App::all();
        $categories = PpmpProjectCategory::all();
        $statuses = AppProjectStatus::all();
        $funds = SourceOfFund::all();
        $users = User::all();

        return view('head.app_projects.create', compact('apps', 'categories', 'statuses', 'funds', 'users'));
    }

    // Store a newly created APP Project
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

        return redirect()->route('head.app_projects.index')->with('success', 'APP Project created successfully!');
    }

    // Show a specific APP Project
    public function show(AppProject $appProject)
    {
        $project = AppProject::with(['endUser', 'category', 'modeOfProcurement', 'status', 'sourceOfFund', 'statusHistories.status', 'statusHistories.user'])
                ->findOrFail($appProject->id);
        return view('head.app_projects.show', compact('appProject'));
    }

    // Show the form for editing an APP Project
    public function edit(AppProject $appProject)
    {
        $apps = App::all();
        $categories = PpmpProjectCategory::all();
        $statuses = AppProjectStatus::all();
        $funds = SourceOfFund::all();
        $users = User::all();

        return view('head.app_projects.edit', compact('appProject', 'apps', 'categories', 'statuses', 'funds', 'users'));
    }

    // Update an APP Project
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
    
        // ✅ Notify the Head user
        $headUser = User::whereHas('role', function ($query) {
            $query->where('name', 'Head');
        })->first();
    
        if ($headUser) {
            $headUser->notify(new AppProjectUpdatedNotification(
                "APP Project '{$appProject->title}' was updated.",
                route('head.app_projects.show', $appProject->id)
            ));
        }
    
        return redirect()->route('head.app_projects.index')->with('success', 'APP Project updated successfully!');
    }

    // Delete an APP Project
    public function destroy(AppProject $appProject)
    {
        $appProject->delete();
        return redirect()->route('head.app_projects.index')->with('success', 'APP Project deleted successfully!');
    }


}
