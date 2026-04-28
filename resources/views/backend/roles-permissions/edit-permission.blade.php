@extends('layouts.vertical', ['page_title' => 'Edit Permission', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box py-3 d-flex justify-content-start align-content-center  gap-2">
                    <div class="align-self-center">
                        <h4 class="page-title" style="line-height: unset;">Edit Permission</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Edit Permission</h4>
                        <form action="{{ route('backend.permission.update', $permission->id) }}" method="POST">
                            @csrf
                            <div class="my-3">
                                <label for="permissionName" class="form-label">Permission Name</label>
                                <input type="text" class="form-control" id="permissionName" aria-describedby="text"
                                    name="name" value="{{ $permission->name }}" required />
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
            <!-- end col -->
        </div>
    </div>
@endsection
