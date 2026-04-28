<main>
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-lg-5">
            <div class="card">
                <!-- Logo -->
                <div class="card-header py-3 text-center bg-primary">
                    <a href="{{ url('/') }}">
                        <span><img src="{{ asset('assets/img/capital-sansar.svg') }}" alt="logo" height="38"></span>
                    </a>
                </div>

                <div class="card-body p-4">

                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center mt-0 fw-bold">Reset Password</h4>
                        <p class="text-muted mb-4">Enter your email address and we'll send you an email with
                            instructions to reset your password.</p>
                    </div>

                    <form wire:submit="forgotPassword">
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control" type="email" id="emailaddress" required=""
                                placeholder="Enter your email" wire:model="email">
                        </div>

                        <div class="mb-0 text-center">
                            <button wire:loading.remove class="btn btn-primary" type="submit"> Send Email </button>
                            <button wire:loading class="btn btn-primary" type="button">
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
