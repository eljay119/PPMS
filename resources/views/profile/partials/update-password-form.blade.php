<section class="bg-white shadow rounded-3 p-4">
    <header class="border-bottom pb-4 mb-5">
        <h2 class="h4 text-dark fw-bold mb-2">
            {{ __('Update Password') }}
        </h2>
        <p class="text-muted small mb-0">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="row g-3">
            <div class="col-md-6">
                <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                <input id="update_password_current_password" name="current_password" type="password"
                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                    autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                <input id="update_password_password" name="password" type="password"
                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password">
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="update_password_password_confirmation"
                    class="form-label">{{ __('Confirm Password') }}</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                    autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
        </div>

        @if (session('status') === 'password-updated')
            <div class="text-success small mt-3">
                {{ __('Saved.') }}
            </div>
        @endif
    </form>
</section>
