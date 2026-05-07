@extends('layouts.vertical', ['page_title' => 'Edit Post', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
@vite(['node_modules/select2/dist/css/select2.min.css', 'node_modules/daterangepicker/daterangepicker.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css'])
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Edit Post</h4>
                <form action="{{ route('backend.post.update', $post->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            {{-- main content --}}
                            <x-backend.post.main-section :post="$post" :title="$post->post_title" :slug="$post->slug"
                                :content="$post->post_content" />

                            {{-- excerpt --}}
                            <x-backend.post.excerpt :content="$post->post_excerpt" />

                            @include('backend.posts.fields-post')

                            {{-- seo --}}
                            <x-backend.seo.seo-section :metaDatas="$metaDatas" />
                        </div>
                        <input type="hidden" name="pageID" value="{{ $post->id }}" />
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-12 order-last order-sm-first">
                                    {{-- publish / submit --}}
                                    <x-backend.post.status :post="$post" route="/" button="Update" />
                                </div>
                                <div class="col-12">
                                    {{-- featured image --}}
                                    <x-backend.post.featured-image :metaDatas="$metaDatas" required="true" />
                                </div>

                                <div class="col-12">
                                    {{-- categories --}}
                                    <x-backend.post.category title="Categories" name="categories[]" type="multiple"
                                        :categories="$categories" :post="$post" />
                                </div>

                                {{-- authors --}}
                                <x-backend.post.author title="Authors" name="authors[]" type="multiple"
                                    :authors="$authors" :post="$post" />
                            </div>
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