@extends('layouts.vertical', ['page_title' => 'All Menus', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css', 'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box py-3 d-flex justify-content-start align-content-center  gap-2">
                    <div class="align-self-center">
                        <h4 class="page-title" style="line-height: unset;">Menus</h4>
                    </div>
                    {{-- @can('create_post')
                        <div>
                            <a href="{{ route('backend.menu.create') }}" class="btn btn-outline-primary">Add New Menu</a>
                        </div>
                    @endcan --}}
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            {{-- <div class="row-action">
                                <span class="edit">
                                    <a href="{{ route('backend.post') }}"><span class="text-black fw-700">All</span>
                                        ({{ count($posts) }})</a>
                                </span>
                                <span class="publish">
                                    |
                                    <a href="" class="">Published ({{ count($publishPosts) }})</a>
                                </span>
                                @if (count($draftPosts) > 0)
                                    <span class="draft">
                                        |
                                        <a href="" class="">Draft ({{ count($draftPosts) }})</a>
                                    </span>
                                @endif
                                @if (count($trashPosts) > 0)
                                    <span class="delete">
                                        |
                                        <a href="{{ route('backend.post.trash', $postType) }}" class="">Trashed
                                            ({{ count($trashPosts) }})</a>
                                    </span>
                                @endif
                            </div> --}}
                        </div>
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $menu)
                                        <tr>
                                            <td>
                                                <span class="fw-600">{{ $menu->name }}</span>
                                                <br />
                                                <div class="row-action">
                                                    {{-- <span class="edit">
                                                        <a href="{{ route('backend.menu.edit', $menu->id) }}"
                                                            class="text-primary">Edit</a>
                                                    </span>
                                                    <span class="delete">
                                                        |
                                                        <a href="{{ route('backend.menu.delete', $menu->id) }}"
                                                            onclick="return confirm('Are you sure you want to delete?');"
                                                            class="text-danger">Delete</a>
                                                    </span> --}}
                                                    <span class="edit">
                                                        <a href="{{ route('backend.menu.edit', $menu->id) }}"
                                                            class="text-primary">Edit</a>
                                                    </span>
                                                    <span class="add-edit">
                                                        |
                                                        <a href="{{ route('backend.menu.add_edit_menu_item', $menu->id) }}"
                                                            class="text-success" target="_self">Add/Edit Menu
                                                            Items</a>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div> <!-- end row-->
    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/demo.datatable-init.js'])
@endsection
