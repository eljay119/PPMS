<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\User;
use App\Models\AppProjectStatus;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display a listing of APP records
    public function index()
    {
        $apps = App::with('appProjects')->get();
        return view('admin.apps.index', compact('apps'));
    }

    // Show the form for creating a new APP record
    public function create()
    {
        $statuses = AppProjectStatus::all();
        $users = User::all(); // Fetch users for 'prepared_by' field

        return view('admin.apps.create', compact('statuses', 'users'));
    }

    // Store a newly created APP record
    public function store(Request $request)
    {
        $request->validate([
            'version_name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'status_id' => 'required|exists:app_project_statuses,id',
            'prepared_id' => 'required|exists:users,id',
        ]);

        App::create($request->all());

        return redirect()->route('admin.apps.index')->with('success', 'APP record created successfully!');
    }

    // Show a specific APP record
    public function show(App $app)
    {
        return view('admin.apps.show', compact('app'));
    }

    // Show the form for editing an APP record
    public function edit(App $app)
    {
        $statuses = AppProjectStatus::all();
        $users = User::all(); 

        return view('admin.apps.edit', compact('app', 'statuses', 'users'));
    }

    // Update an APP record
    public function update(Request $request, App $app)
    {
        $request->validate([
            'version_name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'status_id' => 'required|exists:app_project_statuses,id',
            'prepared_id' => 'required|exists:users,id',
        ]);

        $app->update($request->all());

        return redirect()->route('admin.apps.index')->with('success', 'APP record updated successfully!');
    }

    // Delete an APP record
    public function destroy(App $app)
    {
        $app->delete();
        return redirect()->route('admin.apps.index')->with('success', 'APP record deleted successfully!');
    }
}
