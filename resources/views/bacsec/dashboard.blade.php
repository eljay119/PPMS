@extends('layouts.app')

@section('title', 'Bac Sec Dashboard')

@section('page-title', '')

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">Total Projects</h5></div>
                <i class="fas fa-folder fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-info text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">Posted in PhilGeps</h5></div>
                <i class="fas fa-globe fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">Bid Evaluation</h5></div>
                <i class="fas fa-balance-scale fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">Awarded</h5></div>
                <i class="fas fa-check-circle fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">Lacking Documents</h5></div>
                <i class="fas fa-file-alt fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-dark text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">For Preprocurement</h5></div>
                <i class="fas fa-clipboard-list fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">Bids/Quotation Opening</h5></div>
                <i class="fas fa-envelope-open-text fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-teal text-white mb-4" style="background-color: #20c997 !important;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">Post Qualification</h5></div>
                <i class="fas fa-user-check fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
       
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Project Cost Trend (Monthly)
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Monthly Project Count
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Procurement Data by Mode & Quarter
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Mode of Procurement</th>
                        <th>Quarter</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th>Project Count</th>
                    </tr>
                </thead>
             
                                         
            </table>
        </div>
    </div>
</div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
@endsection
