@extends('layouts.app')

@section('title', 'Offices')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Offices</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#officeModal" id="addOfficeBtn">
                <i class="bi bi-plus-lg"></i> Add Office
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Head Name</th>
                        <th>Alternate Name</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offices as $office)
                    <tr>
                        <td>{{ $office->id }}</td>
                        <td>{{ $office->name }}</td>
                        <td>{{ $office->user->name ?? 'N/A' }}</td>
                        <td>{{ $office->alternate_name ?? 'N/A' }}</td>
                        <td>{{ $office->type->type ?? 'No Type' }}</td>
                        <td class="d-flex gap-2">
                            <button type="button" class="btn btn-warning btn-sm edit-office" 
                                data-bs-toggle="modal" data-bs-target="#editOfficeModal"
                                data-id="{{ $office->id }}"
                                data-name="{{ $office->name }}"
                                data-user_id="{{ $office->user_id }}"
                                data-alternate_name="{{ $office->alternate_name }}"
                                data-office_type_id="{{ $office->type->id ?? '' }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="{{ $office->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Office Modal -->
<div class="modal fade" id="addOfficeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Office</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addOfficeForm" method="POST" action="{{ route('admin.offices.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="add_name" class="form-label">Office Name</label>
                        <input type="text" id="add_name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_user_id" class="form-label">Head Name</label>
                        <select id="add_user_id" name="user_id" class="form-select" required>
                            <option value="">Select Head</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="add_alternate_name" class="form-label">Alternate Name</label>
                        <input type="text" id="add_alternate_name" name="alternate_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="add_type" class="form-label">Type</label>
                        <select id="add_type" name="office_type_id" class="form-select" required>
                            <option value="">Select Type</option>
                            @foreach($officeTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Office</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Office Modal -->
<div class="modal fade" id="editOfficeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Office</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editOfficeForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_officeId" name="id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Office Name</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_user_id" class="form-label">Head Name</label>
                        <select id="edit_user_id" name="user_id" class="form-select" required>
                            <option value="">Select Head</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_alternate_name" class="form-label">Alternate Name</label>
                        <input type="text" id="edit_alternate_name" name="alternate_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">Type</label>
                        <select id="edit_type" name="type_id" class="form-select" required>
    <option value="">Select Type</option>
    @foreach($officeTypes as $type)
        <option value="{{ $type->id }}">{{ $type->type }}</option>
    @endforeach
</select>



                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update Office</button>
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
                <p>Are you sure you want to delete this Office?</p>
                <strong id="deleteOfficeName"></strong>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-office").forEach(button => {
    button.addEventListener("click", function () {
        // Set form action URL
        document.getElementById("editOfficeForm").setAttribute("action", `/admin/offices/${this.dataset.id}`);

        // Assign input values
        document.getElementById("edit_officeId").value = this.dataset.id;
        document.getElementById("edit_name").value = this.dataset.name;
        document.getElementById("edit_user_id").value = this.dataset.user_id;
        document.getElementById("edit_alternate_name").value = this.dataset.alternate_name;

        // Fix: Set selected option for Type
        let officeTypeSelect = document.getElementById("edit_type");
        let selectedTypeId = this.dataset.office_type_id; // Make sure this value is correctly retrieved

        if (selectedTypeId) {
            officeTypeSelect.value = selectedTypeId;
        }
    });

    });

    // Handle Delete Modal
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            let officeId = this.dataset.id;
            document.getElementById("deleteForm").setAttribute("action", `/admin/offices/${officeId}`);
        });
    });
});
</script>

@endsection
