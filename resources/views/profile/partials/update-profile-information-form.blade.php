<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <section class="bg-white shadow-lg rounded-3 p-4 w-100">
                <!-- Profile Header -->
                <header class="border-bottom pb-4 mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-auto mb-3 mb-md-0">
                            <img src="/{{ $user->profile_pic ?: asset('icons/image.png') }}"
                                alt="Profile picture of {{ $user->name }}"
                                class="rounded-circle border border-secondary"
                                style="width: 96px; height: 96px; object-fit: cover;">
                        </div>
                        <div class="col">
                            <h2 class="h4 text-dark">Profile Information</h2>
                            <p class="text-muted small mb-0">
                                Update your account's profile information and email address.
                            </p>
                        </div>
                    </div>
                </header>

                <!-- Verification Form -->
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <!-- Main Profile Form -->
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Verification Warning -->
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="alert alert-warning mt-4">
                            <p class="mb-2">{{ __('Your email address is unverified.') }}</p>
                            <button type="submit" form="send-verification" class="btn btn-primary btn-sm">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>

                            @if (session('status') === 'verification-link-sent')
                                <p class="text-success mt-2 small">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif

                    <!-- Form Actions -->
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <!-- Update Password Button -->
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#passwordModal">
                                <i class="fas fa-key me-2"></i>Update Password
                            </button>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-end">
                            <!-- Save Button -->
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<!-- Password Update Modal -->
<div class="modal fade" id="passwordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="passwordModalLabel">Update Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
