@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Roles</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#roleModal" id="addRoleBtn">
                <i class="bi bi-plus-lg"></i> Add Role
            </button>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                        <td class="d-flex gap-2">
                        <buttona type="button" class="text-warning me-2" title="Edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#roleModal"
                                    data-id="{{ $role->id }}"
                                    data-name="{{ $role->name }}"
                                    data-description="{{ $role->description }}">
                                    <i class="fas fa-edit"></i>
                        </button>

                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" id="deleteForm-{{ $role->id }}" action="{{ route('admin.roles.destroy', $role->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="border-0 bg-transparent text-danger me-2 delete-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal" 
                                        data-id="{{ $role->id }}" 
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

<!-- Role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="roleForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" id="roleId" name="id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Role Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Role Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Role</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Role?
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
        document.querySelectorAll(".edit-role").forEach(button => {
            button.addEventListener("click", function () {
                // Get data attributes from the clicked button
                let roleId = this.getAttribute("data-id");
                let roleName = this.getAttribute("data-name");
                let roleDescription = this.getAttribute("data-description");

                // Set modal input values
                document.getElementById("roleId").value = roleId;
                document.getElementById("name").value = roleName;
                document.getElementById("description").value = roleDescription;

                // Change modal title & form method
                document.querySelector(".modal-title").textContent = "Edit Role";
                document.getElementById("formMethod").value = "PUT"; // Use PUT method for update
                document.getElementById("roleForm").setAttribute("action", "/admin/roles/" + roleId);
            });
        });
    });
</script>

<!-- JavaScript for Delete Confirmation -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
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

