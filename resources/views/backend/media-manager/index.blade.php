<div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="nav nav-pills gap-2" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
                                type="button" role="tab" aria-controls="tab1" aria-selected="true">Select
                                File</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2"
                                type="button" role="tab" aria-controls="tab2" aria-selected="false">Upload
                                New</button>
                        </li>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                            aria-labelledby="tab1-tab">
                            @php
                                $ppm = 10;
                                $totalMedia = \App\Models\Media::count();
                            @endphp
                            <input type="hidden" id="ppm" value="{{ $ppm }}" />
                            <div class="scroll-container">
                                <div class="row row-cols-5 g-4" id="media-container"
                                    data-count="{{ ceil($totalMedia / $ppm) }}">
                                    @foreach (\App\Models\Media::latest()->take($ppm)->get() as $media)
                                        <div class="col media-manager-box" data-selected="false"
                                            data-id="{{ $media->id }}" onclick="toggleSelect(this)">
                                            <div class="card h-100 uploader-select" style="cursor: pointer;">
                                                <img src="{{ asset('storage/' . $media->file_name) }}"
                                                    class="card-img-top img-fluid w-100" alt="">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-center my-2">
                                <button id="loadmore-media" class="btn btn-primary btn-sm">Load More</button>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">

                            <form id="my-dropzone" action="/upload" class="dropzone" wire:ignore.self>
                                <div class="col-md-12">
                                    <h2 class="pb-3 mt-3">Upload Image</h2>
                                    <div class="mb-3">
                                        <div id="image" class="dropzone dz-clickable">
                                            <div class="dz-message needsclick">
                                                <br>Drop files here or click to upload.<br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="image-wrapper">
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <div class="d-flex justify-content-start">
                        <span id="fileSelectedCount">0 File Selected</span>
                        <button type="button" class="btn btn-secondary ms-2" id="clearButton">Clear</button>
                    </div> --}}
                    <div class="d-flex justify-content-center">
                        <!-- Pagination HTML -->
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary me-2" data-bs-dismiss="modal"
                            id="selectFiles">Select</button>
                    </div>
                </div>


                <!-- file preview template -->
                {{-- <div class="d-none" id="uploadPreviewTemplate">
                    <div class="card mt-1 mb-0 shadow-none border">
                        <div class="p-2">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light"
                                        alt="">
                                </div>
                                <div class="col ps-0">
                                    <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                                    <p class="mb-0" data-dz-size></p>
                                </div>
                                <div class="col-auto">
                                    <!-- Button -->
                                    <a href="" class="btn btn-link btn-lg text-danger" data-dz-remove>
                                        <i class="ri-close-line"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
</div>

@push('backend-js')
    <script>
        function toggleSelect(element) {
            const isSelected = element.getAttribute('data-selected') === 'true';
            element.setAttribute('data-selected', isSelected ? 'false' : 'true');

            if (!isSelected) {
                const allElements = document.querySelectorAll('.media-manager-box');
                allElements.forEach(el => {
                    if (el !== element) el.setAttribute('data-selected', 'false');
                });
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#loadmore-media').click(function() {
                var page = 2;
                var button = $(this);
                var ppm = jQuery('#ppm').val();
                var offset = ppm;
                var post_count = jQuery('#media-container').data('count');
                console.log(post_count)
                $.ajax({
                    url: '/load-more-media', // Update with your route
                    type: 'GET',
                    data: {
                        offset: offset,
                        limit: ppm,
                    },
                    beforeSend: function(xhr) {
                        button.text('Loading...');
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            var html =
                                ''; // Initialize an empty string to store HTML for new media items
                            response.forEach(function(item) {
                                var imageUrl = "{{ asset('storage') }}/" + item
                                    .file_name;
                                html +=
                                    '<div class="col media-manager-box" data-selected="false" data-id="' +
                                    item.id + '" onclick="toggleSelect(this)">';
                                html +=
                                    '<div class="card h-100 uploader-select" style="cursor: pointer;">';
                                html += '<img src="' + imageUrl +
                                    '" class="card-img-top img-fluid w-100" alt="">';
                                html += '</div></div>';
                            });
                            $('#media-container').append(
                                html); // Append new media items to the container
                            offset += response.length; // Update the offset
                            button.text('Load More');

                            if (page == post_count) {
                                button.remove();
                            }
                        } else {
                            $('#loadmore-media').remove(); // Hide the button if no more data
                        }
                        page = page + 1;
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
