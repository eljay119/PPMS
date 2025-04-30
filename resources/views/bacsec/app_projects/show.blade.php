@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">PR No.: {{ $appProject->pr_number ?? '' }}</h3>
    <table class="table table-bordered">
        <tr>
            <th>ABC</th>
            <td>{{ number_format($appProject->abc, 2) }}</td>
            <th>Quarter</th>
            <td>{{ $project->quarter ?? '' }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $appProject->category->name ?? '' }}</td>
            <th>Mode of Procurement</th>
            <td>{{ $appProject->modeOfProcurement->name ?? '' }}</td>
        </tr>
        <tr>
            <th>Fund Source</th>
            <td>{{ $appProject->sourceOfFund->name ?? '' }}</td>
            <th>Status</th>
            <td>{{ $appProject->status->name ?? '' }}</td>
        </tr>
        <tr>
            <th>End User</th>
            <td>{{ $appProject->endUser->name ?? '' }}</td>
            <th>Remarks</th>
            <td>{{ $appProject->remarks ?? '' }}</td>
        </tr>
        <tr>
            <th>PhilGeps Publication Date From</th>
            <td>{{ $appProject->philgeps_publication_date_from ?? '' }}</td>
            <th>PhilGeps Publication Date To</th>
            <td>{{ $appProject->philgeps_publication_date_to ?? '' }}</td>
        </tr>
        <tr>
            <th>Approval Date</th>
            <td>{{ $appProject->approval_date ?? '' }}</td>
            <th>Opening Date</th>
            <td>{{ $appProject->opening_date ?? '' }}</td>
        </tr>
        <tr>
            <th>Notice to Proceed Date</th>
            <td>{{ $appProject->notice_to_proceed_date ?? '' }}</td>
            <th>Supplier</th>
            <td>{{ $appProject->supplier ?? '' }}</td>
        </tr>
    </table>
    <a href="{{ route('bacsec.app_projects.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection