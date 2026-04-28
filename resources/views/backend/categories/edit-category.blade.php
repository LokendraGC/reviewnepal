@extends('layouts.vertical', ['page_title' => 'Edit Category', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
@endsection

@php
    $siteURL = SettingHelper::get_field('site_url');
@endphp

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Edit Category</h4>
                        <form method="POST" action="{{ route('backend.category.update', $category->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="category-name">Name<span
                                                        class="text-danger">*</span></label>
                                                <input name="name" type="text" class="form-control" id="category-name"
                                                    value="{{ $category->name }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback d-block ">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="category-slug">Slug</label>
                                                <input name="slug" type="text" class="form-control" id="category-slug"
                                                    value="{{ $category->slug }}" />
                                            </div>
                                            <div class="mb-3" style="max-width: max-content;">
                                                <label class="form-label" for="category-parent">Parent Destination</label>
                                                <select name="parent" class="form-select" id="category-parent">
                                                    <option value="0">None</option>
                                                    @isset($categories)
                                                        @foreach ($categories as $c)
                                                            <option value="{{ $c->id }}"
                                                                @if ($category->parent == $c->id) selected @endif>
                                                                {{ $c->name }}
                                                            </option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="category-description">Description</label>
                                                <textarea name="description" class="form-control" id="category-description" rows="5">{{ $category->description }}</textarea>
                                            </div>
                                            <div class="mb-2">
                                                <label for="excerpt" class="form-label">Featured Image<span
                                                        class="form-text text-muted">
                                                        {{-- <small><i>(Recommended Size: 768x450)</i></small> --}}
                                                    </span>
                                                </label>
                                                <div class="image-wrapper">
                                                    <div class="input-group open-media-manager" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal" style="cursor: pointer;"
                                                        data-field="featured_image" data-select="single">
                                                        <div class="input-group-prepend">
                                                            <div
                                                                class="input-group-text bg-soft-secondary font-weight-medium">
                                                                Browse</div>
                                                        </div>
                                                        <div class="form-control file-amount">Choose File</div>
                                                    </div>
                                                    <div class="preview-closer">
                                                        @if (isset($metaDatas['featured_image']) &&
                                                                ($media = MediaHelper::getModel()->where('id', $metaDatas['featured_image'])->first()))
                                                            <input type="hidden" id="featured_image" name="featured_image"
                                                                class="selected-files"
                                                                value="{{ $metaDatas['featured_image'] }}">
                                                            <div id="featured_image_select">
                                                                <div class="file-preview box sm">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                                        <div
                                                                            class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                                            <img class="img-fit"
                                                                                src="{{ asset('storage/' . $media->file_name) }}"
                                                                                alt="image" />
                                                                        </div>
                                                                        <div class="col body">
                                                                            <h6 class="d-flex">
                                                                                <span
                                                                                    class="text-truncate title">{{ $media->file_original_name }}</span>
                                                                                <span
                                                                                    class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                                                            </h6>
                                                                            <p>{{ MediaHelper::getKBorMB($media->file_size) }}
                                                                        </div>
                                                                        <div class="remove"><button
                                                                                data-id="{{ $media->id }}"
                                                                                data-slug="featured_image"
                                                                                class="btn btn-sm btn-link remove-attachment"
                                                                                type="button"><i
                                                                                    class="bi bi-x-circle"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <input type="hidden" id="featured_image" name="featured_image"
                                                                class="selected-files" value="" />
                                                            <div id="featured_image_select"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            {{-- seo --}}
                                            <x-backend.seo.seo-section :metaDatas="$metaDatas" />
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="catID" value="{{ $category->id }}" />
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between ">
                                                <p class="">
                                                    <a class="btn btn-outline-primary"
                                                        href="{{ $siteURL . '/category/' . $category->slug }}"
                                                        target="_blank">View</a>
                                                </p>
                                                <p>
                                                    <input class="btn btn-primary" type="submit" value="Update" />
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <livewire:backend.medias />
    </main>
@endsection

@section('script')
    @vite(['resources/js/media.js'])
@endsection
