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
        <div class="col-lg-5">

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-2">Add New {{ ucfirst($categoryType) }}</h4>
                    <?php
                    if (!function_exists('displaySubCat')) {
                    function displaySubCat($categories, $level = 0)
                    {
                        $space = '';
                        foreach ($categories as $category) {
                            $space = '';
                            for ($i = 1; $i <= $level; $i++) {
                                $space .= '&nbsp;&nbsp;&nbsp;';
                            }
                    ?>
                            <option value="{{ $category->id }}">{!! $space . $category->name !!}</option>
                    <?php
                            if ($category->children->count() > 0) {
                                displaySubCat($category->children, $level + 1);
                            }
                        }
                    }
                    }
                    ?>
                    <form method="POST" action="{{ route('backend.author.store') }}">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}" />
                        <div class="mb-3">
                            <label class="form-label" for="category-name">Name<span class="text-danger">*</span></label>
                            <input name="name" type="text" class="form-control" id="category-name"
                                value="{{ old('name') }}" />
                            @error('name')
                            <div class="invalid-feedback d-block ">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                         <div class="mb-3">
                            <label class="form-label" for="category-name-ne">Name in Nepali</label>
                            <input name="name_ne" type="text" class="form-control" id="category-name-ne" 
                                value="{{ old('name_ne') }}" />
                            @error('name_ne')
                            <div class="invalid-feedback d-block ">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="category-slug">Slug</label>
                            <input name="slug" type="text" class="form-control" id="category-slug" />
                        </div>
                        <div class="mb-3">
                            <label for="category-description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="category-description" rows="5"></textarea>
                        </div>
                        <div>
                            <div class="mb-2 d-flex align-content-center">
                                <h4 class="header-title">Featured Image</h4>
                            </div>
                            <div class="input-group open-media-manager" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="cursor: pointer;" data-field="featured_image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        Browse</div>
                                </div>
                                <div class="form-control file-amount">Choose File</div>
                            </div>
                            <div class="preview-closer">
                                <input type="hidden" id="featured_image" name="featured_image" class="selected-files"
                                    value="" />
                                @error('featured_image')
                                <div class="valid-feedback d-block ">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div id="featured_image_select" class="clearfix"></div>
                            </div>
                        </div>
                        <div class="d-block">
                            <button class="btn btn-primary mt-3" type="submit">Add New
                                {{ ucfirst($categoryType) }}</button>
                        </div>
                    </form>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->

        </div> <!-- end col-->


        <div class="col-lg-7">

            @php
            $siteURL = SettingHelper::get_field('site_url');
            @endphp

            <div class="card">
                <div class="card-body">
                    <div class="mb-2">
                        <div class="row-action">
                            <span class="edit">
                                <a href="{{ route('backend.author') }}">
                                    <span class="@if ($status == 'all') text-black fw-700 @endif">
                                        All
                                    </span>
                                    ({{ $all }})</a>
                            </span>
                            @if ($trashPosts > 0)
                            <span class="delete">
                                |
                                <a href="{{ route('backend.author', ['status' => 'trash']) }}" class="">
                                    <span
                                        class="@if ($status == 'trash') text-black fw-700 @endif">Trashed</span>
                                    ({{ $trashPosts }})</a>
                            </span>
                            @endif
                        </div>
                    </div>
                    <hr class="mt-0" />
                    <div class="table-responsive">
                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @isset($categories)
                                {{-- children  --}}
                                <?php
                                if (!function_exists('displaySubCategories')) {
                                function displaySubCategories($categories, $level = 0, $cat = NULL)
                                {
                                    // $dashed = '';

                                    foreach ($categories as $category) {

                                        $dashed = '';

                                        for ($i = 1; $i <= $level; $i++) {

                                            $dashed .= '— ';
                                        }

                                ?>
                                        <tr>
                                            <td>
                                                <span class="fw-600"> <?php echo $dashed . $category->name; ?></span>
                                                <div class="row-action">
                                                    <span class="edit">
                                                        <a href="{{ route('backend.author.edit', $category->id) }}"
                                                            class="text-primary">Edit</a>
                                                    </span>
                                                    <span class="delete">
                                                        |
                                                        <a href="{{ route('backend.author.delete', $category->id) }}"
                                                            onclick="return confirm('Are you sure you want to delete?');"
                                                            class="text-danger">Delete</a>
                                                    </span>
                                                    <!-- <span class="view">
                                                        |
                                                        <a href="{{ $siteURL . '/author/' . $category->slug }}"
                                                            class="text-primary" target="_blank">View</a>
                                                    </span> -->
                                                </div>
                                            </td>
                                            <td>{{ $category->slug }}</td>
                                            <td>
                                                Published <br>
                                                {{ \Carbon\Carbon::parse($category->created_at)->format('Y-m-d h:i a') }}
                                            </td>
                                        </tr>
                                <?php
                                        // Recursively call the function for child categories with increased indentation level
                                        // if ($category->children->count() > 0) {
                                        //     displaySubCategories($category->children, $level + 1);
                                        // }
                                    }
                                }
                                }
                                ?>

                                @foreach ($categories as $category)
                                {{-- show parent category --}}
                                @if ($status == 'trash')
                                @include('backend.authors.trash-author')
                                @else
                                <tr>
                                    <td>
                                        <span class="fw-600"> {{ $category->name }}</span>
                                        <div class="row-action">
                                            <span class="edit">
                                                <a href="{{ route('backend.author.edit', $category->id) }}"
                                                    class="text-primary">Edit</a>
                                            </span>
                                            <span class="delete">
                                                |
                                                <a href="{{ route('backend.author.delete', $category->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete?');"
                                                    class="text-danger">Delete</a>
                                            </span>
                                            <!-- <span class="view">
                                                |
                                                <a href="{{ $siteURL . '/author/' . $category->slug }}"
                                                    class="text-primary" target="_blank">View</a>
                                            </span> -->
                                        </div>
                                    </td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        Published <br>
                                        {{ \Carbon\Carbon::parse($category->created_at)->format('Y-m-d h:i a') }}
                                    </td>
                                </tr>
                                @endif

                                {{-- show children --}}
                                @if ($category->children->count() > 0)
                                @php displaySubCategories($category->children, 1, $categoryType) @endphp
                                @endif
                                @endforeach
                                @endisset
                            </tbody>

                        </table>
                    </div>

                    <div class="d-flex justify-content-center justify-content-lg-end">
                        {{-- {{ $categories->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<livewire:backend.medias :multiple="false" :openModal="false" />
@endsection

@section('script')
@vite(['resources/js/pages/demo.datatable-init.js'])
@vite(['resources/js/media.js'])
@endsection