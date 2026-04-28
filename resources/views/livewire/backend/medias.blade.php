<div>
    <style>
        .pagi p.small.text-muted {
            display: none;
        }
    </style>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-block d-sm-flex justify-content-between align-items-center gap-5"
                    style="justify-content: space-between">
                    <div class="d-flex d-sm-block" style="justify-content: space-between">
                        <ul class="nav nav-pills gap-2" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button wire:click="reloadMedia" class="nav-link active choose__file" id="tab1-tab"
                                    data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab"
                                    aria-controls="tab1" aria-selected="true">Choose
                                    File</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link choose__file" id="tab2-tab" data-bs-toggle="tab"
                                    data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2"
                                    aria-selected="false">Upload
                                    New</button>
                            </li>
                        </ul>
                        <div class="d-sm-none">
                            <button wire:click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="mt-2 mt-sm-0 flex-fill">
                        <input type="text" wire:model.live.debounce.250ms="search" class="form-control"
                            placeholder="Search...">
                    </div>
                    <div class="d-none d-sm-block">
                        <a href="javascript:void(0);" wire:click="reloadMedia" class="btn btn-info me-3 d-none">
                            <i class="ri-refresh-line"></i> Refresh
                        </a>
                        <button wire:click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body" id="go_to_media_body">
                    {{-- @if ($openModal == 'true') --}}
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                            aria-labelledby="tab1-tab">
                            <div class="scroll-container">
                                <div class="row">
                                    @php
                                        if ($editedMedia) {
                                            $mainCol = 'col-md-7 order-2';
                                            $innerCol = 'col-6 col-sm-6 col-lg-4 col-xl-3';
                                        } else {
                                            $mainCol = 'col-12';
                                            $innerCol = 'col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2';
                                        }
                                    @endphp
                                    <div class="{{ $mainCol }}">
                                        {{-- <div class="row overflow-auto" style="max-height: 500px;"> --}}
                                        <div class="row">
                                            @foreach ($medias as $media)
                                                <div class="{{ $innerCol }}">
                                                    <div class="media-manager-box"
                                                        data-selected="{{ in_array($media->id, $selectedMedia) ? 'true' : 'false' }}"
                                                        wire:click="toggleSelect({{ $media->id }})"
                                                        data-id="{{ $media->id }}" onclick="toggleSelect(this)">
                                                        <div class="card uploader-select" style="cursor: pointer;">
                                                            <div class="card-body text-center file-preview box p-2">
                                                                <img loading="lazy"
                                                                    src="{{ asset('storage/' . $media->file_name) }}"
                                                                    class="card-img-top img-thumbnail img-fluid"
                                                                    alt="" />
                                                                <div class="col body">
                                                                    <h6 class="d-flex justify-content-center">
                                                                        <span
                                                                            class="text-truncate title">{{ $media->file_original_name }}</span>
                                                                        <span
                                                                            class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                                                    </h6>
                                                                    {{-- <p class="mb-0">{{ MediaHelper::getKBorMB($media->file_size) }} --}}
                                                                </div>
                                                                <div class="row-action text-center">
                                                                    <span class="edit">
                                                                        <a href="javascript:void(0)"
                                                                            onclick="event.stopPropagation();"
                                                                            wire:click="editMedia({{ $media->id }})"
                                                                            class="text-primary">Edit</a>
                                                                    </span>
                                                                    <span class="delete">
                                                                        |
                                                                        <a href="javascript:void(0)" class="text-danger"
                                                                            wire:click="deleteMedia({{ $media->id }})"
                                                                            onclick="event.stopPropagation();"
                                                                            wire:confirm.prompt="Are you sure?\n\nType DELETE to confirm|DELETE">Delete</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if ($editedMedia)
                                        <div class="col-md-5 order-1">
                                            <div class="media-manager-box">
                                                <div class="card uploader-select" style="cursor: pointer;">
                                                    <div class="card-body text-center pb-1">
                                                        <img loading="lazy"
                                                            src="{{ asset('storage/' . $editedMedia->file_name) }}"
                                                            class="card-img-top img-thumbnail img-fluid"
                                                            alt="" />
                                                    </div>
                                                    <div class="card-footer pt-0">
                                                        <h6 class="text-center">
                                                            <span
                                                                class="title">{{ $editedMedia->file_original_name }}.{{ $editedMedia->extension }}</span>
                                                        </h6>
                                                        <h6 class="text-center">
                                                            {{-- <span class="title">{{ $editedMedia->file_size }}</span> --}}
                                                            <span
                                                                class="title">{{ MediaHelper::getKBorMB($editedMedia->file_size) }}</span>
                                                        </h6>
                                                        <form wire:submit="editedMediaSubmit({{ $editedMedia->id }})">
                                                            <div class="mb-1">
                                                                <label for="" class="form-label">Alt</label>
                                                                <input type="text" class="form-control"
                                                                    wire:model="alt" />
                                                            </div>
                                                            <div class="mb-1">
                                                                <label for=""
                                                                    class="form-label">Description</label>
                                                                <textarea class="form-control" wire:model="description" rows="2"></textarea>
                                                            </div>
                                                            <div class="mb-1">
                                                                <label for=""
                                                                    class="form-label">Caption</label>
                                                                <input type="text" class="form-control"
                                                                    wire:model="caption" />
                                                            </div>
                                                            <div class="mb-1">
                                                                <label for="" class="form-label">URL</label>
                                                                <input readonly disabled type="text"
                                                                    class="form-control"
                                                                    value="{{ asset('storage/' . $editedMedia->file_name) }}">
                                                            </div>
                                                            <div class="text-center">
                                                                <button class="btn btn-primary btn-sm"
                                                                    type="submit">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                            @if ($medias->count() < $totalMedia)
                                <div class="d-flex justify-content-center my-2 pagi">
                                    {{-- <button class="btn btn-primary btn-sm" wire:click="loadMore">View More</button> --}}
                                    {{ $medias->links() }}
                                </div>
                            @endif

                            <div class="">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary me-2" data-bs-dismiss="modal"
                                        id="selectFiles">Select</button>
                                </div>
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
                                    {{-- <div class="text-center">
                                        <button class="btn btn-primary btn-md" wire:click="reloadMedia" wire:ignore
                                            type="submit">Reload Media</button>
                                    </div> --}}
                            </form>

                        </div>
                    </div>
                    {{-- @endif --}}
                </div>
                {{-- <div class="modal-footer mt-3">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary me-2" data-bs-dismiss="modal"
                            id="selectFiles">Select</button>
                    </div>
                </div> --}}

                {{-- {{ $files }} --}}
            </div>
        </div>
    </div>
</div>

{{-- scripts for livewire --}}
@script
    <script>
        $(document).ready(function() {
            $('.open-media-manager').click(function() {
                setTimeout(function() {
                    var select = $('body').attr('data-select');
                    var files = $('body').attr('data-ids');
                    @this.set('select', select);
                    @this.set('selectedMedia', files.split(','));
                    @this.set('openModal', 'true');
                }, 200);
            });

            $('.choose__file').click(function() {
                // Disable the button
                $(this).prop('disabled', true).addClass('disabled');

                // Re-enable the button after 1 second
                setTimeout(() => {
                    $(this).prop('disabled', false).removeClass('disabled');
                }, 5000);
            });
        });
    </script>
@endscript

@push('backend-js')
    <script>
        function toggleSelect(element) {

            // get media single or multiple
            var body = document.querySelector('body');
            var dataSelect = body.getAttribute('data-select');

            const isSelected = element.getAttribute('data-selected') === 'true';
            element.setAttribute('data-selected', isSelected ? 'false' : 'true');

            if (dataSelect == 'single') {
                if (!isSelected) {
                    const allElements = document.querySelectorAll('.media-manager-box');
                    allElements.forEach(el => {
                        if (el !== element) el.setAttribute('data-selected', 'false');
                    });
                }
            }
        }
    </script>
@endpush
