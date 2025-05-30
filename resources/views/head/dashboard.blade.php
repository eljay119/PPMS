@extends('layouts.app')

@section('title', 'Head Dashboard')

@section('page-title', '')

@section('content')
   
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Project Total by Quarter, Mode of Procurement, Status
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
