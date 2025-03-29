@extends('layouts.app')

@section('title', 'PPMP Project Status')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>PPMP Project Status</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ppmpProjectStatusModal" id="addStatusBtn">
                <i class="bi bi-plus-lg"></i> Add Status
            </button>
        </div>

        <div class="table-responsive">
        <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
    <tbody>
    @foreach($statuses->sortBy('id') as $status)

        <tr>
            <td>{{ $loop->iteration }}</td> <!-- This starts from 1 -->
            <td>{{ $status->status }}</td>
            <td>{{ $status->description }}</td>
            <td>
               <!-- Edit -->
            <buttona type="button" 
                class="text-warning me-2 editStatusBtn" 
                title="Edit"
                data-bs-toggle="modal" 
                data-bs-target="#ppmpProjectStatusModal"
                data-id="{{ $status->id }}" 
                data-status="{{ $status->status }}"
                data-description="{{ $status->description }}">
                <i class="fas fa-edit"></i>
            </button>

            <!-- Delete -->
            <form action="{{ route('admin.ppmp_project_statuses.destroy', $status->id) }}" method="POST" id="deleteForm-{{ $status->id }}" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="button" 
                    class="border-0 bg-transparent text-danger me-2 delete-btn" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteModal" 
                    data-id="{{ $status->id }}" 
                    title="Delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

        </div>
    </div>
</div>

<!-- PPMP Status Modal -->
<div class="modal fade" id="ppmpProjectStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add PPMP Project Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="ppmpProjectStatusForm" method="POST" action="{{ route('admin.ppmp_project_statuses.store') }}">
                    @csrf
                    <input type="hidden" id="status_id" name="id">

                    <div class="mb-3">
                        <label for="status_name" class="form-label">Status Name</label>
                        <input type="text" id="status_name" name="status" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="status_description" class="form-label">Description</label>
                        <input type="text" id="status_description" name="description" class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="saveStatusBtn">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let form = document.getElementById("ppmpProjectStatusForm");
        let modalTitle = document.getElementById("modalTitle");
        let statusIdInput = document.getElementById("status_id");
        let statusNameInput = document.getElementById("status_name");
        let statusDescriptionInput = document.getElementById("status_description");

        document.getElementById("addStatusBtn").addEventListener("click", function () {
            modalTitle.textContent = "Add PPMP Project Status";
            form.setAttribute("action", "{{ route('admin.ppmp_project_statuses.store') }}");
            statusIdInput.value = "";
            statusNameInput.value = "";
            statusDescriptionInput.value = "";
            form.querySelector("input[name='_method']")?.remove();
        });

        document.querySelectorAll(".editStatusBtn").forEach(button => {
            button.addEventListener("click", function () {
                modalTitle.textContent = "Edit PPMP Project Status";
                let statusId = this.getAttribute("data-id");
                let statusName = this.getAttribute("data-status");
                let statusDescription = this.getAttribute("data-description");

                statusIdInput.value = statusId;
                statusNameInput.value = statusName;
                statusDescriptionInput.value = statusDescription;

                form.setAttribute("action", `/admin/ppmp_project_statuses/${statusId}`);

                let methodInput = document.querySelector("#ppmpProjectStatusForm input[name='_method']");
                if (!methodInput) {
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "_method";
                    input.value = "PUT";
                    form.appendChild(input);
                } else {
                    methodInput.value = "PUT";
                }
            });
        });
    });
</script>
@endsection
