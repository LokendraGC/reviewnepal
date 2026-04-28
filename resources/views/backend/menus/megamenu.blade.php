@extends('layouts.vertical', ['page_title' => 'Mega Menu', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/select2/dist/css/select2.min.css', 'node_modules/daterangepicker/daterangepicker.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css'])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Mega Menu</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <form action="{{ route('backend.mega-menu.store') }}" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="nav  nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link {{ !request()->has('tab') || request()->query('tab') == 'nepal' ? 'active' : '' }}"
                                            id="nepal-tab" data-bs-toggle="pill" href="#nepal" role="tab"
                                            aria-controls="nepal"
                                            aria-selected="{{ request()->query('tab') == 'nepal' ? 'true' : 'false' }}"
                                            tabindex="-1">
                                            Nepal
                                        </a>
                                        <a class="nav-link {{ request()->query('tab') == 'tibet' ? 'active' : '' }}"
                                            id="tibet-tab" data-bs-toggle="pill" href="#tibet" role="tab"
                                            aria-controls="tibet"
                                            aria-selected="{{ request()->query('tab') == 'tibet' ? 'true' : 'false' }}"
                                            tabindex="-1">
                                            Tibet
                                        </a>
                                    </div>
                                </div>
                                <!-- end col-->
                                @csrf
                                <hr />
                                <div class="col-12">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade {{ !request()->has('tab') || request()->query('tab') == 'nepal' ? 'active show' : '' }}"
                                            id="nepal" role="tabpanel" aria-labelledby="nepal-tab">
                                            <div class="mb-2 row">
                                                <div class="col-2">
                                                    <label for="nepal-trekking"
                                                        class="col-sm-12 col-form-label col-form-label-sm">Nepal
                                                        Trekking<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-10">
                                                    <div id="mega_main_first">
                                                        @isset($menus['mega_main_first'])
                                                            @php
                                                                $megaMainFirst = unserialize($menus['mega_main_first']);
                                                                // dd($megaMainFirst);
                                                            @endphp
                                                            @foreach ($megaMainFirst as $menu)
                                                                @isset($menu['title'])
                                                                    <div class="row mb-2">
                                                                        <div class="col-sm-3">
                                                                            <select class="form-control select2"
                                                                                data-toggle="select2"
                                                                                name="mega_main_first[{{ $loop->iteration - 1 }}][title]">
                                                                                <option selected disabled>Select</option>
                                                                                @foreach ($regions as $region)
                                                                                    <option value="{{ $region->id }}"
                                                                                        @if ($menu['title'] == $region->id) selected @endif>
                                                                                        {{ $region->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-7">
                                                                            <select class="select2 form-control select2-multiple"
                                                                                data-toggle="select2" multiple="multiple"
                                                                                name="mega_main_first[{{ $loop->iteration - 1 }}][packages][]">
                                                                                @foreach ($tours as $tour)
                                                                                    <option value="{{ $tour->id }}"
                                                                                        @if (in_array($tour->id, $menu['packages'])) selected @endif>
                                                                                        {{ $tour->post_title }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <div class="text-center">
                                                                                <a href="javascript:void(0);"
                                                                                    data-id="mega_main_first"
                                                                                    class="text-reset fs-16 px-1 mega_main_first_add_new">
                                                                                    <i class="bi bi-plus-circle"></i>
                                                                                </a>
                                                                                <a href="javascript:void(0);"
                                                                                    data-id="mega_main_first" data-count="0"
                                                                                    class="text-reset fs-16 px-1 mega_main_first_row_remove">
                                                                                    <i class="bi bi-x-circle"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endisset
                                                            @endforeach
                                                        @endisset
                                                    </div>
                                                    <div class="text-end mt-2">
                                                        <button type="button" data-id="mega_main_first"
                                                            class="btn btn-primary btn-sm mega_main_first_add_new_btn">Add
                                                            New</button>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- nepal trekking end --}}
                                            <hr />
                                            <div class="mb-2 row">
                                                <div class="col-2">
                                                    <label for="nepal-trekking"
                                                        class="col-sm-12 col-form-label col-form-label-sm">Nepal Tours<span
                                                            class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-10">
                                                    <div id="mega_main_second">
                                                        <div class="row mb-2">
                                                            <div class="col-sm-3">
                                                                <select class="form-control select2" data-toggle="select2"
                                                                    name="mega_main_second[0][title]">
                                                                    <option selected disabled>Select</option>
                                                                    @foreach ($regions as $region)
                                                                        <option value="{{ $region->id }}">
                                                                            {{ $region->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <select class="select2 form-control select2-multiple"
                                                                    data-toggle="select2" multiple="multiple"
                                                                    name="mega_main_second[0][packages][]">
                                                                    @foreach ($tours as $tour)
                                                                        <option value="{{ $tour->id }}">
                                                                            {{ $tour->post_title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="text-center">
                                                                    <a href="javascript:void(0);" data-id="mega_main_second"
                                                                        class="text-reset fs-16 px-1 mega_main_second_add_new">
                                                                        <i class="bi bi-plus-circle"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0);"
                                                                        data-id="mega_main_second" data-count="0"
                                                                        class="text-reset fs-16 px-1 mega_main_second_row_remove">
                                                                        <i class="bi bi-x-circle"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-end mt-2">
                                                        <button type="button" data-id="mega_main_second"
                                                            class="btn btn-primary btn-sm mega_main_second_add_new_btn">Add
                                                            New</button>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- nepal tours end --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-start">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
        </form>
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/demo.form-advanced.js'])
@endsection

@push('backend-js')
    <script>
        // select2 reinitialize
        function selectReinitialize() {
            $('.select2').select2();
        }

        // click on icon
        $(document).on('click', '.mega_main_first_add_new', function() {
            let clickedRow = $(this).closest('.row');
            var button = $(this);
            var buttonId = button.data('id');
            var rowCount = parseInt($('#main_' + buttonId).val());
            let row = addRowData(button, buttonId, rowCount);
            clickedRow.after(row);
            updateMainFirstSerialNumber();
            selectReinitialize();
        });

        // click on button
        $(document).on('click', '.mega_main_first_add_new_btn', function() {
            var button = $(this);
            var buttonId = button.data('id');
            var rowCount = parseInt($('#main_' + buttonId).val());
            let row = addRowData(button, buttonId, rowCount);
            $('#' + buttonId).append(row);
            updateMainFirstSerialNumber();
            selectReinitialize();
        });

        //
        $('#mega_main_first').delegate('.mega_main_first_row_remove', 'click', function() {
            $(this).parent().parent().parent().remove();
            updateMainFirstSerialNumber();
        });

        // update field
        function updateMainFirstSerialNumber() {
            $('#mega_main_first .row').each(function(index) {
                let newIndex = index;
                $(this).find('select[name^="mega_main_first"]').each(function() {
                    let newName = $(this).attr('name').replace(/\[\d+\]/, '[' + newIndex + ']');
                    $(this).attr('name', newName);
                });
            });
        }

        function addRowData($button, $id, $rowCount) {
            let button = $button;
            let id = $id;
            let numberOfRow = $('#' + id + ' .row').length - 1;
            let options = '';
            let tours = '';

            options = '<option selected disabled>Select</option>';
            @foreach (\App\Models\Category::where('type', 'region')->get() as $tour)
                options += `<option value="{{ $tour->id }}">{{ $tour->name }}</option>`;
            @endforeach

            @foreach (\App\Models\Post::where('post_type', 'tour')->get() as $tour)
                tours += `<option value="{{ $tour->id }}">{{ $tour->post_title }}</option>`;
            @endforeach

            let html = `
            <div class="row mb-2">

                <div class="col-sm-3">
                    <select class="form-control select2" data-toggle="select2" name="mega_main_first[${numberOfRow + 1}][title]">
                        ${options}
                    </select>
                </div>

                <div class="col-sm-7">
                    <select class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" name="mega_main_first[${numberOfRow + 1}][packages][]">
                        ${tours}
                    </select>
                </div>
                <div class="col-sm-2">
                    <div class="text-center">
                        <a href="javascript:void(0);" data-id="1" class="text-reset fs-16 px-1 mega_main_first_add_new">
                            <i class="bi bi-plus-circle"></i>
                        </a>
                        <a href="javascript:void(0);" data-id="1" class="text-reset fs-16 px-1 mega_main_first_row_remove">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        `;
            return html;
        }
    </script>
@endpush
