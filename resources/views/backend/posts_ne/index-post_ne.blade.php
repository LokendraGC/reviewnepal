@extends('layouts.vertical', ['page_title' => 'All Posts', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="collapse multi-collapse mt-2" id="multiCollapseExample1">
                            <div class="card card-body">
                                <h6 class="fs-15 mb-2">Columns</h6>

                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input column-toggle" data-column="title"
                                        id="colTitle" checked>
                                    <label class="form-check-label" for="colTitle">Title</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input column-toggle" data-column="author"
                                        id="colAuthor" checked>
                                    <label class="form-check-label" for="colAuthor">Author</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input column-toggle" data-column="category"
                                        id="colCategory" checked>
                                    <label class="form-check-label" for="colCategory">Category</label>
                                </div>

                                <button class="btn btn-danger btn-sm mt-2" id="applyColumnsBtn">Apply</button>
                            </div>
                            <hr>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="fs-5">All Posts</h4>
                            <div class="d-block">
                                <a href="{{ route('backend.post.create') }}" class="btn btn-sm btn-dark">
                                    <i class="ri-add-circle-line fs-5"></i>
                                    Add New Post
                                </a>
                            </div>
                        </div>
                        <hr class="my-2">
                        <livewire:data-table.post-data-table :status="$status" :postType="$postType" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
