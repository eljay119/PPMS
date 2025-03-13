<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppStatus;
use Illuminate\Http\Request;

class AppStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display a listing of APP Statuses
    public function index()
    {
        $statuses = AppStatus::all();
        return view('admin.app_statuses.index', compact('statuses'));
    }

    // Show the form for creating a new APP Status
    public function create()
    {
        return view('admin.app_statuses.create');
    }

    // Store a newly created APP Status
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        AppStatus::create($request->all());

        return redirect()->route('admin.app_statuses.index')->with('success', 'APP Status created successfully!');
    }

    // Show a specific APP Status
    public function show(AppStatus $appStatus)
    {
        return view('admin.app_statuses.show', compact('appStatus'));
    }

    // Show the form for editing an APP Status
    public function edit(AppStatus $appStatus)
    {
        return view('admin.app_statuses.edit', compact('appStatus'));
    }

    // Update an APP Status
    public function update(Request $request, AppStatus $appStatus)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $appStatus->update($request->all());

        return redirect()->route('admin.app_statuses.index')->with('success', 'APP Status updated successfully!');
    }

    // Delete an APP Status
    public function destroy(AppStatus $appStatus)
    {
        $appStatus->delete();
        return redirect()->route('admin.app_statuses.index')->with('success', 'APP Status deleted successfully!');
    }
}
