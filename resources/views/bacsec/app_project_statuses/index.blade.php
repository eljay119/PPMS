@extends('layouts.app')

@section('title', 'Project Status')

@section('content')
<div class="row mb-3">
    <div class="col-md-2">
        <input type="text" class="form-control" id="titleSearch" placeholder="Search Title">
    </div>
    <div class="col-md-2">
        <select class="form-select" id="fundFilter">
            <option>All Fund Sources</option>
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-select" id="quarterFilter">
            <option>All Quarters</option>
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-select" id="statusFilter">
            <option>All Status</option>
        </select>
    </div>
    <div class="col-md-2">
        <select class="form-select" id="changeStatusFilter">
            <option>Change Status To</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100" id="updateSelected">
            <i class="fas fa-sync-alt"></i> Update Projects
        </button>
    </div>
</div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
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
            @foreach($statuses as $status)
            <tr>
                <td><input type="checkbox" class="project-checkbox" value="{{ $status->id }}"></td>
                <td>{{ $status->id }}</td>
                <td>{{ $status->end_user }}</td>
                <td>{{ $status->pr_number }}</td>
                <td>{{ $status->project_title }}</td>
                <td>{{ number_format($status->amount, 2) }}</td>
                <td>{{ $status->status }}</td>
                <td>{{ $status->remarks }}</td>
                <td>
                   
                    <a href="{{ route('bacsec.app_project_statuses.show', $status->id) }}" class="text-primary me-2" title="View">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('bacsec.app_project_statuses.edit', $status->id) }}" class="text-warning me-2" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="text-success create-pr-btn" data-id="{{ $status->id }}" title="Create PR">
                        <i class="fas fa-file-alt"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection
