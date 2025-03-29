@extends('layouts.app')

@section('title', 'APP')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Annual Procurement Plan</h5>
            <div class="col-md-6">
                <input type="text" class="form-control" id="titleSearch" placeholder="Search APP">
            </div>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#appModal" id="addAppBtn">
                <i class="bi bi-plus-lg"></i> Add APP
            </button>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Fiscal Year</th>
                        <th>Version Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($apps as $app)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $app->year }}</td>
                        <td>{{ $app->version_name }}</td>
                        <td>{{ $app->appStatus->name ?? 'No Status' }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <!-- View -->
                                <a href="{{ route('bacsec.app.show', $app->id) }}" class="text-primary me-2" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit -->
                                <buttona type="button" class="text-warning me-2" title="Edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#appModal"
                                    data-id="{{ $app->id }}"
                                    data-year="{{ $app->year }}"
                                    data-version_name="{{ $app->version_name }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('bacsec.app.destroy', $app->id) }}" method="POST" id="deleteForm-{{ $app->id }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="border-0 bg-transparent text-danger me-2 delete-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal" 
                                        data-id="{{ $app->id }}" 
                                        title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- APP Modal -->
<div class="modal fade" id="appModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="appForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="id" id="appId">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add APP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Year -->
                    <div class="mb-3">
                        <label for="year" class="form-label">Fiscal Year</label>
                        <select name="year" id="year" class="form-select">
                            @for ($year = date('Y'); $year <= date('Y') + 5; $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Version Name -->
                    <div class="mb-3">
                        <label for="version_name" class="form-label">Version Name</label>
                        <input type="text" class="form-control" name="version_name" id="version_name" required>
                    </div>

                    <!-- Hidden Status -->
                    <input type="hidden" name="status_id" id="status_id" value="1">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save APP</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
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
            <div class="modal-body">Are you sure you want to delete this APP?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- JS for Modal Logic -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Add APP
        document.getElementById("addAppBtn").addEventListener("click", function () {
            document.getElementById("appForm").reset();
            document.getElementById("formMethod").value = "POST";
            document.getElementById("appForm").setAttribute("action", "{{ route('bacsec.app.store') }}");
            document.querySelector("#appModal .modal-title").textContent = "Add APP";
        });

        // Edit APP
        document.querySelectorAll(".edit-app").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.getAttribute("data-id");
                document.getElementById("appId").value = id;
                document.getElementById("year").value = this.getAttribute("data-year");
                document.getElementById("version_name").value = this.getAttribute("data-version_name");
                document.getElementById("formMethod").value = "PUT";
                document.getElementById("appForm").setAttribute("action", "/bacsec/app/" + id);
                document.querySelector("#appModal .modal-title").textContent = "Edit APP";
            });
        });

        // Delete Logic
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
