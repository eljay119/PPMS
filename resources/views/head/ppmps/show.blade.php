@extends('layouts.app')

@section('title', 'PPMP Information')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <!-- Back Button -->
            <a href="{{ route('head.ppmps.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- PPMP Information Card -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">PPMP Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Fiscal Year:</strong> {{ $ppmp->fiscal_year }}</p>
                    <p><strong>Office:</strong> {{ $ppmp->office->name ?? 'Not Assigned' }}</p>
                    <p><strong>Source of Fund:</strong> {{ $ppmp->sourceOfFund->name ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ $ppmp->ppmpStatus->name ?? 'Pending' }}</p>
                    <a href="#" class="btn btn-success">Finalize</a>
                    <a href="#" class="btn btn-purple">Import Excel</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <!-- PPMP Projects Card -->
            <div class="card">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">PPMP Projects</h4>
                    <a href="#" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addProjectModal">Add Project</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Project Title</th>
                                <th>Amount</th>
                                <th>Category</th>
                                <th>Mode of Procurement</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>APP Project</th>
                                <th>PMO/End User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($ppmp->ppmpProjects as $project)
                            <tr>
                                <td>{{ $project->title }}</td>
                                <td>{{ number_format($project->amount, 2) }}</td>
                                <td>{{ $project->category->name ?? 'N/A' }}</td>
                                <td>{{ $project->modeOfProcurement->name ?? 'N/A' }}</td>
                                <td>{{ $project->type->name ?? 'N/A' }}</td>
                                <td>{{ $project->status->name ?? 'N/A' }}</td>
                                <td>{{ $project->appProject->name ?? 'N/A' }}</td>
                                <td>{{ $project->pmo_end_user ?? 'N/A' }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning">Edit</a>
                                    <a href="#" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">No projects found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Project Modal -->
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Add PPMP Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('head.ppmp_projects.store') }}" method="POST">
                @csrf
                <input type="hidden" name="ppmp_id" value="{{ $ppmp->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Project Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mode_of_procurement" class="form-label">Mode of Procurement</label>
                        <select class="form-select" id="mode_of_procurement" name="mode_of_procurement_id" required>
                            @foreach($modes as $mode)
                                <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="project_type" class="form-label">Type</label>
                        <select class="form-select" id="project_type" name="type_id" required>
                            @foreach($projectTypes as $projectType) 
                                <option value="{{ $projectType->id }}" 
                                    {{ $ppmp->type_id == $projectType->id ? 'selected' : '' }}>
                                    {{ $projectType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status_id" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
