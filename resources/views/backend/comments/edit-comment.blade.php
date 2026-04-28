@extends('layouts.vertical', ['page_title' => 'Edit Comment', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/select2/dist/css/select2.min.css', 'node_modules/daterangepicker/daterangepicker.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css'])
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Edit Comment</h4>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('backend.comment.update', $comment->id) }}">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}" />
            <div class="row">
                <div class="col-md-9">
                    {{-- main content --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="title">Comment on <span
                                        class="text-danger">*</span></label>
                                <input readonly disabled required type="text" id="title" placeholder="Add title"
                                    value="{{ $post->post_title }}" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Comment<span class="text-danger">*</span></label>
                                <textarea required rows="10" class="form-control" name="content">{{ $comment->content }}</textarea>
                                @error('content')
                                    <div class="valid-feedback d-block ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-3">
                    <input type="hidden" id="comment_id" value="{{ $comment->id }}" />

                    {{-- publish / submit --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="publish_status">
                                <div>
                                    <span class="form-text text-muted">
                                        <small>Status:
                                            {{ $comment->approved == 1 ? 'Approved' : 'Pending' }}</small>
                                    </span>
                                </div>
                                <div class="text-start mt-2">
                                    <div class="d-flex justify-content-between">
                                        @php
                                            $status = $comment ? $comment->approved : null;
                                            $draftBtnClass = $status == 0 ? 'primary' : 'outline-primary';
                                            $publishBtnClass = $status == 1 ? 'primary' : 'outline-primary';
                                        @endphp

                                        <p>
                                            <button class="btn btn-sm btn-{{ $draftBtnClass }}" type="submit"
                                                name="action" value="0">
                                                Save as pending
                                            </button>
                                        </p>
                                        <p>
                                            <button class="btn btn-sm btn-{{ $publishBtnClass }}" type="submit"
                                                name="action" value="1">
                                                Approved
                                            </button>
                                        </p>
                                    </div>
                                    @if ($comment)
                                        <div class="mb-3">
                                            <input readonly disabled type="text" class="form-control datetime-datepicker"
                                                placeholder="Date and Time"
                                                value="{{ \Carbon\Carbon::parse($comment->created_at)->format('Y-m-d H:i a') }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- user --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2 d-flex align-content-center border-1 border-bottom">
                                <h4 class="header-title">Commentor</h4>
                            </div>
                            <div class="publish_status">
                                <div class="text-start mt-2">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" value="{{ $user->name }}" readonly
                                            disabled>
                                        <br>
                                        <p>Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <input type="hidden" name="approved" /> --}}
                        <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}" />
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/demo.form-advanced.js'])
@endsection
