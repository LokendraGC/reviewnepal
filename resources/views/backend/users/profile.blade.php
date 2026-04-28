@extends('layouts.vertical', ['page_title' => 'Profile', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Profile</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">

            <div class="col-xl-12 col-lg-7">

                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('backend.user.profile.store', $id) }}">
                            @csrf
                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="ri-contacts-book-2-line me-1"></i>
                                Personal Info</h5>
                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username"
                                            value="{{ $user->username }}" required readonly disabled />
                                        <span class="form-text text-muted"><small>Username cannot be
                                                changed.</small></span>
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}" />
                                        @error('name')
                                            <div class="valid-feedback d-block ">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Email Address<span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="useremail" placeholder="Enter email"
                                            name="email" value="{{ $user->email }}" required />
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $user->phone }}" />
                                    </div>
                                </div> --}}
                            </div>

                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="ri-shield-keyhole-fill me-1"></i>Account
                                Management</h5>
                            <div class="row">
                                @role(['Super Admin|Admin'])
                                    @if (auth()->user()->id != $id && $id != null)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="example-select" class="form-label">Role</label>
                                                <select class="form-select" id="example-select" name="roles[]" required>
                                                    <option value="">Select Role</option>
                                                    @foreach ($roles as $role)
                                                        <option {{ in_array($role, $userRoles) ? 'selected' : '' }}
                                                            value="{{ $role }}">
                                                            {{ $role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endrole
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="new_password" name="password" class="form-control"
                                                placeholder="Enter your password">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                        <span class="form-text text-muted"><small>Leave empty to keep the
                                                same</small></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-start">
                                <button type="submit" class="btn btn-primary mt-2 btn-sm"><i class="ri-save-line"></i>
                                    Update</button>
                            </div>
                        </form>
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div>
    <!-- container -->
@endsection
