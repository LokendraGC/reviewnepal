<main>
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-lg-5">
            <div class="card">
                <!-- Logo -->
                <div class="card-header py-4 text-center bg-primary">
                    <a href="{{ route('any', 'index') }}">
                        <span><img src="/images/logo.png" alt="logo" height="22"></span>
                    </a>
                </div>

                <div class="card-body p-4">

                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center mt-0 fw-bold">Reset Password</h4>
                        <p class="text-muted mb-4">Enter your email address and we'll send you an email with
                            instructions to reset your password.</p>
                    </div>

                    <form wire:submit="resetPassword">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" wire:model="password" />
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control"
                                    wire:model.live.debounce.500ms="password_confirmation" />
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                            <span class="error invalid-feedback d-block">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="mb-0 text-center">
                            <button wire:loading.remove class="btn btn-primary"> Reset Password </button>
                            <button wire:loading class="btn btn-primary">
                                <span class="spinner-border spinner-border-sm me-1" role="status"
                                    aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div> <!-- end card-body-->
            </div>
            <!-- end card -->

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted bg-body">Back to <a href="{{ route('login') }}"
                            class="text-muted ms-1 link-offset-3 text-decoration-underline"><b>Log In</b></a></p>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- end col -->
    </div>
</main>
