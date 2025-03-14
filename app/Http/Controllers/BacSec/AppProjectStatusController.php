<?php

namespace App\Http\Controllers\BacSec;

use App\Http\Controllers\Controller;
use App\Models\AppProjectStatus;
use Illuminate\Http\Request;

class AppProjectStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display a listing of project statuses
    public function index()
    {
        $statuses = AppProjectStatus::all();
        return view('bacsec.app_project_statuses.index', compact('statuses'));
    }

    public function show($id)
    {
        $status = AppProjectStatus::findOrFail($id);
        return view('bacsec.app_project_statuses.show', compact('status'));
    }


    // Show the form for creating a new project status
    public function create()
    {
        return view('bacsec.app_project_statuses.create');
    }

    // Store a newly created project status
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:app_project_statuses,name',
            'description' => 'nullable|string',
        ]);

        AppProjectStatus::create($request->all());

        return redirect()->route('bacsec.app_project_statuses.index')->with('success', 'App Project Status created successfully!');
    }

    // Show the form for editing a project status
    public function edit(AppProjectStatus $appProjectStatus)
    {
        return view('bacsec.app_project_statuses.edit', compact('appProjectStatus'));
    }

    // Update a project status
    public function update(Request $request, AppProjectStatus $appProjectStatus)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:app_project_statuses,name,' . $appProjectStatus->id,
            'description' => 'nullable|string',
        ]);

        $appProjectStatus->update($request->all());

        return redirect()->route('bacsec.app_project_statuses.index')->with('success', 'App Project Status updated successfully!');
    }

    // Delete a project status
    public function destroy(AppProjectStatus $appProjectStatus)
    {
        $appProjectStatus->delete();

        return redirect()->route('bacsec.app_project_statuses.index')->with('success', 'App Project Status deleted successfully!');
    }
}
