<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use App\Models\PPMP;
use App\Models\ModeOfProcurement;
use App\Models\PpmpProjectCategory;
use App\Models\SourceOfFund;
use App\Models\PpmpStatus;
use App\Models\PpmpProjectStatus;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class PPMPController extends Controller
{
    public function index2() {
        return view('head.ppmps.show');
    }

    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        $user = Auth::user();

        // Get the office assigned to the current Head user
        $office = \App\Models\Office::where('user_id', $user->id)->first();

        if (!$office) {
            return back()->with('error', 'No office assigned to this user.');
        }

        // Filter PPMP records based on the user's office_id
        $ppmps = PPMP::with(['sourceOfFund', 'office'])
                    ->where('office_id', $office->id)
                    ->get();
 
        $fundSources = SourceOfFund::all();

        return view('head.ppmps.index', compact('ppmps', 'fundSources'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'fiscal_year' => 'required|integer',
            'source_of_fund_id' => 'required|exists:source_of_funds,id',
        ]);

        $user = Auth::user();

        $office = \App\Models\Office::where('user_id', $user->id)->first();

        if (!$office) {
            return back()->with('error', 'No office assigned to this user.');
        }

        // Find an existing APP for the same fiscal year, or create a new one
        $app = \App\Models\App::firstOrCreate([
            'year' => $request->fiscal_year
        ], [
            'version_name' => 'Default Version', // You can modify this
            'status_id' => 1,
            'prepared_id' => $user->id,
        ]);

        PPMP::create([
            'fiscal_year' => $request->fiscal_year,
            'source_of_fund_id' => $request->source_of_fund_id,
            'ppmp_status_id' => 1,
            'office_id' => $office->id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('head.ppmps.index')->with('success', 'PPMP added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fiscal_year' => 'required|integer',
            'source_of_fund_id' => 'required|exists:source_of_funds,id',
        ]);

        $ppmp = PPMP::findOrFail($id);
        $ppmp->update([
            'fiscal_year' => $request->fiscal_year,
            'source_of_fund_id' => $request->source_of_fund_id,
        ]);

        return redirect()->route('head.ppmps.index')->with('success', 'PPMP updated successfully.');
    }

    public function destroy($id)
    {
        $ppmp = PPMP::findOrFail($id);
        $ppmp->delete();

        return redirect()->route('head.ppmps.index')->with('success', 'PPMP deleted successfully.');
    }

    public function show($id)
    {
        $ppmp = PPMP::with(['ppmpStatus', 'sourceOfFund', 'office', 'ppmpProjects', 'projectType'])->findOrFail($id);
        $categories = PpmpProjectCategory::all();
        $modes = ModeOfProcurement::all();
        $statuses = PpmpProjectStatus::all();
        $projectTypes = ProjectType::all();
        
        return view('head.ppmps.show', compact('ppmp', 'categories', 'modes', 'statuses', 'projectTypes'));
    }

    public function finalize(PPMP $ppmp)
    {
        $finalStatus = PpmpStatus::where('name', 'Final')->first();
        
        if (!$finalStatus) {
            return redirect()->route('head.ppmps.index')->with('error', 'Final status not found.');
        }

        $ppmp->update(['ppmp_status_id' => $finalStatus->id]);

        return redirect()->route('head.ppmps.index')->with('success', 'PPMP finalized successfully.');
    }


}
