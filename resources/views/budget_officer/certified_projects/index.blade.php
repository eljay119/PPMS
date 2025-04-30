@extends('layouts.app')

@section('title', 'Certified APP Projects')

@section('content')
<div class="container">
    <div class="d-flex mb-3">
        <select class="form-select me-2" id="yearFilter">
            <option>2025</option>
        </select>
        <select class="form-select" id="fundFilter">
            <option>Select Fund</option>
        </select>
    </div>
    <table class="table table-bordered table-striped text-center align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>End User</th>
                <th>Project Title</th>
                <th>Amount</th>
                <th>Source of Fund</th>
                <th>Category</th>
                <th>Mode of Procurement</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @if($projects->isEmpty())
                <tr>
                    <td colspan="10" class="text-center text-muted py-3">
                        <i class="fas fa-folder-open me-2"></i> No Certified APP projects found.
                    </td>
                </tr>
            @else
                @foreach($projects as $project)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $project->endUser->name ?? '' }}</td>
                    <td>{{ $project->title ?? '' }}</td>
                    <td>{{ number_format($project->abc, 2) }}</td>
                    <td>{{ $project->sourceOfFund->name ?? 'N/A' }}</td>
                    <td>{{ $project->category->name ?? 'N/A' }}</td>
                    <td>{{ $project->modeOfProcurement->name ?? 'N/A' }}</td>
                    <td>{{ $project->type ?? 'N/A' }}</td>
                    <td>{{ $project->status->name ?? 'N/A' }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection