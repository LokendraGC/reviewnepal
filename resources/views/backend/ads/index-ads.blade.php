@extends('layouts.vertical', ['page_title' => 'Ads Management', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                    <h4 class="page-title">Ads Management</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <form action="{{ route('backend.ads.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="nav  nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link {{ !request()->has('tab') || request()->query('tab') == 'header-advertisements' ? 'active' : '' }}"
                                            id="header-advertisements-tab" data-bs-toggle="pill" href="#header-advertisements" role="tab"
                                            aria-controls="header-advertisements"
                                            aria-selected="{{ request()->query('tab') == 'header-advertisements' ? 'true' : 'false' }}"
                                            tabindex="-1">
                                            Header
                                        </a>
                                        <a class="nav-link {{ request()->query('tab') == 'homepage' ? 'active' : '' }}"
                                            id="homepage-tab" data-bs-toggle="pill" href="#homepage" role="tab"
                                            aria-controls="homepage"
                                            aria-selected="{{ request()->query('tab') == 'homepage' ? 'true' : 'false' }}"
                                            tabindex="-1">
                                            Home Page
                                        </a>
                                        <a class="nav-link {{ request()->query('tab') == 'news-single' ? 'active' : '' }}"
                                            id="news-single-tab" data-bs-toggle="pill" href="#news-single" role="tab"
                                            aria-controls="news-single"
                                            aria-selected="{{ request()->query('tab') == 'news-single' ? 'true' : 'false' }}"
                                            tabindex="-1">
                                            Single News Page    
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-12">
                                    <div class="tab-content" id="v-pills-tabContent">

                                        @include('backend.ads.header-ads')

                                        @include('backend.ads.homepage-ads')

                                        @include('backend.ads.news-single-ads')

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
                                <button type="submit" class="btn btn-outline-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <livewire:backend.medias />

    </div>
    <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/media.js'])
@endsection


@push('backend-js')
    <script>
        // tab url
        document.addEventListener('DOMContentLoaded', function() {

            const tabs = document.querySelectorAll('a.nav-link');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = tab.getAttribute('href').substr(1);
                    const urlParams = new URLSearchParams(window.location.search);
                    urlParams.set('tab', tabId);
                    const newUrl = window.location.pathname + '?' + urlParams.toString();
                    history.pushState({}, '', newUrl);
                });
            });
        });
    </script>
@endpush