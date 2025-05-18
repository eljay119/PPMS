<?php

namespace App\Http\Controllers\BacSec;

use App\Http\Controllers\Controller;
use App\Models\PpmpProjectCategory;
use App\Models\SourceOfFund;
use App\Models\ModeOfProcurement;
use App\Models\User;
use App\Models\App;
use App\Models\AppProject;
use App\Models\PpmpProject;
use App\Models\AppStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $apps = App::with('appStatus', 'appProjects')->get();
        $statuses = AppStatus::all();

        $sources = SourceOfFund::all();

        return view('bacsec.app.index', compact('apps', 'statuses', 'sources'));
    }


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

    
    public function show($id)
    {
        $app = App::with([
            'appStatus',
            'appProjects.category',
            'appProjects.modeOfProcurement',
            'appProjects.sourceOfFund',
            'appProjects.endUser'
        ])->findOrFail($id);
    
        return view('bacsec.app.show', compact('app'));

    }


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
    
        // Fetch PPMP projects that match the APP's fiscal year
        $ppmpProjects = \App\Models\PpmpProject::whereHas('ppmp', function ($query) use ($app) {
            $query->where('fiscal_year', $app->year)
                ->whereNull('app_project_id'); 
                
        })->with(['category', 'office', 'sourceOfFund', 'modeOfProcurement', 'endUser'])->get();

        $categories = PpmpProjectCategory::all();
        $sources = SourceOfFund::all();
        $modes = ModeOfProcurement::all();
        $endUsers = User::all(); 
    
        return view('bacsec.app.consolidate', compact('app', 'ppmpProjects', 'categories', 'sources', 'modes', 'endUsers'));
    }

    public function mergeProjects(Request $request, $appId)
    {
        $request->validate([
            'selected_projects' => 'required',
            'quarter' => 'required|integer',
            'category_id' => 'required|exists:ppmp_project_categories,id',
            'mode_id' => 'required|exists:mode_of_procurements,id',
            'end_user_id' => 'required|exists:users,id',
        ]);
    
        $selectedProjects = json_decode($request->selected_projects);
        $ppmpProjects = PPMPProject::whereIn('id', $selectedProjects)->get();
    
        $amount = str_replace(',', '', $request->totalABC);
        $finalAmount = str_replace('₱','',$amount);

        Log::info('Final Amount: ' . $finalAmount);
        Log::info('Final Amount: ' . $request->totalABC);

       $mergeProject = AppProject::create([
            'app_id' => $appId,
            'title' => $request->title,
            'abc' => $finalAmount,
            'category_id' => $request->category_id,
            'mode_id' => $request->mode_id,
            'fund_id' => $ppmpProjects->first()->ppmp->source_of_fund_id,
            'end_user_id' => $request->end_user_id,
            'quarter' => $request->quarter,
            'status_id' => 1,
        ]);
        foreach ($ppmpProjects as $ppmp) {
            $ppmp->app_project_id = $mergeProject->id;
            $ppmp->save();

           
        }
    
        return redirect()->route('bacsec.app.show', $appId)->with('success', 'Projects successfully merged!');
    }
    

    private function resolveEndUserId($endUser)
    {
        
        $user = \App\Models\User::where('name', $endUser)->first();

        
        return $user ? $user->id : Auth::id();
    }

    

}
