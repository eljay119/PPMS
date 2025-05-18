<?php

namespace App\Http\Controllers;
use App\Models\AppProjectStatus; // or whichever model you want to export
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BacSecExport;
use App\Models\AppProject; 
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;


class BacSecController extends Controller
{

    public function dashboard()
    {
        $projectCount = AppProject::count();

       
        $waitingPRSubmission = AppProject::where('status_id', 1)->count();
        $prSubmitted = AppProject::where('status_id', 2)->count();
        $certifiedAvailableFunds = AppProject::where('status_id', 3)->count();
        $campusApproval = AppProject::where('status_id', 4)->count();
        $campusEndorsement = AppProject::where('status_id', 5)->count();
        $universityApproval = AppProject::where('status_id', 6)->count();
        $returnedToEndUser = AppProject::where('status_id', 7)->count();
        $bacApproved = AppProject::where('status_id', 8)->count();
        $postedInPHILGEPS = AppProject::where('status_id', 9)->count();
        $bidQuotationOpened = AppProject::where('status_id', 10)->count();
        $bidEvaluated = AppProject::where('status_id', 11)->count();
        $postQualified = AppProject::where('status_id', 12)->count();
        $awarded = AppProject::where('status_id', 13)->count();
        $forImplementation = AppProject::where('status_id', 14)->count();

    
        $AppProjectCountByQuarter = AppProject::selectRaw('quarter, COUNT(*) as total')
            ->groupBy('quarter')
            ->orderBy('quarter')
            ->pluck('total', 'quarter')
            ->toArray(); 

        $AppProjectCountByMode = AppProject::join('mode_of_procurements', 'app_projects.mode_id', '=', 'mode_of_procurements.id')
            ->selectRaw('mode_of_procurements.name as mode, COUNT(*) as total')
            ->groupBy('mode')
            ->orderBy('mode')
            ->pluck('total', 'mode')
            ->toArray(); 


        $procurementData = AppProject::selectRaw('mode_id, quarter, status_id, SUM(abc) as total_amount, COUNT(*) as project_count')
            ->groupBy('mode_id', 'quarter', 'status_id')
            ->with(['modeOfProcurement', 'status'])
            ->get();

      
        return view('bacsec.dashboard', compact(
            'waitingPRSubmission', 'prSubmitted', 'certifiedAvailableFunds', 'campusApproval',
            'campusEndorsement', 'universityApproval', 'returnedToEndUser', 'bacApproved',
            'postedInPHILGEPS', 'bidQuotationOpened', 'bidEvaluated', 'postQualified',
            'awarded', 'forImplementation', 'projectCount', 'procurementData', 'AppProjectCountByQuarter', 'AppProjectCountByMode'
        ));
    }


}