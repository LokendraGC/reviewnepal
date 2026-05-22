@extends('layouts.vertical', ['page_title' => 'Profile', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                    <h4 class="page-title">Profile Information</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <form action="{{ route('backend.setting.store') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_setting_context" value="banner_news">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="nav  nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link {{ !request()->has('tab') || request()->query('tab') == 'banner' ? 'active' : '' }}"
                                            id="banner-tab" data-bs-toggle="pill" href="#banner" role="tab"
                                            aria-controls="banner"
                                            aria-selected="{{ request()->query('tab') == 'banner' ? 'true' : 'false' }}"
                                            tabindex="-1">
                                            Banner News Details
                                        </a>

                                    </div>
                                </div>
                                <!-- end col-->
                                @csrf
                                <hr />
                                <div class="col-12">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        @include('backend.settings.tabs.banner-setting-repeater')
                                    </div> <!-- end tab-content-->
                                </div> <!-- end col-->
                            </div>
                            <!-- end row-->

                        </div>
                    </div> <!-- end card-->
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-start">
                                <button type="submit" class="btn btn-dark">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
        </form>
        <livewire:backend.medias />

    </div>
    <!-- container -->
    @include('backend.templates-pages.home.latest-news-repeater')
    @include('backend.templates-pages.home.latest-news-nepali-repeater')
@endsection



@section('script')
    @vite(['resources/js/media.js'])
@endsection
