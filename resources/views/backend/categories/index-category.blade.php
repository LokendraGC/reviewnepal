@extends('layouts.vertical', ['page_title' => ucfirst($categoryType), 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css', 'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ ucfirst($categoryType) }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Add Category Form --}}
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-2">Add New {{ ucfirst($categoryType) }}</h4>

                        <form method="POST" action="{{ route('backend.category.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}" />

                            <div class="mb-3">
                                <label class="form-label" for="category-name">Name <span
                                        class="text-danger">*</span></label>
                                <input name="name" type="text" class="form-control" id="category-name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="category-slug">Slug</label>
                                <input name="slug" type="text" class="form-control" id="category-slug">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="category-parent">Parent {{ ucfirst($categoryType) }}</label>
                                <select name="parent" class="form-select" id="category-parent">
                                    <option value="0">None</option>
                                    @php
                                        function displaySubCatOptions($categories, $level = 0)
                                        {
                                            foreach ($categories as $category) {
                                                echo '<option value="' .
                                                    $category->id .
                                                    '">' .
                                                    str_repeat('&nbsp;', $level * 3) .
                                                    $category->name .
                                                    '</option>';
                                                if ($category->children->count()) {
                                                    displaySubCatOptions($category->children, $level + 1);
                                                }
                                            }
                                        }
                                        displaySubCatOptions($categories);
                                    @endphp
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category-description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="category-description" rows="5"></textarea>
                            </div>

                            <div class="mb-3">
                                <h4 class="header-title">Featured Image</h4>
                                <div class="input-group open-media-manager" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" style="cursor: pointer;"
                                    data-field="featured_image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">Browse</div>
                                    </div>
                                    <div class="form-control file-amount">Choose File</div>
                                </div>
                                <div class="preview-closer">
                                    <input type="hidden" id="featured_image" name="featured_image"
                                        class="selected-files" value="" />
                                    <div id="featured_image_select" class="clearfix"></div>
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Add New {{ ucfirst($categoryType) }}</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Category List Table --}}
            <div class="col-lg-7">

                @php $siteURL = SettingHelper::get_field('site_url'); @endphp

                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="row-action">
                                <span class="edit">
                                    <a href="{{ route('backend.category') }}">
                                        <span class="{{ $status == 'all' ? 'text-black fw-700' : '' }}">All</span>
                                        ({{ $all }})
                                    </a>
                                </span>
                                @if ($trashPosts > 0)
                                    <span class="delete">
                                        |
                                        <a href="{{ route('backend.category', ['status' => 'trash']) }}">
                                            <span
                                                class="{{ $status == 'trash' ? 'text-black fw-700' : '' }}">Trashed</span>
                                            ({{ $trashPosts }})
                                        </a>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <livewire:data-table.category-data-table :siteURL="$siteURL" :status="$status" />

                    </div>
                </div>
            </div>
        </div>

        <livewire:backend.medias :multiple="false" :openModal="false" />
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/demo.datatable-init.js', 'resources/js/media.js'])
@endsection
