@extends('layouts.vertical', ['page_title' => 'Add New Page', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/select2/dist/css/select2.min.css', 'node_modules/daterangepicker/daterangepicker.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css'])
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Add New Page</h4>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('backend.store.page') }}">
            @csrf
            <div class="row">
                <div class="col-md-9">

                    {{-- main content --}}
                    <x-backend.post.main-section />

                    {{-- excerpt --}}
                    <x-backend.post.excerpt />


                    {{-- append fields as per choose template --}}
                    <div id="append-fields"></div>


                    {{-- seo --}}
                    <x-backend.seo.seo-section />
                </div>
                <input type="hidden" name="type" value="{{ $type }}" />
                <div class="col-md-3">
                    {{-- publish / submit --}}
                    <x-backend.post.status button="Submit" />

                    {{-- feature image --}}
                    <x-backend.post.featured-image />

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
                                            <option value="{{ $page->id }}">{{ $page->post_title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Template</label>
                                    <select class="form-select" id="choose_template" name="page_template">
                                        @foreach (\App\Enums\TemplateType::getKeyValuePairs() as $label => $value)
                                            @if ($value != 'home')
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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

@section('script-bottom')
    <script>
        jQuery('#choose_template').on('change', function(e) {
            e.preventDefault();
            const selectedTemplate = $(this).val();

            $.ajax({
                url: '{{ route('backend.get.template') }}',
                data: {
                    template: selectedTemplate,
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
