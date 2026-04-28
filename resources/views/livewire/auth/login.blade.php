<main>
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-lg-5">
            {{-- <figure class="text-center">
                <a href="https://sajilopatrika.com/" target="_blank">
                    <span><img src="{{ asset('images/sp.svg') }}" alt="Sajilo Patrika" height="80"></span>
                </a>
            </figure> --}}
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center pb-0 fw-bold">Hello Again!</h4>
                        <p class="text-muted mb-4">Log in with your credentials to manage the admin panel.</p>
                    </div>
                    <hr>
                    <form wire:submit="login">
                        @if (sizeof($errors) > 0)
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Username or Email Address <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="emailaddress" required=""
                                wire:model="email" />
                        </div>

                        <div class="mb-3">
                            {{-- <a href="{{ route('forgot-password') }}" class="text-muted float-end fs-12">Forgot your
                                password?</a> --}}
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" wire:model="password" />
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input wire:model="remember" type="checkbox" class="form-check-input"
                                    id="checkbox-signin" checked>
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-0 text-center">
                            <button wire:loading.remove class="btn btn-dark" type="submit"> Log in </button>
                            <button wire:loading class="btn btn-dark" type="button">
                                <span class="spinner-border spinner-border-sm me-1" role="status"
                                    aria-hidden="true"></span>
                                Authenticating
                            </button>
                        </div>

                    </form>
                </div> <!-- end card-body -->
            </div>
            <!-- end card -->

            {{-- <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted bg-body">Don't have an account? <a
                            href="{{ route('second', ['auth', 'register']) }}"
                            class="text-muted ms-1 link-offset-3 text-decoration-underline"><b>Sign Up</b></a></p>
                </div>
                <!-- end col -->
            </div> --}}
            <!-- end row -->

        </div> <!-- end col -->
    </div>
    <!-- end row -->
</main>
