@extends('layouts.app')

@section('title', 'Consolidate Projects')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <a href="{{ route('bacsec.app.index') }}" class="btn btn-secondary">
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
                    @if ($app->appProjects->count() > 0)
                        <th>
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($app->appProjects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->category->name ?? 'N/A' }}</td>
                        <td>{{ $project->office->name ?? 'N/A' }}</td>
                        <td>{{ $project->end_user }}</td>
                        <td>{{ $project->sourceOfFund->name ?? 'N/A' }}</td>
                        <td>{{ $project->modeOfProcurement->name ?? 'N/A' }}</td>
                        <td>₱{{ number_format($project->abc, 2) }}</td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="selected_projects[]" value="{{ $project->id }}">
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

    <!-- Merge Button -->
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary" {{ $app->appProjects->isEmpty() ? 'disabled' : '' }}>
            Merge Selected
        </button>
    </div>
</div>

<!-- JS for Select All -->
@if ($app->appProjects->count() > 0)
<script>
    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="selected_projects[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endif
@endsection
