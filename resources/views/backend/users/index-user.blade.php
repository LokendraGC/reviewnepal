@extends('layouts.vertical', ['page_title' => 'All Users', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css', 'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="fs-5">All User Lists</h4>
                            <div class="d-block">
                                <a href="{{ route('backend.user.create') }}" class="btn btn-sm btn-dark">
                                    <i class="ri-add-line"></i> Add New User
                                </a>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="d-sm-flex justify-content-between align-items-center flex-warp">
                            <div class="row-action mb-2 mb-sm-0 fs-6">
                                <span class="edit">
                                    <a href="{{ route('backend.user') }}">
                                        <span class="@if ($status == 'all') text-black fw-700 @endif">
                                            All
                                        </span>
                                        ({{ $all }})</a>
                                </span>
                                <span class="admin">
                                    |
                                    <a href="{{ route('backend.user', ['status' => 'Admin']) }}" class="">
                                        <span class="@if ($status == 'Admin') text-black fw-700 @endif">
                                            Admin
                                        </span> ({{ $admin }})</a>
                                </span>
                                {{-- <span class="editor">
                                    |
                                    <a href="{{ route('backend.user', ['status' => 'Editor']) }}" class="">
                                        <span
                                            class="@if ($status == 'Editor') text-black fw-700 @endif">Editor</span>
                                        ({{ $editor }})</a>
                                </span> --}}
                                {{-- <span class="user">
                                    |
                                    <a href="{{ route('backend.user', ['status' => 'User']) }}" class="">
                                        <span class="@if ($status == 'User') text-black fw-700 @endif">User</span>
                                        ({{ $user }})</a>
                                </span> --}}
                            </div>
                        </div>
                        <livewire:backend.user.index-user :status="$status" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/demo.datatable-init.js'])
@endsection
