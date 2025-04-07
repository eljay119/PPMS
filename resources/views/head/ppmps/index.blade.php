@extends('layouts.app')

@section('title', 'PPMP List')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Procurement Project Management Plan</h5>
            <div class="d-flex align-items-center gap-2">
                <!-- Search Input -->
                <input type="text" id="searchPPMP" class="form-control form-control-sm" 
                    placeholder="Search by Year or Fund Source" style="width: 200px;">
                
                <!-- Fund Source Filter -->
                <select id="source_filter" class="form-select form-select-sm" style="width: 180px;">
                    <option selected>All Fund Sources</option>
                    @foreach ($fundSources as $fundSource)
                        <option value="{{ $fundSource->id }}">{{ $fundSource->name }}</option>
                    @endforeach
                </select>

                <!-- Add PPMP Button -->
                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center" 
                        data-bs-toggle="modal" data-bs-target="#ppmpModal" id="addppmpBtn">
                    <i class="bi bi-plus-lg me-1"></i> Add PPMP
                </button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Fiscal Year</th>
                        <th>Fund Source</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ppmps as $ppmp)
                    <tr>
                        <td>{{ $ppmp->fiscal_year }}</td>
                        <td>{{ $ppmp->sourceOfFund->name ?? 'No Fund Source' }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <!-- View Icon -->
                                <a href="{{ route('head.ppmps.show', $ppmp->id) }}" class="text-primary me-2" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit Icon -->
                            <buttona type="button" 
                                class="text-warning me-2 edit-ppmp" title="Edit"
                                data-bs-toggle="modal" 
                                data-bs-target="#ppmpModal"
                                data-id="{{ $ppmp->id }}"
                                data-fiscal_year="{{ $ppmp->fiscal_year }}"
                                data-fund_source="{{ $ppmp->source_of_fund_id }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('head.ppmps.destroy', $ppmp->id) }}" method="POST" id="deleteForm-{{ $ppmp->id }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                    class="border-0 bg-transparent text-danger me-2 delete-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-id="{{ $ppmp->id }}" 
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

<!-- PPMP Modal (Add/Edit) -->
<div class="modal fade" id="ppmpModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New PPMP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="ppmpForm" method="POST" action="{{ route('head.ppmps.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" id="ppmpId" name="id">

                    <!-- Fiscal Year Dropdown -->
                    <div class="mb-3">
                        <label for="fiscal_year" class="form-label">Fiscal Year</label>
                        <select id="fiscal_year" name="fiscal_year" class="form-select">
                            @for ($year = date('Y'); $year <= date('Y') + 100; $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Fund Source Dropdown -->
                    <div class="mb-3">
                        <label for="source_of_fund_id" class="form-label">Fund Source</label>
                        <select id="source_of_fund_id" name="source_of_fund_id" class="form-select">
                            @foreach($fundSources as $fundSource)
                                <option value="{{ $fundSource->id }}">{{ $fundSource->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save PPMP</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">PPMP Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Fiscal Year:</strong> <span id="view_fiscal_year"></span></p>
                <p><strong>Fund Source:</strong> <span id="view_fund_source"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                Are you sure you want to delete this PPMP?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript for Edit & View Modals -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Add PPMP Button - Reset Form
        document.getElementById("addppmpBtn").addEventListener("click", function () {
            document.getElementById("ppmpForm").reset();
            document.getElementById("formMethod").value = "POST"; 
            document.getElementById("ppmpForm").setAttribute("action", "{{ route('head.ppmps.store') }}");
            document.querySelector(".modal-title").textContent = "Add New PPMP";
        });

        // Edit PPMP
        document.querySelectorAll(".edit-ppmp").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("ppmpId").value = this.getAttribute("data-id");
                document.getElementById("fiscal_year").value = this.getAttribute("data-fiscal_year");
                document.getElementById("source_of_fund_id").value = this.getAttribute("data-fund_source");
                document.querySelector(".modal-title").textContent = "Edit PPMP";
                document.getElementById("formMethod").value = "PUT";
                document.getElementById("ppmpForm").setAttribute("action", "/head/ppmps/" + this.getAttribute("data-id"));
            });
        });

        // View PPMP
        document.querySelectorAll(".view-ppmp").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("view_fiscal_year").textContent = this.getAttribute("data-fiscal_year");
                document.getElementById("view_fund_source").textContent = this.getAttribute("data-fund_source");
                document.getElementById("view_status").textContent = this.getAttribute("data-status");
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
