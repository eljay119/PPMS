@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Project Details</h4>
                <span class="badge bg-light text-dark">PR No.: {{ $appProject->pr_no ?? '' }}</span>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12 mb-3">
                        <div class="alert alert-info">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0">ABC Amount:</h5>
                                <h5 class="mb-0 fw-bold">₱ {{ number_format($appProject->abc, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <!-- Project Information -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Project Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th width="40%">Quarter</th>
                                            <td>{{ $appProject->quarter ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $appProject->category->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mode of Procurement</th>
                                            <td>{{ $appProject->modeOfProcurement->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Fund Source</th>
                                            <td>{{ $appProject->sourceOfFund->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>End User</th>
                                            <td>{{ $appProject->endUser->name ?? '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Project Status -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Status Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Current Status:</h6>
                                    <span
                                        class="badge bg-success px-3 py-2">{{ $appProject->status->name ?? 'Pending' }}</span>
                                </div>

                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <th width="40%">Supplier</th>
                                            <td>{{ $appProject->supplier ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Remarks</th>
                                            <td>{{ $appProject->remarks ?? '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Information -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Timeline Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card h-100 border-light">
                                            <div class="card-body">
                                                <h6 class="card-title text-muted">Publication Period</h6>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <div class="text-center">
                                                        <span class="text-muted small">From</span>
                                                        <p class="mb-0 mt-1 fw-bold">
                                                            {{ $appProject->philgeps_publication_date_from ?? '' }}</p>
                                                    </div>
                                                    <i class="bi bi-arrow-right"></i>
                                                    <div class="text-center">
                                                        <span class="text-muted small">To</span>
                                                        <p class="mb-0 mt-1 fw-bold">
                                                            {{ $appProject->philgeps_publication_date_to ?? '' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100 border-light">
                                            <div class="card-body">
                                                <h6 class="card-title text-muted">Key Dates</h6>
                                                <ul class="list-group list-group-flush mt-2">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>Approval Date:</span>
                                                        <span class="fw-bold">{{ $appProject->approval_date ?? '' }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>Opening Date:</span>
                                                        <span class="fw-bold">{{ $appProject->opening_date ?? '' }}</span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>Notice to Proceed Date:</span>
                                                        <span
                                                            class="fw-bold">{{ $appProject->notice_to_proceed_date ?? '' }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>

                <div class="float-end">
                    <a href="#" class="btn btn-outline-primary me-2">
                        <i class="bi bi-printer"></i> Print
                    </a>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#statusHistoryModal">
                        <i class="bi bi-clock-history"></i> Update History
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update History Modal -->
    <div class="modal fade" id="statusHistoryModal" tabindex="-1" aria-labelledby="statusHistoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="statusHistoryModalLabel">Update History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($appProject->statusHistories->isEmpty())
                        <p class="text-muted">No status update history available.</p>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Updated By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appProject->statusHistories->sortByDesc('created_at') as $history)
                                    <tr>
                                        <td>{{ $history->created_at->format('F d, Y h:i A') }}</td>
                                        <td>{{ $history->status->name ?? '' }}</td>
                                        <td>{{ $history->remarks ?? 'No remarks' }}</td>
                                        <td>{{ $history->user->name ?? 'Unknown' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
