@extends('layouts.app')

@section('title', 'APP Information')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <!-- Back Button -->
            <a href="{{ route('bacsec.app.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- APP Information Card -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">APP Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Fiscal Year:</strong> {{ $app->year }}</p>
                    <p><strong>Version Name:</strong> {{ $app->version_name ?? 'Not Assigned' }}</p>
                    <p><strong>Status:</strong> {{ $app->appStatus->name ?? 'Unknown' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <!-- APP Projects Card -->
            <div class="card">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">APP Projects</h4>
                    <a href="{{ route('bacsec.app.consolidate', $app->id) }}" class="btn btn-primary float-end">Consolidate Project</a>
                </div>
                <div class="card-body">
                <table class="table table-bordered">
        <thead>
            <tr>
                <th>Project Title</th>
                <th>ABC</th>
                <th>Category</th>
                <th>Mode of Procurement</th>
                <th>Source of Fund</th>
                <th>PMO/End User</th>
            </tr>
        </thead>
            <tbody>
                {{-- App Projects --}}
                @forelse($app->appProjects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ number_format($project->abc, 2) }}</td>
                        <td>{{ $project->category->name ?? 'N/A' }}</td>
                        <td>{{ $project->modeOfProcurement->name ?? 'N/A' }}</td>
                        <td>{{ $project->sourceOfFund->name ?? 'N/A' }}</td>
                        <td>{{ $project->endUser->name ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No app projects found.</td>
                    </tr>
                @endforelse
            </tbody>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
