@extends('layouts.app')

@section('title', 'Head Dashboard')

@section('page-title', '')

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">Total Submitted Projects</h5></div>
                <i class="fas fa-folder fa-2x opacity-75"></i>
            </div>
        </div>
    </div> 
    <div class="col-xl-3 col-md-6">
        <div class="card bg-info text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">Approved APPs</h5></div>
                <i class="fas fa-check-circle fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">Returned APPs</h5></div>
                <i class="fas fa-arrow-left fa-2x opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-teal text-white mb-4" style="background-color: #20c997 !important;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><h5 class="mb-1">APPs Pending Evaluation</h5></div>
                <i class="fas fa-tasks fa-2x opacity-75"></i>
            </div>
        </div>
    </div>   

    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Area Chart Example
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Bar Chart Example
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Project Title</th>
                        <th>Status</th>
                    </tr>
                </thead>
              
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
@endsection
