@extends('layouts.app')

@section('title', 'APP')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>APP</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ppmpModal" id="addppmpBtn">
                <i class="bi bi-plus-lg"></i> Add APP
            </button>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Fiscal Year</th>
                        <th>Version Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($apps as $app)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $app->fiscal_year }}</td>
                        <td>{{ $app->version_name }}</td>
                        <td>{{ $app->appStatus->name ?? 'No Status' }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <!-- View Icon -->
                                <a href="{{ route('bacsec.app.show', $ppmp->id) }}" class="btn btn-info btn-sm mx-1">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <!-- Edit Icon -->
                                <button type="button" class="btn btn-warning btn-sm edit-ppmp mx-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#appModal"
                                    data-id="{{ $app->id }}"
                                    data-fiscal_year="{{ $app->fiscal_year }}"
                                    data-fund_source="{{ $app->version_name }}"
                                    data-status="{{ $app->app_status_id }}">
                                    <i class="bi bi-pencil-square"></i> 
                                </button>

                                <!-- Delete Icon -->
                                <form action="{{ route('bacsec.app.destroy', $ppmp->id) }}" method="POST" id="deleteForm-{{ $ppmp->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn mx-1" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal"
                                        data-id="{{ $ppmp->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection