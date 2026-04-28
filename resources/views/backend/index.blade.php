@extends('layouts.vertical', ['page_title' => 'Dashboard', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/daterangepicker/daterangepicker.css', 'node_modules/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css'])
@endsection

@section('content')
    @php
        $siteURL = SettingHelper::get_field('site_url');
    @endphp

    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row d-none">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form class="d-flex">
                            <div class="input-group">
                                <input type="text" class="form-control shadow border-0" id="dash-daterange" disabled>
                                <span class="input-group-text bg-success border-success text-white">
                                    <i class="ri-calendar-todo-fill fs-13"></i>
                                </span>
                            </div>
                            <a href="{{ url()->current() }}" class="btn btn-success ms-2 flex-shrink-0">
                                <i class="ri-refresh-line"></i> Refresh
                            </a>
                        </form>
                    </div>
                    {{-- <h4 class="page-title">Welcome, {{ auth()->user()->name }}</h4> --}}
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card cta-box overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mt-0 fw-normal cta-box-title">Welcome to the Admin Panel</h3>
                                <p><b>Dive in and experience the enhanced capabilities of our CMS. Enjoy seamless control
                                        and unleash your creativity. Let's make managing your content a breeze.</b></p>
                                {{-- <a href="https://webtechnepal.com/" target="_blank"
                                    class="link-success link-offset-3 fw-bold">Developed by Webtech Nepal <i
                                        class="ri-arrow-right-line"></i></a> --}}
                            </div>
                            <img class="ms-3" src="/images/svg/email-campaign.svg" width="92"
                                alt="Generic placeholder image">
                        </div>
                    </div>
                    <!-- end card-body -->
                </div>
            </div> <!-- end col -->
        </div>

        {{-- <div class="row d-none">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Users</h5>
                                <h3 class="my-3">54,214</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="text-muted fw-normal mt-0" title="Number of Orders">News</h5>
                                <h3 class="my-3">7,543</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Wikis</h5>
                                <h3 class="my-3">$9,254</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="text-muted fw-normal mt-0" title="Growth">Events</h5>
                                <h3 class="my-3">+ 20.6%</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


        {{-- <div class="row d-none">
            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Sessions by Browser</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item">Refresh Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div id="sessions-browser" class="apex-charts" data-colors="#16a7e9"></div>

                        <div class="mt-1 text-center">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><img class="ms-3 pe-1" src="/images/browsers/chrome.png"
                                        height="18" alt="chrome"><span class="align-middle">45.87%</span></li>
                                <li class="list-inline-item"><img class="ms-3 pe-1" src="/images/browsers/firefox.png"
                                        height="18" alt="chrome"><span class="align-middle">3.25%</span></li>
                                <li class="list-inline-item"><img class="ms-3 pe-1" src="/images/browsers/safari.png"
                                        height="18" alt="chrome"><span class="align-middle">9.68%</span></li>
                                <li class="list-inline-item"><img class="ms-3 pe-1" src="/images/browsers/web.png"
                                        height="18" alt="chrome"><span class="align-middle">36.87%</span></li>
                            </ul>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Sessions by Operating System</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item">Refresh Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div id="sessions-os" class="apex-charts mt-2" data-colors="#16a7e9,#47ad77,#ffc35a,#f15776">
                        </div>

                        <div class="row text-center mt-2">
                            <div class="col-6">
                                <h4 class="fw-normal">
                                    <span>8,285</span>
                                </h4>
                                <p class="text-muted mb-0">Online System</p>
                            </div>
                            <div class="col-6">
                                <h4 class="fw-normal">
                                    <span>3,534</span>
                                </h4>
                                <p class="text-muted mb-0">Offline System</p>
                            </div>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <div class="col-xl-4 col-lg-12">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Views Per Minute</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item">Refresh Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div id="views-min" class="apex-charts" data-colors="#16a7e9"></div>

                        <div class="table-responsive mt-3">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Page</th>
                                        <th>Views</th>
                                        <th>Bounce Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);"
                                                class="text-muted">/adminto/dashboard-analytics</a>
                                        </td>
                                        <td>25</td>
                                        <td>87.5%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);" class="text-muted">/attex/dashboard-crm</a>
                                        </td>
                                        <td>15</td>
                                        <td>21.48%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);" class="text-muted">/ubold/dashboard</a>
                                        </td>
                                        <td>10</td>
                                        <td>63.59%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

        </div> --}}

        {{-- <div class="row d-none">
            <div class="col-xxl-6">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Sessions by country</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Refresh Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-lg-7">
                                <div id="world-map-markers" class="mt-3 mb-3" style="height: 332px">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div id="country-chart" class="apex-charts" data-colors="#16a7e9"></div>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <div class="col-xxl-6">
                <div class="card card-h-100">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Sessions Overview</h4>
                        <ul class="nav d-none d-lg-flex">
                            <li class="nav-item">
                                <a class="nav-link text-muted" href="#">Today</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-muted" href="#">7d</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">15d</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-muted" href="#">1m</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-muted" href="#">1y</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="bg-light-subtle border-top border-bottom border-light">
                            <div class="row text-center">
                                <div class="col">
                                    <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i> Direct</p>
                                    <h3 class="fw-normal mb-3">
                                        <span>170k</span>
                                    </h3>
                                </div>
                                <div class="col">
                                    <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i> Organic Search</p>
                                    <h3 class="fw-normal mb-3">
                                        <span>12M <i class="ri-corner-right-up-fill text-success"></i></span>
                                    </h3>
                                </div>
                                <div class="col">
                                    <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i> Refferal</p>
                                    <h3 class="fw-normal mb-3">
                                        <span>8.27%</span>
                                    </h3>
                                </div>
                                <div class="col">
                                    <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i> Social</p>
                                    <h3 class="fw-normal mb-3">
                                        <span>69k <i class="ri-corner-right-down-line text-danger"></i></span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div>
                            <div id="sessions-overview" class="apex-charts" data-colors="#47ad77"></div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
        </div> --}}
        <!-- end row -->

        {{-- <div class="row d-none">
            <div class="col-12 col-md-7 mb-4 mb-md-0">
                @php
                    $posts = PostHelper::getModel()
                        ->where('post_type', '=', 'post')
                        ->where('post_status', '=', 'publish')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Recent News</h4>
                        <a href="{{ route('backend.post') }}" class="btn btn-sm btn-info">View All <i
                                class="ri-file-ppt-line ms-1"></i></a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                <thead class="border-top border-bottom bg-light-subtle border-light">
                                    <tr>
                                        <th class="py-1">Title</th>
                                        <th class="py-1">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>
                                                <span class="fw-600"> {{ $post->post_title }}</span>
                                                <br>
                                                <div class="row-action">
                                                    <span class="edit">
                                                        <a href="{{ route('backend.post.edit', $post->id) }}"
                                                            class="text-success">Edit</a>
                                                    </span>
                                                    <span class="view">
                                                        |
                                                        <a href="{{ $siteURL . '/news/' . $post->slug }}" target="_blank"
                                                            class="text-primary">View</a>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>{{ $post->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center d-none">
                            <a href="#!" class="text-primary text-decoration-underline fw-bold btn mb-2">View
                                All</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-5">
                @php
                    $posts = PostHelper::getModel()
                        ->where('post_type', '=', 'wiki')
                        ->where('post_status', '=', 'publish')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Recent Wikis</h4>
                        <a href="{{ route('backend.wiki') }}" class="btn btn-sm btn-info">View All <i
                                class="ri-newspaper-line ms-1"></i></a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-hover table-nowrap table-centered m-0">
                                <thead class="border-top border-bottom bg-light-subtle border-light">
                                    <tr>
                                        <th class="py-1">Title</th>
                                        <th class="py-1">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>
                                                <span class="fw-600"> {{ $post->post_title }}</span>
                                                <br>
                                                <div class="row-action">
                                                    <span class="edit">
                                                        <a href="{{ route('backend.post.edit', $post->id) }}"
                                                            class="text-success">Edit</a>
                                                    </span>
                                                    <span class="view">
                                                        |
                                                        <a href="{{ $siteURL . '/wiki/' . $post->slug }}" target="_blank"
                                                            class="text-primary">View</a>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>{{ $post->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center d-none">
                            <a href="#!" class="text-primary text-decoration-underline fw-bold btn mb-2">View
                                All</a>
                        </div>
                    </div>
                </div>
            </div>

        </div> --}}
        <!-- container -->
    @endsection

    @section('script')
        {{-- @vite(['resources/js/pages/demo.dashboard-analytics.js'])
        @vite(['resources/js/pages/demo.dashboard.js']) --}}
    @endsection
