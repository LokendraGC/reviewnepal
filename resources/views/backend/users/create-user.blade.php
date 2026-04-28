@extends('layouts.vertical', ['page_title' => 'Add New User', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box py-3 d-flex justify-content-start align-content-center  gap-2">
                    <div class="align-self-center">
                        <h4 class="page-title" style="line-height: unset;">Add New User</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Create a brand new user and add them to this site.</h4>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show"
                                role="alert">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <strong>Error - </strong> {{ $errors->first() }}
                            </div>
                        @endif


                        <form action="{{ route('backend.user.store') }}" method="POST">
                            @csrf
                            <div class="mb-2 row">
                                <label for="email" class="col-sm-2 col-form-label">Email<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-5">
                                    <input type="email" class="form-control" id="email" name="email" />
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="name" class="col-sm-2 col-form-label col-form-label-sm">Full Name<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control form-control-md" id="name"
                                        name="name" />
                                </div>
                            </div>
                            {{-- <div class="mb-2 row">
                                <label for="phone" class="col-sm-2 col-form-label col-form-label-sm">Phone Number<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control form-control-md" id="phone"
                                        name="phone" />
                                </div>
                            </div> --}}
                            <div class="mb-2 row">
                                <label for="password" class="col-sm-2 col-form-label">Password<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-5">
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password" />
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="mb-2 row">
                                <label for="send_email" class="col-sm-2 col-form-label">Send User Notification</label>
                                <div class="col-sm-5">
                                    <div class="form-check form-check-inline mt-1">
                                        <input type="checkbox" class="form-check-input" id="send" name="send_email" />
                                        <label class="form-check-label" for="send">Send the new user an email about
                                            their account.</label>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="mb-2 row">
                                <label for="colFormLabel" class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-5" style="max-width: max-content;">
                                    <select class="form-select" id="example-select" name="roles[]" required>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}">{{ $role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="mt-2 btn btn-outline-primary">Add New User</button>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
    </div>
@endsection
