@extends('layouts.vertical', ['page_title' => 'Add New Nepali Post', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/select2/dist/css/select2.min.css', 'node_modules/daterangepicker/daterangepicker.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css'])
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Add New Nepali Post</h4>
                    <form action="{{ route('backend.post_ne.store') }}" method="POST">
                        <input type="hidden" name="type" value="ne" />
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                {{-- main content --}}
                                <x-backend.post.main-section />

                                {{-- excerpt --}}
                                <x-backend.post.excerpt />

                                @include('backend.posts.fields-post')

                                {{-- seo --}}
                                <x-backend.seo.seo-section />
                            </div>
                            <div class="col-md-3">
                                {{-- publish / submit --}}
                                <x-backend.post.status button="Submit" />

                                {{-- feature image --}}
                                <x-backend.post.featured-image required="true" />

                                {{-- categories --}}
                                <x-backend.post.category title="Categories" name="categories[]" type="multiple"
                                    :categories="$categories" />

                                {{-- authors --}}
                                {{-- <x-backend.post.category title="Author" name="authors[]" type="single"
                                    :categories="$authors" /> --}}

                                {{-- tags --}}
                                {{-- <x-backend.post.category title="Tags" name="tags[]" type="multiple"
                                    :categories="$tags" custom="create_custom" /> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <livewire:backend.medias :multiple="false" :openModal="false" />
@endsection

@section('script')
    @vite(['resources/js/pages/demo.form-advanced.js'])
    @vite(['resources/js/media.js'])
@endsection

@push('backend-js')
    @include('backend.posts.post-js')
@endpush
