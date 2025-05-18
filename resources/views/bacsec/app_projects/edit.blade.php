@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
    <div class="container mt-4">
        <h1>Edit Project</h1>

        <form action="{{ route('bacsec.app_projects.saveEdit', $project->id) }}" method="POST">
            @csrf

            <!-- User Dropdown -->
            <div class="mb-3">
                <label for="user_id" class="form-label">Select User</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="" disabled {{ old('user_id', $project->end_user_id) ? '' : 'selected' }}>Select User
                    </option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('user_id', $project->end_user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Final ABC Input -->
            <div class="mb-3">
                <label for="final_abc" class="form-label">Final ABC</label>
                <input type="number" step="0.01" class="form-control" id="final_abc" name="final_abc"
                    value="{{ old('final_abc') }}">
            </div>

            <!-- Remarks Input -->
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
@endsection
