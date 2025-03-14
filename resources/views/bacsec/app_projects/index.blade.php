@extends('layouts.app')

@section('title', 'APP Projects')

@section('content')
<div class="container">
    <div class="d-flex mb-3">
        <input type="text" class="form-control me-2" id="titleSearch" placeholder="Search Title">
        <select class="form-select me-2" id="fundFilter">
            <option>All Fund Sources</option>
        </select>
        <select class="form-select me-2" id="quarterFilter">
            <option>All Quarters</option>
        </select>
        <select class="form-select" id="statusFilter">
            <option>All Status</option>
        </select>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>End User</th>
                <th>Category</th>
                <th>PR Number</th>
                <th>Project Title</th>
                <th>Amount</th>
                <th>Mode of Procurement</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
            <tr>
                <td>{{ $project->id }}</td>
                <td>{{ $project->end_user }}</td>
                <td>{{ $project->category }}</td>
                <td>{{ $project->pr_number }}</td>
                <td>{{ $project->project_title }}</td>
                <td>{{ number_format($project->amount, 2) }}</td>
                <td>{{ $project->mode_of_procurement }}</td>
                <td>{{ $project->status }}</td>
                <td><button class="btn btn-warning">View</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
