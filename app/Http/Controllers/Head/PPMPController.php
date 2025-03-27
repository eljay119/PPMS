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
        $ppmps = PPMP::with(['sourceOfFund', 'office'])->get();
        $fundSources = SourceOfFund::all();

        return view('head.ppmps.index', compact('ppmps', 'fundSources',));
    }

    public function store(Request $request)
{
    $request->validate([
        'fiscal_year' => 'required|integer',
        'source_of_fund_id' => 'required|exists:source_of_funds,id',
    ]);

    PPMP::create([
        'fiscal_year' => $request->fiscal_year,
        'source_of_fund_id' => $request->source_of_fund_id,
        'ppmp_status_id' => 1,
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
