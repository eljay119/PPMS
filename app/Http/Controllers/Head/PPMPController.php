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
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        $ppmps = PPMP::with(['sourceOfFund', 'ppmpStatus', 'office'])->get();
        $fundSources = SourceOfFund::all();
        $statuses = PpmpStatus::all();

        return view('head.ppmps.index', compact('ppmps', 'fundSources', 'statuses'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'fiscal_year' => 'required|integer',
                'source_of_fund_id' => 'required|exists:source_of_funds,id',
                'ppmp_status_id' => 'required|exists:ppmp_statuses,id',
                'office_id' => 'nullable|integer',
            ]);

            
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login')->withErrors('You must be logged in to perform this action.');
            }

            $officeId = $request->office_id ?? $user->office->id;

            PPMP::create([
                'fiscal_year' => $request->fiscal_year,
                'source_of_fund_id' => $request->source_of_fund_id,
                'ppmp_status_id' => $request->ppmp_status_id,
                'office_id' => $officeId,
            ]);

            return redirect()->route('head.ppmps.index')->with('success', 'PPMP created successfully!');
        } catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('head.ppmps.index');
            
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fiscal_year' => 'required|integer',
            'source_of_fund_id' => 'required|exists:source_of_funds,id',
            'ppmp_status_id' => 'required|exists:ppmp_statuses,id',
        ]);

        $ppmp = PPMP::findOrFail($id);
        $ppmp->update([
            'fiscal_year' => $request->fiscal_year,
            'source_of_fund_id' => $request->source_of_fund_id,
            'ppmp_status_id' => $request->ppmp_status_id,
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
