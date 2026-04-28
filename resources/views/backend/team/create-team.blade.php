@extends('layouts.vertical', ['page_title' => 'Add New Team', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/select2/dist/css/select2.min.css', 'node_modules/daterangepicker/daterangepicker.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css'])
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Add New Team</h4>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('backend.store.team') }}">
            @csrf
            <div class="row">
                <div class="col-md-9">

                    {{-- main content --}}
                    <x-backend.post.main-section />

                    {{-- excerpt --}}
                    {{-- <x-backend.post.excerpt /> --}}

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-2 d-flex align-content-center border-1 border-bottom">
                                        <h4 class="header-title">Single Team Builder</h4>
                                    </div>
                                    <div class="tab-heading">
                                        <ul class="nav nav-tabs mb-3">
                                            <li class="nav-item">
                                                <a href="#general" data-bs-toggle="tab"
                                                    aria-expanded="{{ !request()->has('tab') || request()->query('tab') == 'general' ? 'true' : 'false' }}"
                                                    class="nav-link {{ !request()->has('tab') || request()->query('tab') == 'general' ? 'active' : '' }}">
                                                    General
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane {{ !request()->has('tab') || request()->query('tab') == 'general' ? 'show active' : '' }}"
                                            id="general">
                                            <div class="mb-3">
                                                <label class="form-label" for="product-order">Order</label>
                                                <input name="menu_order" type="number" class="form-control"
                                                    id="product-order" value="0" />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Designation</label>
                                                <input type="text" name="designation" class="form-control" />
                                            </div>
                                        </div>
                                        {{-- <div class="tab-pane {{ request()->query('tab') == 'best-seller' ? 'show active' : '' }}"
                                            id="best-seller"> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- seo --}}
                    {{-- <x-backend.seo.seo-section /> --}}
                </div>
                <input type="hidden" name="type" value="{{ $type }}" />
                <div class="col-md-3">
                    {{-- publish / submit --}}
                    <x-backend.post.status button="Submit" />

                    {{-- feature image --}}
                    <x-backend.post.featured-image />

                </div>
            </div>
        </form>
    </div>
    <livewire:backend.medias :multiple="false" :openModal="false" />
@endsection

@section('script')
    @vite(['resources/js/media.js'])
@endsection
