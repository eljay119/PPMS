@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Profile Header Card -->
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="card-header bg-primary text-white p-4 border-0">
                            <div class="d-flex align-items-center">
                                <div class="position-relative me-4">
                                    <img src="/{{ $user->profile_pic ?: asset('icons/image.png') }}"
                                        alt="Profile picture of {{ $user->name }}"
                                        class="rounded-circle border-3 border-white"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                    <button
                                        class="btn btn-sm btn-light rounded-circle position-absolute bottom-0 end-0 shadow-sm"
                                        data-bs-toggle="tooltip" title="Change profile picture">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                                <div>
                                    <h1 class="h3 mb-0">{{ $user->name }}</h1>
                                    <p class="mb-0 text-white-50">
                                        <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Content -->
                    <div class="row g-4">
                        <!-- Left Sidebar -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-bold mb-4">
                                        <i class="fas fa-user-circle me-2 text-primary"></i>Account
                                    </h5>
                                    <div class="nav flex-column nav-pills">
                                        <a href="#" class="nav-link active mb-2 d-flex align-items-center">
                                            <i class="fas fa-id-card me-3"></i>
                                            <span>Profile Information</span>
                                        </a>
                                        <a href="#" class="nav-link mb-2 d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#passwordModal">
                                            <i class="fas fa-key me-3"></i>
                                            <span>Password</span>
                                        </a>
                                        <a href="#" class="nav-link mb-2 d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#notificationModal">
                                            <i class="fas fa-bell me-3"></i>
                                            <span>Notifications</span>
                                        </a>
                                    </div>

                                    <hr class="my-4">

                                    <h5 class="card-title fw-bold mb-4">
                                        <i class="fas fa-cog me-2 text-primary"></i>Settings
                                    </h5>
                                    <div class="nav flex-column nav-pills">
                                        <a href="#" class="nav-link mb-2 d-flex align-items-center">
                                            <i class="fas fa-palette me-3"></i>
                                            <span>Appearance</span>
                                        </a>
                                        <a href="#" class="nav-link mb-2 d-flex align-items-center">
                                            <i class="fas fa-globe me-3"></i>
                                            <span>Language</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Content Area -->
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body p-4">
                                    <h5 class="card-title d-flex align-items-center mb-4">
                                        <i class="fas fa-id-card me-2 text-primary"></i>
                                        <span>Profile Information</span>
                                    </h5>

                                    <p class="text-muted mb-4">
                                        Update your account's profile information and email address.
                                    </p>

                                    <!-- Verification Form -->
                                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                        @csrf
                                    </form>

                                    <!-- Email Verification Warning -->
                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                        <div class="alert alert-warning d-flex align-items-center rounded-3 mb-4">
                                            <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                                            <div>
                                                <p class="mb-2">{{ __('Your email address is unverified.') }}</p>
                                                <button type="submit" form="send-verification"
                                                    class="btn btn-primary btn-sm">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>

                                                @if (session('status') === 'verification-link-sent')
                                                    <div class="text-success mt-2 small">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        {{ __('A new verification link has been sent to your email address.') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Main Profile Form -->
                                    <form method="post" action="{{ route('profile.update') }}">
                                        @csrf
                                        @method('patch')

                                        <div class="row g-3 mb-4">
                                            <div class="col-md-6">
                                                <label for="name"
                                                    class="form-label fw-medium">{{ __('Name') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fas fa-user text-primary"></i>
                                                    </span>
                                                    <input type="text" id="name" name="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name', $user->name) }}" required autofocus
                                                        autocomplete="name">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="email"
                                                    class="form-label fw-medium">{{ __('Email') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fas fa-envelope text-primary"></i>
                                                    </span>
                                                    <input type="email" id="email" name="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('email', $user->email) }}" required
                                                        autocomplete="username">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="username"
                                                    class="form-label fw-medium">{{ __('Username') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fas fa-at text-primary"></i>
                                                    </span>
                                                    <input type="text" id="username" name="username"
                                                        class="form-control @error('username') is-invalid @enderror"
                                                        value="{{ old('username', $user->username ?? '') }}"
                                                        autocomplete="username">
                                                    @error('username')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="phone"
                                                    class="form-label fw-medium">{{ __('Phone') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fas fa-phone text-primary"></i>
                                                    </span>
                                                    <input type="tel" id="phone" name="phone"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        value="{{ old('phone', $user->phone ?? '') }}"
                                                        autocomplete="tel">
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fas fa-save me-2"></i>Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Update Modal -->
    <div class="modal fade" id="passwordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title" id="passwordModalLabel">
                        <i class="fas fa-key me-2"></i>Update Password
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                    <h5 class="modal-title" id="notificationModalLabel">
                        <i class="fas fa-bell me-2"></i> Notifications
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action mb-2 rounded shadow-sm">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-primary">Project "IT Equipment" status updated to Certified</h6>
                                <small class="text-muted">2 minutes ago</small>
                            </div>
                            <p class="mb-0 text-secondary small">Click to view more details.</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action mb-2 rounded shadow-sm">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-primary">Project "Research Equipment" status updated to Approved</h6>
                                <small class="text-muted">1 hour ago</small>
                            </div>
                            <p class="mb-0 text-secondary small">Click to view more details.</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action mb-2 rounded shadow-sm">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-primary">Project "Library Computers" status updated to Pending</h6>
                                <small class="text-muted">Yesterday</small>
                            </div>
                            <p class="mb-0 text-secondary small">Click to view more details.</p>
                        </a>
                    </div>

                    <!-- If no notifications -->
                    <!--
                    <div class="text-center mt-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No new notifications</h6>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endpush
