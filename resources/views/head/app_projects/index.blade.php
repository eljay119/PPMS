@extends('layouts.app')

@section('title', 'Assigned APP Projects')

@section('content')
    <div class="container-fluid">
        @include('toast') <!-- Optional toast for success/error messages -->

        <!-- Filters Row -->
        <div class="row mb-3">
            <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                <select class="form-select" id="yearFilter">
                    <option value="" selected>All Years</option>
                    <option>2025</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                <select class="form-select" id="fundFilter">
                    <option value="" selected>Select Fund</option>
                    @foreach ($funds as $fund)
                        <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 mb-2">
                <select class="form-select" id="statusFilter">
                    <option value="" selected>All Statuses</option>
                    <!-- Optional dynamic statuses -->
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>End User</th>
                        <th>Project Title</th>
                        <th>Amount</th>
                        <th>Source of Fund</th>
                        <th>Category</th>
                        <th>Mode of Procurement</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>{{ $project->endUser->name ?? 'N/A' }}</td>
                            <td>{{ $project->title }}</td>
                            <td>₱ {{ number_format($project->abc, 2) }}</td>
                            <td>{{ $project->sourceOfFund->name }}</td>
                            <td>{{ $project->category->name ?? 'N/A' }}</td>
                            <td>{{ $project->modeOfProcurement->name ?? 'N/A' }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $project->status->name == 'Completed' ? 'success' : ($project->status->name == 'Pending' ? 'warning' : ($project->status->name == 'On-going' ? 'info' : 'secondary')) }}">
                                    {{ $project->status->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ $project->updated_at ? $project->updated_at->format('F d, Y') : 'N/A' }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('head.app_projects.show', $project->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-warning" title="Submit PR">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-folder-open fa-2x mb-2"></i><br>
                                No projects found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($projects instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-center mt-3">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
@endsection
