@extends('layouts.app')

@section('title', 'Submitted APP Projects')

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
                        <i class="fas fa-folder-open me-2"></i> No Submitted APP projects found.
                    </td>
                </tr>
            @else
                @foreach($projects as $project)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $project->endUser->name ?? '' }}</td>
                    <td>{{ $project->title ?? '' }}</td>
                    <td>{{ number_format($project->abc, 2) }}</td>
                    <td>{{ $project->sourceOfFund->name ?? '' }}</td>
                    <td>{{ $project->category->name ?? '' }}</td>
                    <td>{{ $project->modeOfProcurement->name ?? '' }}</td>
                    <td>{{ $project->projectType->name ?? '' }}</td>
                    <td>{{ $project->status->name ?? '' }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#certifyModal{{ $project->id }}">Certify</button>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
     
    
        <!-- Modal -->
        <div class="modal fade" id="certifyModal{{ $project->id }}" tabindex="-1" aria-labelledby="certifyModalLabel{{ $project->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="certifyModalLabel{{ $project->id }}">Certify Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to certify the project <strong>{{ $project->title }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('budget_officer.submitted_projects.certify') }}" method="POST">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <button type="submit" class="btn btn-success">Yes, Certify</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    
    </table>
</div>
@endsection