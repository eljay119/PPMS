@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Users</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userModal" id="addUserBtn">
                <i class="bi bi-plus-lg"></i> Add User
            </button>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ optional($user->role)->name ?? 'No Role' }}</td>
                        <td class="d-flex gap-2">
                        <button type="button" class="btn btn-warning btn-sm edit-user" 
                            data-bs-toggle="modal" data-bs-target="#userModal" 
                            data-user='@json($user)'>
                            <i class="bi bi-pencil-square"></i> 
                        </button>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" id="deleteForm-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal"
                                    data-id="{{ $user->id }}">
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

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" id="userId" name="id">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select id="role_id" name="role" class="form-select" required>
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save User</button>
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
                Are you sure you want to delete this User?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    const userForm = document.getElementById("userForm");
    const formMethod = document.getElementById("formMethod");
    const userId = document.getElementById("userId");
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const usernameInput = document.getElementById("username");
    const roleInput = document.getElementById("role_id");

    document.querySelectorAll(".edit-user").forEach(button => {
        button.addEventListener("click", function() {
            const user = JSON.parse(this.getAttribute("data-user"));

          
            document.querySelector(".modal-title").innerText = "Edit User";

            
            formMethod.value = "PUT";
            userForm.action = `/admin/users/${user.id}`; 

            
            userId.value = user.id;
            nameInput.value = user.name;
            emailInput.value = user.email;
            usernameInput.value = user.username;
            roleInput.value = user.role_id;

           
            Array.from(roleInput.options).forEach(option => {
                option.selected = option.value == user.role_id;
            });
        });
    });
});
</script>


<!-- JavaScript for Delete Confirmation -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let deleteId = null;

        // When the delete button is clicked, store the user ID
        document.querySelectorAll(".btn-danger[data-bs-target='#deleteModal']").forEach(button => {
            button.addEventListener("click", function () {
                deleteId = this.getAttribute("data-id");
            });
        });

        // When the confirm delete button is clicked, submit the correct form
        document.getElementById("confirmDelete").addEventListener("click", function () {
            if (deleteId) {
                document.getElementById("deleteForm-" + deleteId).submit();
            }
        });
    });
</script>



@endsection
