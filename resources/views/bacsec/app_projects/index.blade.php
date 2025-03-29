@extends('layouts.app')

@section('title', 'APP Projects')

@section('content')
<div class="row mb-3 gx-2">
    <div class="col-md-2">
        <input type="text" class="form-control" id="titleSearch" placeholder="Search Title, End User">
    </div>
    <div class="col-md-2">
        <select class="form-select" id="source_filter">
            <option selected>All Fund Sources</option>
            @foreach ($sources as $source)
                <option value="{{ $source->id }}">{{ $source->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-select" id="quarterFilter">
            <option selected>All Quarters</option>
            <option value="Q1">Q1</option>
            <option value="Q2">Q2</option>
            <option value="Q3">Q3</option>
            <option value="Q4">Q4</option>
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-select" id="statusFilter">
            <option selected>All Status</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-select" id="yearFilter">
            <option>2025</option>
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-select" id="changeStatusFilter">
            <option selected>Change Status To</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 mt-2">
        <button class="btn btn-primary w-100" id="updateSelected">
            <i class="fas fa-sync-alt"></i> Update Projects
        </button>
    </div>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>End User</th>
            <th>PR Number</th>
            <th>Project Title</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Remarks</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if($projects->isEmpty())
            <tr>
                <td colspan="9" class="text-center text-muted py-3">
                    <i class="fas fa-folder-open me-2"></i> No APP projects found.
                </td>
            </tr>
        @else
            @foreach($projects as $index => $project)
            <tr>
                <td>
                    <input type="checkbox" class="form-check-input project-checkbox" value="{{ $project->id }}">
                </td>
                <td>{{ $index + 1 }}</td>
                <td>{{ $project->endUser->name ?? 'N/A' }}</td>
                <td>{{ $project->pr_number ?? 'N/A' }}</td>
                <td>{{ $project->title }}</td>
                <td>{{ number_format($project->abc, 2) }}</td>
                <td>{{ $project->status->name ?? 'N/A' }}</td>
                <td>{{ $project->remarks ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('bacsec.app_projects.show', $project->id) }}" class="text-primary me-2" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('bacsec.app_projects.edit', $project->id) }}" class="text-warning me-2" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="text-success create-pr-btn" data-id="{{ $project->id }}" title="Create PR">
                        <i class="fas fa-file-alt"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>

</table>
@endsection
