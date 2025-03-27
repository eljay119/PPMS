<?php

namespace App\Http\Controllers\BacSec;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\AppStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display all APPs
    public function index()
    {
        $apps = App::with('appStatus')->get();
        $statuses = AppStatus::all();

        return view('bacsec.app.index', compact('apps', 'statuses'));
    }

    // Store new APP
    public function store(Request $request)
    {
        $request->validate([
            'version_name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        App::create([
            'version_name' => $request->version_name,
            'year' => $request->year,
            'status_id' => 1, 
            'prepared_id' => Auth::id(),
        ]);

        return redirect()->route('bacsec.app.index')->with('success', 'APP record created successfully!');
    }

    // Show individual APP
    public function show($id)
    {
        $app = App::with('appStatus')->findOrFail($id);

       // $app = App::findOrFail($id);

        return view('bacsec.app.show', compact('app'));
    }

    // Update existing APP
    public function update(Request $request, App $app)
    {
        $request->validate([
            'version_name' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $app->update([
            'version_name' => $request->version_name,
            'year' => $request->year,
        ]);

        return redirect()->route('bacsec.app.index')->with('success', 'APP record updated successfully!');
    }

    // Delete APP
    public function destroy(App $app)
    {
        $app->delete();

        return redirect()->route('bacsec.app.index')->with('success', 'APP record deleted successfully!');
    }

    public function consolidate($id)
    {
        $app = App::with(
            'appProjects.category',
            'appProjects.office',
            'appProjects.sourceOfFund',
            'appProjects.modeOfProcurement'
        )->findOrFail($id);
    
        return view('bacsec.app.consolidate', compact('app'));
    }
    
    

}
