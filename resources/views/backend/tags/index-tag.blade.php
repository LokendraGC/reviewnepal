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
                        ?>
                        <form method="POST" action="{{ route('backend.tag.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}" />
                            <div class="mb-3">
                                <label class="form-label" for="category-name">Name<span class="text-danger">*</span></label>
                                <input name="name" type="text" class="form-control" id="category-name"
                                    value="{{ old('name') }}" required />
                                @error('name')
                                    <div class="invalid-feedback d-block ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="category-slug">Slug</label>
                                <input name="slug" type="text" class="form-control" id="category-slug" />
                                {{-- @error('slug')
                                    <div class="invalid-feedback d-block ">
                                        {{ $message }}
                                    </div>
                                @enderror --}}
                            </div>
                            {{-- <div class="mb-3" style="max-width: max-content;">
                                <label class="form-label" for="category-parent">Parent {{ ucfirst($categoryType) }}</label>
                                <select name="parent" class="form-select" id="category-parent">
                                    <option value="0">None</option>
                                    @isset($categories)
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                            @if ($category->children->count() > 0)
                                                @php displaySubCat($category->children, 1) @endphp
                                            @endif
                                        @endforeach
                                    @endisset
                                </select>
                            </div> --}}
                            <div class="mb-3">
                                <label for="category-description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="category-description" rows="5"></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Add New
                                {{ ucfirst($categoryType) }}</button>
                        </form>

                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->


                {{-- <livewire:backend.category.create-category :category_name="$category_name" /> --}}

            </div> <!-- end col-->


            <div class="col-lg-7">

                {{-- <livewire:backend.category.list-category :category_name="$category_name" /> --}}

                @php
                    $siteURL = SettingHelper::get_field('site_url');
                @endphp

                <div class="card">
                    <div class="card-body">
                        <div class="row-action">
                            <span class="edit">
                                <a href="{{ route('backend.tag') }}">
                                    <span class="@if ($status == 'all') text-black fw-700 @endif">
                                        All
                                    </span>
                                    ({{ count($all) }})</a>
                            </span>
                            @if ($trashPosts > 0)
                                <span class="delete">
                                    |
                                    <a href="{{ route('backend.tag', ['status' => 'trash']) }}" class="">
                                        <span
                                            class="@if ($status == 'trash') text-black fw-700 @endif">Trashed</span>
                                        ({{ $trashPosts }})</a>
                                </span>
                            @endif
                        </div>
                        <hr class="" />
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
                                                        <a href="{{ route('backend.category.edit', $category->id) }}"
                                                            class="text-primary">Edit</a>
                                                    </span>
                                                    <span class="delete">
                                                        |
                                                        <a href="{{ route('backend.category.delete', $category->id) }}"
                                                            onclick="return confirm('Are you sure you want to delete?');"
                                                            class="text-danger">Delete</a>
                                                    </span>
                                                    <span class="view">
                                                        |
                                                        <a href="{{ $siteURL . '/tag/' . $category->slug }}"
                                                            class="text-primary" target="_blank">View</a>
                                                    </span>
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
                                        ?>

                                        @foreach ($categories as $category)
                                            {{-- show parent category --}}
                                            @if ($status == 'trash')
                                                @include('backend.tags.trash-tag')
                                            @else
                                                <tr>
                                                    <td>
                                                        <span class="fw-600"> {{ $category->name }}</span>
                                                        <div class="row-action">
                                                            <span class="edit">
                                                                <a href="{{ route('backend.tag.edit', $category->id) }}"
                                                                    class="text-primary">Edit</a>
                                                            </span>
                                                            <span class="delete">
                                                                |
                                                                <a href="{{ route('backend.tag.delete', $category->id) }}"
                                                                    onclick="return confirm('Are you sure you want to delete?');"
                                                                    class="text-danger">Delete</a>
                                                            </span>
                                                            <span class="view">
                                                                |
                                                                <a href="{{ $siteURL . '/tag/' . $category->slug }}"
                                                                    class="text-primary" target="_blank">View</a>
                                                            </span>
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
@endsection

@section('script')
    @vite(['resources/js/pages/demo.datatable-init.js'])
@endsection
