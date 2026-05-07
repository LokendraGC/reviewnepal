<div class="tab-pane fade {{ !request()->has('tab') || request()->query('tab') == 'header-ads' ? 'active show' : '' }}"
    id="header-ads" role="tabpanel" aria-labelledby="header-ads-tab">
    <div class="mb-3">
        <div class="col-12">
            <label for="header_ads" class="form-label">Header Ads</label>
            <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                style="cursor: pointer;" data-field="header_ads" data-select="single">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                        Browse</div>
                </div>
                <div class="form-control file-amount">Choose File</div>
            </div>
            {{-- preview --}}
            <div class="preview-closer">
                @if (isset($settings['header_ads']) &&
                        ($media = MediaHelper::getModel()->where('id', $settings['header_ads'])->first()))
                    <input type="hidden" id="header_ads" name="header_ads" class="selected-files"
                        value="{{ $settings['header_ads'] }}">
                    <div id="header_ads_select">
                        <div class="file-preview box sm">
                            <div class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                <div class="align-items-center align-self-stretch d-flex justify-content-center thumb">
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
                                <div class="remove"><button data-id="{{ $media->id }}" data-slug="header_ads"
                                        class="btn btn-sm btn-link remove-attachment" type="button"><i
                                            class="bi bi-x-circle"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" id="header_ads" name="header_ads" class="selected-files" value="" />
                    <div id="header_ads_select"></div>
                @endif
            </div>
        </div>
    </div>
</div>
