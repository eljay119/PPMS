@extends('layouts.app')

@section('title', 'Assigned APP Projects')

@section('content')
<div class="container">
    <div class="d-flex mb-3">
        <select class="form-select me-2" id="yearFilter">
            <option>2025</option>
        </select>
        <select class="form-select" id="fundFilter">
            <option selected>Select Fund</option>
            @foreach ($funds as $fund)
                <option value="{{ $fund->id }}">{{ $fund->name }}</option>
            @endforeach
        </select>
    </div>
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
            @foreach($projects as $project)
            <tr>
                <td>{{ $project->id }}</td>
                <td>{{ $project->endUser->name ?? '' }}</td>
                <td>{{ $project->title }}</td>
                <td>{{ number_format($project->abc, 2) }}</td>
                <td>{{ $project->sourceOfFund->name  }}</td>
                <td>{{ $project->category->name ?? '' }}</td>
                <td>{{ $project->modeOfProcurement->name ?? '' }}</td>
                <td>{{ $project->status->name ?? '' }}</td>
                <td>
                    <button class="btn bg-transparent text-warning border-0" title="Submit PR" >
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection