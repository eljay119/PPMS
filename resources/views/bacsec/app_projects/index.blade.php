@extends('layouts.app')
@section('title', 'APP Projects')
@section('content')
    <div class="container-fluid">
        @include('toast')
        <!-- Filters Row -->
        <div class="row mb-3">
            <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="titleSearch" placeholder="Search Title, End User" />
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                <select class="form-select" id="source_filter">
                    <option value="" selected>All Fund Sources</option>
                    @foreach ($sources as $source)
                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                <select class="form-select" id="quarterFilter">
                    <option value="" selected>All Quarters</option>
                    <option value="Q1">Q1</option>
                    <option value="Q2">Q2</option>
                    <option value="Q3">Q3</option>
                    <option value="Q4">Q4</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                <select class="form-select" id="statusFilter">
                    <option value="" selected>All Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                <select class="form-select" id="yearFilter">
                    <option value="" selected>All Years</option>
                    <option>2025</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                <select class="form-select" id="changeStatusFilter">
                    <option value="" selected>Change Status To</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Action Buttons Row -->
        <div class="row mb-3">
            <div class="col-lg-2 col-md-3 col-sm-6 mb-2">
                <button class="btn btn-primary w-100" id="updateSelected">
                    <i class="fas fa-sync-alt"></i> Update Projects
                </button>
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle" id="projectsTable">
                <thead>
                    <tr>
                        <th style="width: 5%">
                            <input type="checkbox" id="selectAll" class="form-check-input" />
                        </th>
                        <th style="width: 15%">End User</th>
                        <th style="width: 10%">Category</th>
                        <th style="width: 10%">PR Number</th>
                        <th style="width: 20%">Project Title</th>
                        <th style="width: 10%">Amount</th>
                        <th style="width: 10%">Mode of Procurement</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 15%">Remarks</th>
                        <th style="width: 10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($projects->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center text-muted py-3">
                                <i class="fas fa-folder-open me-2"></i> No APP projects found.
                            </td>
                        </tr>
                    @else
                        @foreach ($projects as $index => $project)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input project-checkbox"
                                        value="{{ $project->id }}" />
                                </td>
                                <td class="end-user">{{ $project->endUser->name ?? '' }}</td>
                                <td class="category">{{ $project->category->name ?? '' }}</td>
                                <td class="pr-number">{{ $project->pr_no ?? '' }}</td>
                                <td class="title">{{ $project->title ?? '' }}</td>
                                <td>{{ number_format($project->abc, 2) }}</td>
                                <td class="mode-of-procurement">
                                    {{ $project->modeOfProcurement->name ?? '' }}
                                </td>
                                <td class="status-cell">{{ $project->status->name ?? '' }}</td>
                                <td class="remarks">{{ $project->remarks ?? '' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('bacsec.app_projects.show', $project->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('bacsec.app_projects.edit', $project->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if (empty($project->pr_no))
                                            <a href="{{ route('bacsec.app_projects.add', $project->id) }}"
                                                class="btn btn-sm btn-outline-success create-pr-btn" title="Create PR">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @endif

                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Confirm Status Update Modal -->
    <div class="modal fade" id="confirmStatusModal" tabindex="-1" aria-labelledby="confirmStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('bacsec.app_projects.bulkUpdateStatus') }}" id="confirmStatusForm">
                @csrf
                <input type="hidden" name="status_id" id="modalStatusId">
                <div id="selectedProjectsInputs"></div>

                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="confirmStatusModalLabel">Confirm Status Update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to update the status of the selected projects?</p>

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="text" class="form-control" name="updated_at"
                                value="{{ now()->format('F d, Y h:i A') }}">
                        </div>

                        <div class="mb-3">
                            <label for="modalRemarks" class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" id="modalRemarks" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select All Functionality
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.project-checkbox');

            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
            });

            // Update Projects Button Click
            document.getElementById('updateSelected').addEventListener('click', function() {
                const selectedProjectIds = [];
                document.querySelectorAll('.project-checkbox:checked').forEach(cb => {
                    selectedProjectIds.push(cb.value);
                });

                const statusId = document.getElementById('changeStatusFilter').value;

                if (selectedProjectIds.length === 0) {
                    alert('Please select at least one project.');
                    return;
                }

                if (!statusId) {
                    alert('Please select a status to apply.');
                    return;
                }

                // Inject project IDs and status into modal form
                const container = document.getElementById('selectedProjectsInputs');
                container.innerHTML = '';
                selectedProjectIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'project_ids[]';
                    input.value = id;
                    container.appendChild(input);
                });

                document.getElementById('modalStatusId').value = statusId;

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('confirmStatusModal'));
                modal.show();
            });
        });
    </script>
@endsection
