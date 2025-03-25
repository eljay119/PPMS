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
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProjectModal{{ $project->id }}">Edit</button>

                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProjectModal{{ $project->id }}">Delete</button>

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
            <form method="POST" action="{{ route('head.ppmp_projects.store') }}">


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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>
            </form>
        </div>
    </div>
</div> 

<!-- Edit & Delete Modals per Project -->
@foreach($ppmp->ppmpProjects as $project)
    <!-- Edit Modal -->
    <div class="modal fade" id="editProjectModal{{ $project->id }}" tabindex="-1" aria-labelledby="editProjectModalLabel{{ $project->id }}" aria-hidden="true">
        <div class="modal-dialog">
           <form action="{{ route('head.ppmp_projects.update', $project->id) }}" method="POST" class="modal-content">
    @csrf
    @method('PUT')
                <input type="hidden" name="ppmp_id" value="{{ $ppmp->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProjectModalLabel{{ $project->id }}">Edit PPMP Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Same inputs as Add Project, pre-filled -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Project Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $project->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount" value="{{ $project->amount }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $project->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mode_of_procurement_id" class="form-label">Mode of Procurement</label>
                        <select class="form-select" name="mode_of_procurement_id" required>
                            @foreach($modes as $mode)
                                <option value="{{ $mode->id }}" {{ $project->mode_of_procurement_id == $mode->id ? 'selected' : '' }}>
                                    {{ $mode->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="type_id" class="form-label">Type</label>
                        <select class="form-select" name="type_id" required>
                            @foreach($projectTypes as $type)
                                <option value="{{ $type->id }}" {{ $project->type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status_id" class="form-label">Status</label>
                        <select class="form-select" name="status_id" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ $project->status_id == $status->id ? 'selected' : '' }}>
                                    {{ $status->status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteProjectModal{{ $project->id }}" tabindex="-1" aria-labelledby="deleteProjectModalLabel{{ $project->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('head.ppmp_projects.destroy', $project->id) }}" method="POST" class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong>{{ $project->title }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

@endsection
<script>
    $('.editProjectBtn').on('click', function() {
    let projectId = $(this).data('id');

    $.ajax({
        url: `/head/ppmp_projects/${projectId}/edit`,
        method: 'GET',
        success: function(response) {
            $('#editProjectModal #title').val(response.project.title);
            $('#editProjectModal #amount').val(response.project.amount);
            $('#editProjectModal #remarks').val(response.project.remarks);
            // Fill in dropdowns
            $('#editProjectModal #category_id').val(response.project.category_id);
            $('#editProjectModal #mode_of_procurement_id').val(response.project.mode_of_procurement_id);
            $('#editProjectModal #status_id').val(response.project.status_id);
            $('#editProjectModal #type_id').val(response.project.type_id);
            $('#editProjectModal #app_project_id').val(response.project.app_project_id);

            // Open the modal
            $('#editProjectModal').modal('show');
        }
    });
});

</script>