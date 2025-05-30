@extends('layouts.app')

@section('title', 'BAC Sec Dashboard')

@section('page-title', '')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Total Projects - {{ $projectCount }}</h5>
                    </div>
                    <i class="fas fa-folder fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Posted in PhilGeps - {{ $postedInPHILGEPS }}</h5>
                    </div>
                    <i class="fas fa-globe fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Bid Evaluation - {{ $bidEvaluated }}</h5>
                    </div>
                    <i class="fas fa-balance-scale fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary text-white mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Awarded - {{ $awarded }}</h5>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Bids/Quotation Opening - {{ $bidQuotationOpened }}</h5>
                    </div>
                    <i class="fas fa-envelope-open-text fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-teal text-white mb-4" style="background-color: #20c997 !important;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Post Qualification - {{ $postQualified }}</h5>
                    </div>
                    <i class="fas fa-user-check fa-2x opacity-75"></i>
                </div>
            </div>
        </div>

    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Procurement Data by Mode & Quarter
            </div>
            <a href="{{ route('bacsec.generateReport') }}" class="btn btn-sm btn-primary"
                style="font-weight: bold; font-size: 14px; text-transform: uppercase;">
                <i class="fas fa-file-export"></i> Download
            </a>
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
                <tbody>
                    @foreach ($procurementData as $data)
                        <tr>
                            <td>{{ $data->modeOfProcurement->name ?? '' }}</td>
                            <td>{{ $data->quarter ?? '' }}</td>
                            <td>{{ $data->status->name ?? '' }}</td>
                            <td>{{ number_format($data->total_amount, 2) }}</td>
                            <td>{{ $data->project_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>

    <script>
        // Data for Project Total by Quarter
        const projectByQuarterLabels = @json(array_keys($AppProjectCountByQuarter));
        const projectByQuarterData = @json(array_values($AppProjectCountByQuarter));

        const ctxQuarter = document.getElementById('myAreaChart').getContext('2d');
        new Chart(ctxQuarter, {
            type: 'line',
            data: {
                labels: projectByQuarterLabels,
                datasets: [{
                    label: 'Projects by Quarter',
                    data: projectByQuarterData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });

        // Data for Project Total by Mode of Procurement
        const projectByModeLabels = @json(array_keys($AppProjectCountByMode));
        const projectByModeData = @json(array_values($AppProjectCountByMode));

        const ctxMode = document.getElementById('myBarChart').getContext('2d');
        new Chart(ctxMode, {
            type: 'bar',
            data: {
                labels: projectByModeLabels,
                datasets: [{
                    label: 'Projects by Mode',
                    data: projectByModeData,
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
@endsection
