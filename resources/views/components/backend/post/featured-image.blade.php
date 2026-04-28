<div class="card">
    <div class="card-body">
        <div>
            <label for="featured_image" class="form-label">Featured Image
                @if ($required)
                    <span class="text-danger">*</span>
                @endif
            </label>
            <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                style="cursor: pointer;" data-field="featured_image" data-select="single">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                        Browse</div>
                </div>
                <div class="form-control file-amount">Choose File</div>
            </div>
            <div class="preview-closer">
                @if (isset($metaDatas['featured_image']) &&
                        ($media = MediaHelper::getModel()->where('id', $metaDatas['featured_image'])->first()))
                    <input type="hidden" id="featured_image" name="featured_image" class="selected-files"
                        value="{{ $metaDatas['featured_image'] }}">
                    @error('featured_image')
                        <div class="valid-feedback d-block text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                    <div id="featured_image_select">
                        <div class="file-preview box sm">
                            <div class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                <div
                                    class="align-items-center align-self-stretch d-flex justify-content-center thumb h-auto">
                                    <img class="img-fit" src="{{ asset('storage/' . $media->file_name) }}"
                                        alt="image" />
                                </div>
                                <div class="col body">
                                    <h6 class="d-flex">
                                        <span class="text-truncate title">{{ $media->file_original_name }}</span>
                                        <span class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                    </h6>
                                    <p>{{ MediaHelper::getKBorMB($media->file_size) }}
                                </div>
                                <div class="remove"><button data-id="{{ $media->id }}" data-slug="featured_image"
                                        class="btn btn-sm btn-link remove-attachment" type="button"><i
                                            class="bi bi-x-circle"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" id="featured_image" name="featured_image" class="selected-files"
                        value="" />
                    @error('featured_image')
                        <div class="valid-feedback d-block ">
                            {{ $message }}
                        </div>
                    @enderror
                    <div id="featured_image_select"></div>
                @endisset
        </div>
    </div>
</div>
</div>
