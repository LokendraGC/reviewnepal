@extends('layouts.vertical', ['page_title' => 'Edit Tag', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                        <form method="POST" action="{{ route('backend.tag.update', $category->id) }}">
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
                                            {{-- <div class="mb-3" style="max-width: max-content;">
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
                                            </div> --}}
                                            <div class="mb-3">
                                                <label class="form-label" for="category-description">Description</label>
                                                <textarea name="description" class="form-control" id="category-description" rows="5">{{ $category->description }}</textarea>
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
                                                        href="{{ $siteURL . '/tag/' . $category->slug }}"
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
    </main>
@endsection
