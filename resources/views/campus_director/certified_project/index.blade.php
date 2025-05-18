@extends('layouts.app')

@section('title', 'Certified APP Projects')

@section('content')
    <div class="container">
        <div class="d-flex mb-3">
            <select class="form-select me-2" id="yearFilter">
                <option>2025</option>
            </select>
            <select class="form-select" id="fundFilter">
                <option>Select Fund</option>
            </select>
        </div>

        @if ($projects->isEmpty())
            <div class="text-center mt-4">
                <p class="text-muted">No projects available.</p>
            </div>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>End User</th>
                        <th>Project Title</th>
                        <th>Amount</th>
                        <th>Source of Fund</th>
                        <th>Category</th>
                        <th>Mode of Procurement</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>{{ $project->endUser->name ?? '' }}</td>
                            <td>{{ $project->title }}</td>
                            <td>{{ number_format($project->abc, 2) }}</td>
                            <td>{{ $project->sourceOfFund->name ?? '' }}</td>
                            <td>{{ $project->category->name }}</td>
                            <td>{{ $project->modeOfProcurement->name ?? '' }}</td>
                            <td>{{ $project->status->name ?? '' }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#endorseModal{{ $project->id }}">Endorse</button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="endorseModal{{ $project->id }}" tabindex="-1"
                            aria-labelledby="endorseModalLabel{{ $project->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="endorseModalLabel{{ $project->id }}">Endorse Project
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to endorse the project
                                        <strong>{{ $project->title }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form method="POST"
                                            action="{{ route('campus_director.endorse', ['id' => $project->id]) }}">
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                                            <button type="submit" class="btn btn-primary">OK</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection
