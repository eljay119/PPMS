@extends('layouts.app')

@section('title', 'Consolidate Projects')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <a href="{{ route('bacsec.app.show', $app->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    
    <h4 class="mb-4 fw-bold">Consolidate Projects</h4>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select class="form-select" name="category_filter">
                <option value="" selected>All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" name="source_filter">
                <option selected>All Sources</option>
                @foreach ($sources as $source)
                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Projects Table -->
    <form id="projectSelectionForm">
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Office</th>
                        <th>End User</th>
                        <th>Source</th>
                        <th>Mode</th>
                        <th>ABC</th>
                        @if ($ppmpProjects->count() > 0)
                            <th>
                                <input class="form-check-input" type="checkbox" id="selectAll">
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ppmpProjects as $project)
                        <tr>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->category->name ?? 'N/A' }}</td>
                            <td>{{ $project->office->name ?? 'N/A' }}</td>
                            <td>{{ $project->endUser->name ?? 'N/A' }}</td>
                            <td>{{ $project->sourceOfFund->name ?? 'N/A' }}</td>
                            <td>{{ $project->modeOfProcurement->name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($project->amount, 2) }}</td>
                            <td>
                                <input class="form-check-input project-checkbox" type="checkbox" name="selected_projects[]" value="{{ $project->id }}">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No projects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" id="mergeButton" disabled>
                Merge Selected
            </button>
        </div>
    </form>
</div>

<!-- Merge Projects Modal -->
<div class="modal fade" id="mergeModal" tabindex="-1" aria-labelledby="mergeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="mergeModalForm" method="POST" action="{{ route('bacsec.merge.projects', $app->id) }}">
                @csrf
                <input type="hidden" name="selected_projects" id="selectedProjectsInput">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="mergeModalLabel">Merge Projects</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Selected Projects</label>
                        <ul id="selectedProjectsList" class="list-group"></ul>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" id="title" name="title" class="form-control"></input>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Quarter</label>
                        <select class="form-select" name="quarter" required>
                            <option value="1">Q1</option>
                            <option value="2">Q2</option>
                            <option value="3">Q3</option>
                            <option value="4">Q4</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Total ABC</label>
                        <input type="text" id="totalABC" name="totalABC" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Category</label>
                        <select class="form-select" name="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mode of Procurement</label>
                        <select class="form-select" name="mode_id" required>
                            @foreach ($modes as $mode)
                                <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">End User</label>
                        <select class="form-select" name="end_user_id" required>
                            @foreach ($endUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm Merge</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkboxes = document.querySelectorAll('.project-checkbox');
        const mergeButton = document.getElementById("mergeButton");
        const mergeModal = new bootstrap.Modal(document.getElementById('mergeModal'));
        const selectAll = document.getElementById('selectAll');

        // Toggle merge button
        function toggleMergeButton() {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            mergeButton.disabled = !anyChecked;
        }

        checkboxes.forEach(cb => cb.addEventListener("change", toggleMergeButton));
        if (selectAll) {
            selectAll.addEventListener("change", function () {
                checkboxes.forEach(cb => cb.checked = this.checked);
                toggleMergeButton();
            });
        }

        // When Merge Selected is clicked
        mergeButton.addEventListener("click", function () {
            let selectedProjects = [];
            let totalAmount = 0;

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    const row = cb.closest("tr");
                    const title = row.cells[0].innerText;
                    const abcValue = parseFloat(row.cells[6].innerText.replace("₱", "").replace(",", "")) || 0;

                    selectedProjects.push({ id: cb.value, title });
                    totalAmount += abcValue;
                }
            });

            // Populate modal list
            const selectedProjectsList = document.getElementById("selectedProjectsList");
            selectedProjectsList.innerHTML = selectedProjects
                .map(p => `<li class="list-group-item">${p.title}</li>`)
                .join("");

            // Update hidden input with selected project IDs
            document.getElementById("selectedProjectsInput").value = JSON.stringify(selectedProjects.map(p => p.id));

            // Show total ABC
            document.getElementById("totalABC").value = "₱" + totalAmount.toLocaleString();

            // Show modal
            mergeModal.show();
        });

        // Submit modal form
        document.getElementById("mergeModalForm").addEventListener("submit", function (e) {
            // Optional: disable button on submit to prevent double clicks
            this.querySelector('button[type="submit"]').disabled = true;
        });

        // Initial check
        toggleMergeButton();
    });
</script>

@endsection
