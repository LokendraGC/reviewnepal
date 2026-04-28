<div class="tab-pane fade {{ request()->query('tab') == 'footer' ? 'active show' : '' }}" id="footer" role="tabpanel"
    aria-labelledby="footer-tab">
    <div class="mb-1">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="footer_logo" class="form-label">Footer Logo</label>
                    <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        style="cursor: pointer;" data-field="footer_logo" data-select="single">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                Browse</div>
                        </div>
                        <div class="form-control file-amount">Choose File</div>
                    </div>
                    <div class="preview-closer">
                        @if (isset($settings['footer_logo']) &&
                        ($media = MediaHelper::getModel()->where('id', $settings['footer_logo'])->first()))
                        <input type="hidden" id="footer_logo" name="footer_logo" class="selected-files"
                            value="{{ $settings['footer_logo'] }}">
                        <div id="footer_logo_select">
                            <div class="file-preview box sm">
                                <div
                                    class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                    <div
                                        class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                        <img class="img-fit" src="{{ asset('storage/' . $media->file_name) }}"
                                            alt="image" />
                                    </div>
                                    <div class="col body">
                                        <h6 class="d-flex">
                                            <span
                                                class="text-truncate title">{{ $media->file_original_name }}</span>
                                            <span class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                        </h6>
                                        <p>{{ MediaHelper::getKBorMB($media->file_size) }}
                                    </div>
                                    <div class="remove"><button data-id="{{ $media->id }}"
                                            data-slug="footer_logo" class="btn btn-sm btn-link remove-attachment"
                                            type="button"><i class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <input type="hidden" id="footer_logo" name="footer_logo" class="selected-files"
                            value="" />
                        <div id="footer_logo_select"></div>
                        @endisset
                    </div>
                      <span class="form-text text-muted">
                    <small><i>(Recommended Image in SVG format)</i></small>
                </span>
                
                </div>
            </div>
        </div>
    </div>

    <hr class="mt-0">

    <div class="mb-1">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="footer_logo_nepali" class="form-label">Footer Logo Nepali</label>
                    <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        style="cursor: pointer;" data-field="footer_logo_nepali" data-select="single">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                Browse</div>
                        </div>
                        <div class="form-control file-amount">Choose File</div>
                    </div>
                    <div class="preview-closer">
                        @if (isset($settings['footer_logo_nepali']) &&
                        ($media = MediaHelper::getModel()->where('id', $settings['footer_logo_nepali'])->first()))
                        <input type="hidden" id="footer_logo_nepali" name="footer_logo_nepali" class="selected-files"
                            value="{{ $settings['footer_logo_nepali'] }}">
                        <div id="footer_logo_nepali_select">
                            <div class="file-preview box sm">
                                <div
                                    class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                    <div
                                        class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                        <img class="img-fit" src="{{ asset('storage/' . $media->file_name) }}"
                                            alt="image" />
                                    </div>
                                    <div class="col body">
                                        <h6 class="d-flex">
                                            <span
                                                class="text-truncate title">{{ $media->file_original_name }}</span>
                                            <span class="flex-shrink-0 ext">.{{ $media->extension }}</span>
                                        </h6>
                                        <p>{{ MediaHelper::getKBorMB($media->file_size) }}
                                    </div>
                                    <div class="remove"><button data-id="{{ $media->id }}"
                                            data-slug="footer_logo_nepali" class="btn btn-sm btn-link remove-attachment"
                                            type="button"><i class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <input type="hidden" id="footer_logo_nepali" name="footer_logo_nepali" class="selected-files"
                            value="" />
                        <div id="footer_logo_nepali_select"></div>
                        @endisset
                    </div>
                      <span class="form-text text-muted">
                    <small><i>(Recommended Image in SVG format)</i></small>
                </span>
                
                </div>
            </div>
        </div>
    </div>

    <!-- <hr class="mt-0"> -->
    <!-- <div class="mb-3">
    <label for="copyright_text" class="form-label">Copyright Text</label>
    <p class="text-muted fs-14">
        <i><code style="cursor: pointer;">%copy%</code> is © <code style="cursor: pointer;">%year%</code> is Latest
            Date <code style="cursor: pointer;">%sitename%</code> is Site Title</i>
    </p>
    <textarea class="form-control" name="copyright_text" id="copyright_text" cols="30" rows="10">{{ isset($settings['copyright_text']) ? $settings['copyright_text'] : '' }}</textarea>
</div> -->
</div>