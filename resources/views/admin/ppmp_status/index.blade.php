@extends('layouts.app')

@section('title', 'PPMP Status')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>PPMP Status</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ppmpStatusModal" id="addppmpStatusBtn">
                <i class="bi bi-plus-lg"></i> Add Status
            </button>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statuses as $status)
                    <tr>
                        <td>{{ $status->id }}</td>
                        <td>{{ $status->name }}</td>
                        <td class="d-flex gap-2">
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm edit-status" data-bs-toggle="modal" data-bs-target="#ppmpStatusModal"
                                data-id="{{ $status->id }}" 
                                data-name="{{ $status->name }}">
                                <i class="bi bi-pencil-square"></i> 
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.ppmp_status.destroy', $status->id) }}" method="POST" id="deleteForm-{{ $status->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal"
                                    data-id="{{ $status->id }}">
                                    <i class="bi bi-trash"></i>
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
<div class="modal fade" id="ppmpStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="ppmpStatusForm" method="POST">
                    @csrf
                    <input type="hidden" id="statusId" name="id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Status Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Status</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this PPMP Status?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-status").forEach(button => {
            button.addEventListener("click", function () {
                let statusId = this.getAttribute("data-id");
                let statusName = this.getAttribute("data-name");

                document.getElementById("statusId").value = statusId;
                document.getElementById("name").value = statusName;

                document.querySelector(".modal-title").textContent = "Edit Status";

                let form = document.getElementById("ppmpStatusForm");
                form.setAttribute("action", "/admin/ppmp-statuses/" + statusId);
                form.insertAdjacentHTML("beforeend", '<input type="hidden" name="_method" value="PUT">');
            });
        });

        // Handle Delete
        let deleteId = null;
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                deleteId = this.getAttribute("data-id");
            });
        });

        document.getElementById("confirmDelete").addEventListener("click", function () {
            if (deleteId) {
                document.getElementById("deleteForm-" + deleteId).submit();
            }
        });
    });
</script>

@endsection
