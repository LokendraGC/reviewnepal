@extends('layouts.vertical', ['page_title' => 'Edit Page', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/select2/dist/css/select2.min.css', 'node_modules/daterangepicker/daterangepicker.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css'])
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Edit Page</h4>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('backend.page.update', $post->id) }}">
            @csrf
            <div class="row">
                <div class="col-md-9">
                    {{-- main content --}}
                    <x-backend.post.main-section :title="$post->post_title" :slug="$post->slug" :content="$post->post_content" />

                    {{-- excerpt --}}
                    <x-backend.post.excerpt :content="$post->post_excerpt" />


                    {{-- template view --}}
                    <div id="append-fields">
                        {!! $view !!}
                    </div>


                    {{-- SEO --}}
                    <x-backend.seo.seo-section :metaDatas="$metaDatas" />
                </div>
                <input type="hidden" id="pageID" value="{{ $post->id }}" />
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-12 order-last order-sm-first">
                            {{-- publish / submit --}}
                            <x-backend.post.status :post="$post" route="/" button="Update" />
                        </div>
                        <div class="col-12">
                            {{-- featured image --}}
                            <x-backend.post.featured-image :metaDatas="$metaDatas" />
                        </div>
                        <div class="col-12">
                            @php
                                $homeId = SettingHelper::get_home_id();
                            @endphp
                            @if ($homeId != $post->id)
                                {{-- page attributes --}}
                                <div class="card">
                                    <div class="card-body">
                                        <div class="page_attributes">
                                            <h5 class="card-title fs-18 mb-3">Page Attributes</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Parent</label>
                                                <select class="form-select" id="post_parent" name="post_parent">
                                                    <option value="0">No Parent</option>
                                                    @foreach ($pages as $page)
                                                        <option value="{{ $page->id }}"
                                                            @if ($post->post_parent == $page->id) selected @endif>
                                                            {{ $page->post_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Template</label>
                                                <select class="form-select" id="choose_template" name="page_template">
                                                    @foreach (\App\Enums\TemplateType::getKeyValuePairs() as $label => $value)
                                                        @if ($value != 'home')
                                                            <option value="{{ $value }}"
                                                                @if (isset($metaDatas['page_template']) && $value == $metaDatas['page_template']) selected
                                                    @elseif (!isset($metaDatas['page_template']) && $value == 'default')
                                                        selected @endif>
                                                                {{ $label }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <input name="page_template"
                                    value="{{ isset($metaDatas['page_template']) ? $metaDatas['page_template'] : 'default' }}"
                                    type="hidden" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <livewire:backend.medias />
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/demo.form-advanced.js'])
    @vite(['resources/js/media.js'])
@endsection

@section('script-bottom')
    <script>
        jQuery('#choose_template').on('change', function(e) {
            e.preventDefault();
            const selectedTemplate = $(this).val();
            const id = $('#pageID').val();

            $.ajax({
                url: '{{ route('backend.get.editTemplate') }}',
                data: {
                    template: selectedTemplate,
                    pageID: id,
                },
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    $('#append-fields').html(response.data);
                    $('.select2').select2();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
