@extends('layouts.vertical', ['page_title' => 'All Comments', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                    {{-- <div class="align-self-center">
                        <h4 class="page-title" style="line-height: unset;">Tours</h4>
                    </div> --}}
                    <div>
                        {{-- <a href="{{ route('backend.team.create') }}" class="btn btn-outline-primary">Add New Team</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="row-action">
                                <span class="edit">
                                    <a href="{{ route('backend.comment') }}"><span
                                            class="@if ($status == 'all') text-black fw-700 @endif">All</span>
                                        ({{ count($comments) }})</a>
                                </span>
                                @if ($approvedComments > 0)
                                    <span class="publish">
                                        |
                                        <a href="{{ route('backend.comment', ['status' => 'approved']) }}"
                                            class=""><span
                                                class="@if ($status == 'approved') text-black fw-700 @endif">Approval</span>
                                            ({{ $approvedComments }})</a>
                                    </span>
                                @endif
                                @if ($pendingComments > 0)
                                    <span class="publish">
                                        |
                                        <a href="{{ route('backend.comment', ['status' => 'pending']) }}"
                                            class=""><span
                                                class="@if ($status == 'pending') text-black fw-700 @endif">Pending</span>
                                            ({{ $pendingComments }})</a>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped dt-responsive nowrap w-100 basic-datatable-id">
                                <thead>
                                    <tr>
                                        <th class="d-none">#ID</th>
                                        <th>Commenter</th>
                                        <th>Comment</th>
                                        <th>In response to</th>
                                        <th>Status</th>
                                        <th>Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                        <tr>
                                            <td class="d-none">{{ $comment->id }}</td>
                                            <td>
                                                <span class="fw-600">{{ $comment->user->name }}</span>
                                                <br>
                                                <a
                                                    href="mailto:{{ $comment->user->email }}"><span>{{ $comment->user->email }}</span></a>
                                                <br>
                                                <div class="row-action">
                                                    <span class="edit">
                                                        <a href="{{ route('backend.comment.edit', $comment->id) }}"
                                                            class="text-primary">Edit</a>
                                                    </span>
                                                    <span class="delete">
                                                        |
                                                        <a href="{{ route('backend.comment.delete', $comment->id) }}"
                                                            onclick="return confirm('Are you sure you want to permanently delete?');"
                                                            class="text-danger">Delete</a>
                                                    </span>
                                                </div>
                                            </td>
                                            <td style="max-width: 200px; white-space: normal; word-wrap: break-word;">
                                                {{ $comment->content }}</td>
                                            <td style="max-width: 200px; white-space: normal; word-wrap: break-word;">
                                                {{ $comment->post->post_title }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $comment->approved == 1 ? 'primary' : 'warning' }} rounded-pill">
                                                    {{ $comment->approved == 1 ? 'Approved' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td>
                                                Published
                                                <br>
                                                {{ \Carbon\Carbon::parse($comment->created_at)->format('Y-m-d h:i a') }}
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
