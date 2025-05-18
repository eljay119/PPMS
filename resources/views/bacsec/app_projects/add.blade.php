@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
    <div class="container mt-4">
        <h1>Add PR Number</h1>

        <form action="{{ route('bacsec.app_projects.savePr', $project->id) }}" method="POST">
            @csrf
            @php
                $today = \Carbon\Carbon::now()->format('Y-md'); // corrected to Ymd for proper format
                $generatedPrNumber = $today . $project->id;
            @endphp

            <div class="mb-3">
                <label for="pr_number" class="form-label">PR Number</label>
                <input type="text" class="form-control" id="pr_number" name="pr_number" value="{{ $generatedPrNumber }}"
                    readonly>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
