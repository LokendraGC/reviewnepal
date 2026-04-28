@extends('layouts.vertical', ['page_title' => 'Add New Role', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box py-3 d-flex justify-content-start align-content-center  gap-2">
                    <div class="align-self-center">
                        <h4 class="page-title" style="line-height: unset;">Add New Role</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Create Role</h4>
                        <form action="{{ route('backend.role.store') }}" method="POST">
                            @csrf
                            <div class="my-3">
                                <label for="roleName" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="roleName" aria-describedby="text"
                                    name="name" required />
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
            <!-- end col -->
        </div>
    </div>
@endsection
