@extends('layouts.vertical', ['page_title' => 'Add/Edit Menu Items', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/select2/dist/css/select2.min.css', 'node_modules/daterangepicker/daterangepicker.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css'])
@endsection

@push('backend-css')
    <style>
        .dd {
            position: relative;
            display: block;
            margin: 0;
            padding: 0;
            max-width: 600px;
            list-style: none;
            font-size: 13px;
            line-height: 20px;
        }

        .dd-list {
            display: block;
            position: relative;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .dd-list .dd-list {
            padding-left: 30px;
        }

        .dd-collapsed .dd-list {
            display: none;
        }

        .dd-item,
        .dd-empty,
        .dd-placeholder {
            display: block;
            position: relative;
            margin: 0;
            padding: 0;
            min-height: 20px;
            font-size: 13px;
            line-height: 20px;
        }

        .dd-handle {
            display: block;
            height: 30px;
            margin: 5px 0;
            padding: 5px 10px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #ccc;
            background: #fafafa;
            background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
            background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
            background: linear-gradient(top, #fafafa 0%, #eee 100%);
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .dd-handle:hover {
            color: #2ea8e5;
            background: #fff;
        }

        .dd-item>button {
            display: block;
            position: relative;
            cursor: pointer;
            float: left;
            width: 25px;
            height: 20px;
            margin: 5px 0;
            padding: 0;
            text-indent: 100%;
            white-space: nowrap;
            overflow: hidden;
            border: 0;
            background: transparent;
            font-size: 12px;
            line-height: 1;
            text-align: center;
            font-weight: bold;
        }

        .dd-item>button:before {
            content: '+';
            display: block;
            position: absolute;
            width: 100%;
            text-align: center;
            text-indent: 0;
        }

        .dd-item>button[data-action="collapse"]:before {
            content: '-';
        }

        .dd-placeholder,
        .dd-empty {
            margin: 5px 0;
            padding: 0;
            min-height: 30px;
            background: #f2fbff;
            border: 1px dashed #b6bcbf;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .dd-empty {
            border: 1px dashed #bbb;
            min-height: 100px;
            background-color: #e5e5e5;
            background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
        }

        .dd-dragel {
            position: absolute;
            pointer-events: none;
            z-index: 9999;
        }

        .dd-dragel>.dd-item .dd-handle {
            margin-top: 0;
        }

        .dd-dragel .dd-handle {
            -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
            box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
        }

        /** * Nestable Extras */

        .nestable-lists {
            display: block;
            clear: both;
            padding: 30px 0;
            width: 100%;
            border: 0;
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd;
        }

        #nestable-menu {
            padding: 0;
            margin: 20px 0;
        }

        #nestable-output,
        #nestable2-output {
            width: 100%;
            height: 7em;
            font-size: 0.75em;
            line-height: 1.333333em;
            font-family: Consolas, monospace;
            padding: 5px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        #nestable2 .dd-handle {
            color: #fff;
            border: 1px solid #999;
            background: #bbb;
            background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
            background: -moz-linear-gradient(top, #bbb 0%, #999 100%);
            background: linear-gradient(top, #bbb 0%, #999 100%);
        }

        #nestable2 .dd-handle:hover {
            background: #bbb;
        }

        #nestable2 .dd-item>button:before {
            color: #fff;
        }

        @media only screen and (min-width: 700px) {

            .dd {
                float: left;
                width: 48%;
            }

            .dd+.dd {
                margin-left: 2%;
            }

        }

        .dd-hover>.dd-handle {
            background: #2ea8e5 !important;
        }

        /** * Nestable Draggable Handles */

        .dd3-content {
            display: block;
            height: 30px;
            margin: 5px 0;
            padding: 5px 10px 5px 40px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #ccc;
            background: #fafafa;
            background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
            background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
            background: linear-gradient(top, #fafafa 0%, #eee 100%);
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .dd3-content:hover {
            color: #2ea8e5;
            background: #fff;
        }

        .dd-dragel>.dd3-item>.dd3-content {
            margin: 0;
        }

        .dd3-item>button {
            margin-left: 30px;
        }

        .dd3-handle {
            position: absolute;
            margin: 0;
            left: 0;
            top: 0;
            cursor: pointer;
            width: 30px;
            text-indent: 100%;
            white-space: nowrap;
            overflow: hidden;
            border: 1px solid #aaa;
            background: #ddd;
            background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
            background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
            background: linear-gradient(top, #ddd 0%, #bbb 100%);
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .dd3-handle:before {
            content: '≡';
            display: block;
            position: absolute;
            left: 0;
            top: 3px;
            width: 100%;
            text-align: center;
            text-indent: 0;
            color: #fff;
            font-size: 20px;
            font-weight: normal;
        }

        .dd3-handle:hover {
            background: #ddd;
        }

        .edit-wrap {
            position: absolute;
            top: 0;
            left: 101%;
        }

        .delete-wrap {
            position: absolute;
            top: 0;
            left: 107%;
        }
    </style>
@endpush

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Menu</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="header-title">Add menu items</h4>
                                <div class="accordion" id="accordionExample">
                                    @php
                                        $menuItemCount = 1;
                                    @endphp

                                    {{-- pages --}}
                                    @if ($pages)
                                        <form action="{{ route('backend.menu.update_edit_menu_item', $menu->id) }}"
                                            method="POST">
                                            @csrf
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="pages">
                                                    <button class="accordion-button fw-medium collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#page"
                                                        aria-expanded="false" aria-controls="page">
                                                        Pages
                                                    </button>
                                                </h2>
                                                @foreach ($pages as $page)
                                                    <div id="page" class="accordion-collapse collapse"
                                                        aria-labelledby="pages" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body px-2 pt-2 pb-1">
                                                            <div class="">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="page{{ $page->id }}"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_object_id]"
                                                                        value="{{ $page->id }}" />
                                                                    <label class="form-check-label"
                                                                        for="page{{ $page->id }}">{{ $page->post_title }}</label>
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_type]"
                                                                        value="post_type">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_object]"
                                                                        value="page">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_title]"
                                                                        value="{{ $page->post_title }}">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_parent_id]"
                                                                        value="0">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_attr_title]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_classes]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_target]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_url]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_route]"
                                                                        value="frontend.post.index">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $menuItemCount++;
                                                    @endphp
                                                @endforeach
                                                <div id="page" class="accordion-collapse collapse"
                                                    aria-labelledby="pages" data-bs-parent="#accordionExample">
                                                    <hr class="m-0">
                                                    <div class="add-to-menu-btn text-end p-1">
                                                        <button type="submit" class="btn btn-soft-primary">Add to
                                                            Menu</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                    {{-- end pages --}}

                                    {{-- categories --}}
                                    @if ($categories)
                                        <form action="{{ route('backend.menu.update_edit_menu_item', $menu->id) }}"
                                            method="POST" class="mt-2">
                                            @csrf
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="categories">
                                                    <button class="accordion-button fw-medium collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#category"
                                                        aria-expanded="false" aria-controls="category">
                                                        Categories
                                                    </button>
                                                </h2>
                                                @foreach ($categories as $category)
                                                    <div id="category" class="accordion-collapse collapse"
                                                        aria-labelledby="categories" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body px-2 pt-2 pb-1">
                                                            <div class="">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="post{{ $category->id }}"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_object_id]"
                                                                        value="{{ $category->id }}" />
                                                                    <label class="form-check-label"
                                                                        for="post{{ $category->id }}">{{ $category->name }}</label>
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_type]"
                                                                        value="category">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_object]"
                                                                        value="category">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_title]"
                                                                        value="{{ $category->name }}">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_parent_id]"
                                                                        value="0">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_attr_title]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_classes]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_target]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_url]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_route]"
                                                                        value="frontend.category.index">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $menuItemCount++;
                                                    @endphp
                                                @endforeach
                                                <div id="category" class="accordion-collapse collapse"
                                                    aria-labelledby="categories" data-bs-parent="#accordionExample">
                                                    <hr class="m-0">
                                                    <div class="add-to-menu-btn text-end p-1">
                                                        <button type="submit" class="btn btn-soft-primary">Add to
                                                            Menu</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    @endif
                                    {{-- end categories --}}

                                    {{-- wiki category --}}
                                    @if ($wikiCats)
                                        <form action="{{ route('backend.menu.update_edit_menu_item', $menu->id) }}"
                                            method="POST" class="mt-2">
                                            @csrf
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="wikiCats">
                                                    <button class="accordion-button fw-medium collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#wikiCat"
                                                        aria-expanded="false" aria-controls="wikiCat">
                                                        Wiki Categories
                                                    </button>
                                                </h2>
                                                @foreach ($wikiCats as $category)
                                                    <div id="wikiCat" class="accordion-collapse collapse"
                                                        aria-labelledby="wikiCats" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body px-2 pt-2 pb-1">
                                                            <div class="">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="post{{ $category->id }}"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_object_id]"
                                                                        value="{{ $category->id }}" />
                                                                    <label class="form-check-label"
                                                                        for="post{{ $category->id }}">{{ $category->name }}</label>
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_type]"
                                                                        value="category">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_object]"
                                                                        value="wiki-category">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_title]"
                                                                        value="{{ $category->name }}">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_parent_id]"
                                                                        value="0">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_attr_title]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_classes]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_target]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_url]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_route]"
                                                                        value="frontend.category.index">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $menuItemCount++;
                                                    @endphp
                                                @endforeach
                                                <div id="wikiCat" class="accordion-collapse collapse"
                                                    aria-labelledby="wikiCats" data-bs-parent="#accordionExample">
                                                    <hr class="m-0">
                                                    <div class="add-to-menu-btn text-end p-1">
                                                        <button type="submit" class="btn btn-soft-primary">Add to
                                                            Menu</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    @endif
                                    {{-- end wiki category --}}

                                    {{-- webstories category --}}
                                    @if ($webstoriesCats)
                                        <form action="{{ route('backend.menu.update_edit_menu_item', $menu->id) }}"
                                            method="POST" class="mt-2">
                                            @csrf
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="webstoriesCats">
                                                    <button class="accordion-button fw-medium collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#webstoriesCat"
                                                        aria-expanded="false" aria-controls="webstoriesCat">
                                                        Web Stories Categories
                                                    </button>
                                                </h2>
                                                @foreach ($webstoriesCats as $category)
                                                    <div id="webstoriesCat" class="accordion-collapse collapse"
                                                        aria-labelledby="webstoriesCats" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body px-2 pt-2 pb-1">
                                                            <div class="">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="post{{ $category->id }}"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_object_id]"
                                                                        value="{{ $category->id }}" />
                                                                    <label class="form-check-label"
                                                                        for="post{{ $category->id }}">{{ $category->name }}</label>
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_type]"
                                                                        value="category">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_object]"
                                                                        value="wiki-category">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_title]"
                                                                        value="{{ $category->name }}">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_parent_id]"
                                                                        value="0">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_attr_title]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_classes]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_target]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_url]"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="menu_item[{{ $menuItemCount }}][menu_item_route]"
                                                                        value="frontend.category.index">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $menuItemCount++;
                                                    @endphp
                                                @endforeach
                                                <div id="webstoriesCat" class="accordion-collapse collapse"
                                                    aria-labelledby="webstoriesCats" data-bs-parent="#accordionExample">
                                                    <hr class="m-0">
                                                    <div class="add-to-menu-btn text-end p-1">
                                                        <button type="submit" class="btn btn-soft-primary">Add to
                                                            Menu</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    @endif
                                    {{-- end webstories category --}}

                                    {{-- custom links --}}
                                    <form action="{{ route('backend.menu.update_edit_menu_item', $menu->id) }}"
                                        method="POST" class="mt-2">
                                        @csrf
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="custom-links">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#custom"
                                                    aria-expanded="false" aria-controls="custom">
                                                    Custom Links
                                                </button>
                                            </h2>
                                            <div id="custom" class="accordion-collapse collapse"
                                                aria-labelledby="custom-links" data-bs-parent="#accordionExample">
                                                <div class="accordion-body px-2 pt-2 pb-1">
                                                    <div class="mb-2 row">
                                                        <label for="custom_menu_item_url"
                                                            class="col-sm-3 col-form-label col-form-label-sm">URL<span
                                                                class="text-danger">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control form-control-md"
                                                                id="custom_menu_item_url" placeholder="https://"
                                                                name="menu_item[{{ $menuItemCount }}][menu_item_url]"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="mb-2 row">
                                                        <label for="custom_link_text"
                                                            class="col-sm-3 col-form-label col-form-label-sm">Link
                                                            Text</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control form-control-md"
                                                                id="custom_link_text"
                                                                name="menu_item[{{ $menuItemCount }}][menu_item_title]" />
                                                        </div>
                                                    </div>
                                                    <input type="hidden"
                                                        name="menu_item[{{ $menuItemCount }}][menu_item_type]"
                                                        value="custom">
                                                    <input type="hidden"
                                                        name="menu_item[{{ $menuItemCount }}][menu_item_object]"
                                                        value="custom">
                                                    <input type="hidden"
                                                        name="menu_item[{{ $menuItemCount }}][menu_item_parent_id]"
                                                        value="0">
                                                    <input type="hidden"
                                                        name="menu_item[{{ $menuItemCount }}][menu_item_attr_title]"
                                                        value="">
                                                    <input type="hidden"
                                                        name="menu_item[{{ $menuItemCount }}][menu_item_classes]"
                                                        value="">
                                                    <input type="hidden"
                                                        name="menu_item[{{ $menuItemCount }}][menu_item_target]"
                                                        value="">
                                                    <input type="hidden"
                                                        name="menu_item[{{ $menuItemCount }}][menu_item_object_id]"
                                                        value="">
                                                </div>
                                            </div>
                                            <div id="custom" class="accordion-collapse collapse"
                                                aria-labelledby="custom-links" data-bs-parent="#accordionExample">
                                                <hr class="m-0">
                                                <div class="add-to-menu-btn text-end p-1">
                                                    <button type="submit" class="btn btn-soft-primary">Add to
                                                        Menu</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    {{-- end custom links --}}
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4 class="header-title mt-2 mt-md-0">Menu Structure</h4>
                                @if ($allMenuItems->isNotEmpty())
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="dd w-100">
                                            <ol class="dd-list">
                                                @foreach ($allMenuItems as $depth_0)
                                                    @php
                                                        $menuItemMeta = $depth_0->GetAllMetaData();
                                                    @endphp
                                                    {{-- depth 0 --}}
                                                    <li class="dd-item dd3-item" data-id="{{ $depth_0->id }}">
                                                        <div class="dd-handle dd3-handle"></div>
                                                        @include('backend.menus.menu-attr', [
                                                            'item' => $depth_0,
                                                            'item_meta' => $menuItemMeta,
                                                        ])
                                                        @php
                                                            $children_0 = PostHelper::getModel()
                                                                ->PostType('nav_menu_item')
                                                                ->whereHas('postMeta', function ($query) use (
                                                                    $depth_0,
                                                                ) {
                                                                    $query
                                                                        ->where('meta_key', 'menu_item_parent_id')
                                                                        ->where('meta_value', $depth_0->id);
                                                                })
                                                                ->orderBy('menu_order', 'ASC')
                                                                ->get();
                                                        @endphp
                                                        {{-- depth 1 --}}
                                                        @if ($children_0->isNotEmpty())
                                                            <ol class="dd-list">
                                                                @foreach ($children_0 as $child)
                                                                    @php
                                                                        $menuItemMeta = $child->GetAllMetaData();
                                                                    @endphp
                                                                    <li class="dd-item dd3-item"
                                                                        data-id="{{ $child->id }}">
                                                                        <div class="dd-handle dd3-handle"></div>
                                                                        @include(
                                                                            'backend.menus.menu-attr',
                                                                            [
                                                                                'item' => $child,
                                                                                'item_meta' => $menuItemMeta,
                                                                            ]
                                                                        )
                                                                        @php
                                                                            $children_1 = PostHelper::getModel()
                                                                                ->PostType('nav_menu_item')
                                                                                ->whereHas('postMeta', function (
                                                                                    $query,
                                                                                ) use ($child) {
                                                                                    $query
                                                                                        ->where(
                                                                                            'meta_key',
                                                                                            'menu_item_parent_id',
                                                                                        )
                                                                                        ->where(
                                                                                            'meta_value',
                                                                                            $child->id,
                                                                                        );
                                                                                })
                                                                                ->orderBy('menu_order', 'ASC')
                                                                                ->get();
                                                                        @endphp
                                                                        {{-- depth 2 --}}
                                                                        @if ($children_1->isNotEmpty())
                                                                            <ol class="dd-list">
                                                                                @foreach ($children_1 as $child)
                                                                                    @php
                                                                                        $menuItemMeta = $child->GetAllMetaData();
                                                                                    @endphp
                                                                                    <li class="dd-item dd3-item"
                                                                                        data-id="{{ $child->id }}">
                                                                                        <div class="dd-handle dd3-handle">
                                                                                        </div>
                                                                                        @include(
                                                                                            'backend.menus.menu-attr',
                                                                                            [
                                                                                                'item' => $child,
                                                                                                'item_meta' => $menuItemMeta,
                                                                                            ]
                                                                                        )
                                                                                    </li>
                                                                                @endforeach
                                                                            </ol>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ol>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/demo.form-advanced.js'])
@endsection
@push('backend-js')
    <script defer src="{{ asset('jquery.nestable.js') }}"></script>
    <script>
        $(document).ready(function() {
            var updateOutput = function(e) {
                // Check if the event target is the .dd element
                if ($(e.target).hasClass('dd')) {
                    e.preventDefault();

                    var list = e.length ? e : $(e.target),
                        output = list.data('output');
                    $.ajax({
                        method: "POST",
                        url: "{{ route('backend.menu.add_edit_menu_item.sort', $menu->id) }}",
                        data: {
                            list: list.nestable('serialize')
                        },
                        success: function(response) {
                            toastr.success('Menu Updated', {
                                progressBar: true,
                                positionClass: 'toast-top-right',
                                closeButton: true,
                                toastClass: 'mt-5',
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            };

            $('.dd').nestable({
                    'serialize': true,
                    'maxDepth': 5,
                    'includeContent': true
                })
                .on('change', updateOutput);
        });

        // remove
        $('.remove-menu-item').on('click', function() {
            var object = $(this);
            var liElement = object.closest('li');
            var item_id = object.closest('li').data('id');
            var menu_id = "{{ $menu->id }}";
            var confirmation = confirm("Are you sure you want to remove this menu item?");
            if (confirmation) {
                var baseUrl = "{{ url('/') }}/";
                var URL = baseUrl + 'admin/menu/' + menu_id + '/delete/' + item_id;
                console.log(URL);
                $.ajax({
                    type: "POST",
                    url: URL,
                    data: {
                        id: item_id,
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        object.closest('li').remove();
                        toastr.success('Menu Item Removed', {
                            progressBar: true,
                            positionClass: 'toast-top-right',
                            closeButton: true,
                            toastClass: 'mt-5',
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        // menu item update
        $(document).on('click', '.update-menu-item', function(e) {
            e.preventDefault();
            var object = $(this);
            var mainParent = object.closest('.card-body');
            var inputNames = [
                "menu_item_id",
                "menu_item_main_title",
                "menu_item_classes",
                "menu_item_attr_title",
                "menu_item_url",
                "menu_item_object"
            ];

            var data = {};
            inputNames.forEach(name => {
                data[name] = mainParent.find(`input[name="${name}"]`).val();
            });

            // Handle 'new tab' input separately
            var menu_item_target = mainParent.find('input.new_tab');
            data.menu_item_target = menu_item_target.is(':checked') ? menu_item_target.val() : null;

            $.ajax({
                type: "POST",
                url: "{{ route('backend.menu.item_update') }}",
                data: data,
                success: function(response) {
                    if (response) {
                        $('#menu_item_main_title_' + response.menu_item_id).html(response
                            .menu_item_main_title_)
                        $('#navigation_label_' + response.menu_item_id).val(response
                            .menu_item_main_title_);
                        toastr.success('Updated', {
                            progressBar: true,
                            positionClass: 'toast-top-right',
                            closeButton: true,
                            toastClass: 'mt-5',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const accordionItems = document.querySelectorAll('.accordion-item');

            accordionItems.forEach(item => {
                item.addEventListener('click', function() {
                    const content = this.querySelector('.accordion-body');

                    // Get the content height
                    const contentHeight = content.scrollHeight;

                    // Remove the inline style from all items
                    accordionItems.forEach(i => {
                        i.style.maxHeight = '';
                        i.style.overflowY = '';
                    });

                    // Toggle the height for the clicked item
                    if (this.style.maxHeight) {
                        this.style.maxHeight = '';
                        this.style.overflowY = '';
                    } else {
                        // Set max-height to contentHeight + some padding
                        this.style.maxHeight =
                            `${contentHeight + 300}px`; // Adjust padding as needed
                        this.style.overflowY = 'auto';
                    }
                });
            });
        });
    </script>
@endpush
