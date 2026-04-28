@extends('layouts.vertical', ['page_title' => 'General Settings', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">General Settings</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <form action="{{ route('backend.general.setting.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-2 row">
                                <label for="site_title" class="col-sm-3 col-form-label col-form-label-sm">Site Title<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control form-control-md" id="site_title"
                                        name="site_title"
                                        value="{{ isset($settings['site_title']) ? $settings['site_title'] : '' }}"
                                        required />
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="site_favicon" class="col-sm-3 col-form-label col-form-label-sm">Site
                                    Favicon</label>
                                <div class="col-sm-5">
                                    <div class="input-group open-media-manager" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" style="cursor: pointer;" data-field="site_favicon">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                Browse</div>
                                        </div>
                                        <div class="form-control file-amount">Choose File</div>
                                    </div>
                                    <div class="preview-closer">
                                        @if (isset($settings['site_favicon']) &&
                                                ($siteFavicon = MediaHelper::getModel()->where('id', $settings['site_favicon'])->first()))
                                            <input type="hidden" id="site_favicon" name="site_favicon"
                                                class="selected-files" value="{{ $settings['site_favicon'] }}">
                                            <div id="site_favicon_select">
                                                <div class="file-preview box sm">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                                        <div
                                                            class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                                            <img class="img-fit"
                                                                src="{{ asset('storage/' . $siteFavicon->file_name) }}"
                                                                alt="Site Favicon" />
                                                        </div>
                                                        <div class="col body">
                                                            <h6 class="d-flex">
                                                                <span
                                                                    class="text-truncate title">{{ $siteFavicon->file_original_name }}</span>
                                                                <span
                                                                    class="flex-shrink-0 ext">.{{ $siteFavicon->extension }}</span>
                                                            </h6>
                                                            <p>{{ MediaHelper::getKBorMB($siteFavicon->file_size) }}</p>
                                                        </div>
                                                        <div class="remove">
                                                            <button data-id="{{ $siteFavicon->id }}"
                                                                data-slug="site_favicon"
                                                                class="btn btn-sm btn-link remove-attachment"
                                                                type="button"><i class="bi bi-x-circle"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <input type="hidden" id="site_favicon" name="site_favicon"
                                                class="selected-files" value="" />
                                            <div id="site_favicon_select"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="admin_email_address"
                                    class="col-sm-3 col-form-label col-form-label-sm">Administration
                                    Email Address<span class="text-danger">*</span></label>
                                <div class="col-sm-5">
                                    <input type="email" class="form-control form-control-md" id="admin_email_address"
                                        value="{{ isset($settings['admin_email_address']) ? $settings['admin_email_address'] : '' }}"
                                        name="admin_email_address" required />
                                </div>
                            </div>
                            @role('Super Admin')
                                <div class="mb-2 row">
                                    <label for="admin_email_address" class="col-sm-3 col-form-label col-form-label-sm">Site
                                        URL<span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <input required type="text" class="form-control form-control-md" id="site_url"
                                            value="{{ $settings['site_url'] ?? null }}" name="site_url" required />
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label for="colFormLabel" class="col-sm-3 col-form-label">Select Homepage<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <select class="form-select" id="example-select" name="page_on_front" required>
                                            <option disabled selected>Select</option>
                                            @foreach ($pages as $page)
                                                <option @if ($pageId == $page->id) selected @endif
                                                    value="{{ $page->id }}">{{ $page->post_title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endrole
                            <button type="submit" class="mt-2 btn btn-primary btn-sm">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <livewire:backend.medias :multiple="false" :openModal="false" />
@endsection

@section('script')
    @vite(['resources/js/media.js'])
@endsection
