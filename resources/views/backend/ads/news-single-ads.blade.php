<div class="tab-pane fade {{ request()->query('tab') == 'news-single' ? 'active show' : '' }}" id="news-single"
    role="tabpanel" aria-labelledby="news-single-tab">

    <div class="row mb-3">
        <div class="col-6">
            <label for="single_above_title" class="form-label">Above Title
                Ads</label>
            <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                style="cursor: pointer;" data-field="single_above_title" data-select="single">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                        Browse</div>
                </div>
                <div class="form-control file-amount">Choose File</div>
            </div>
            {{-- preview --}}
            <div class="preview-closer">
                @if (isset($settings['single_above_title']) &&
                        ($media = MediaHelper::getModel()->where('id', $settings['single_above_title'])->first()))
                    <input type="hidden" id="single_above_title" name="single_above_title" class="selected-files"
                        value="{{ $settings['single_above_title'] }}">
                    <div id="single_above_title_select">
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
                                <div class="remove"><button data-id="{{ $media->id }}" data-slug="single_above_title"
                                        class="btn btn-sm btn-link remove-attachment" type="button"><i
                                            class="bi bi-x-circle"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" id="single_above_title" name="single_above_title" class="selected-files"
                        value="" />
                    <div id="single_above_title_select"></div>
                @endif
            </div>
        </div>
        <div class="col-6">
            <label for="single_below_title" class="form-label">Below Title
                Ads</label>
            <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                style="cursor: pointer;" data-field="single_below_title" data-select="single">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                        Browse</div>
                </div>
                <div class="form-control file-amount">Choose File</div>
            </div>
            {{-- preview --}}
            <div class="preview-closer">
                @if (isset($settings['single_below_title']) &&
                        ($media = MediaHelper::getModel()->where('id', $settings['single_below_title'])->first()))
                    <input type="hidden" id="single_below_title" name="single_below_title" class="selected-files"
                        value="{{ $settings['single_below_title'] }}">
                    <div id="single_below_title_select">
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
                                <div class="remove"><button data-id="{{ $media->id }}"
                                        data-slug="single_below_title" class="btn btn-sm btn-link remove-attachment"
                                        type="button"><i class="bi bi-x-circle"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" id="single_below_title" name="single_below_title" class="selected-files"
                        value="" />
                    <div id="single_below_title_select"></div>
                @endif
            </div>
        </div>
    </div>
    <hr>

    <div class="row mb-3">
        {{-- below trending news first --}}
        <div class="col-6">
            <div>
                <label for="single_news_below_trending_news_first_ad" class="form-label">Below Trending News First
                    Ads</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="single_news_below_trending_news_first_ad" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (isset($settings['single_news_below_trending_news_first_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['single_news_below_trending_news_first_ad'])->first()))
                        <input type="hidden" id="single_news_below_trending_news_first_ad"
                            name="single_news_below_trending_news_first_ad" class="selected-files"
                            value="{{ $settings['single_news_below_trending_news_first_ad'] }}">
                        <div id="single_news_below_trending_news_first_ad_select">
                            <div class="file-preview box sm">
                                <div class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                    <div
                                        class="align-items-center align-self-stretch d-flex justify-content-center thumb">
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
                                    <div class="remove"><button data-id="{{ $media->id }}"
                                            data-slug="single_news_below_trending_news_first_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="single_news_below_trending_news_first_ad"
                            name="single_news_below_trending_news_first_ad" class="selected-files" value="" />
                        <div id="single_news_below_trending_news_first_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- below trending news second --}}
        <div class="col-6">
            <div>
                <label for="single_news_below_trending_news_second_ad" class="form-label">Below Trending News Second
                    Ads</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="single_news_below_trending_news_second_ad"
                    data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (isset($settings['single_news_below_trending_news_second_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['single_news_below_trending_news_second_ad'])->first()))
                        <input type="hidden" id="single_news_below_trending_news_second_ad"
                            name="single_news_below_trending_news_second_ad" class="selected-files"
                            value="{{ $settings['single_news_below_trending_news_second_ad'] }}">
                        <div id="single_news_below_trending_news_second_ad_select">
                            <div class="file-preview box sm">
                                <div class="d-flex justify-content-between align-items-center mt-2 file-preview-item">
                                    <div
                                        class="align-items-center align-self-stretch d-flex justify-content-center thumb">
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
                                    <div class="remove"><button data-id="{{ $media->id }}"
                                            data-slug="single_news_below_trending_news_second_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="single_news_below_trending_news_second_ad"
                            name="single_news_below_trending_news_second_ad" class="selected-files" value="" />
                        <div id="single_news_below_trending_news_second_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <hr>
    {{--  inner ads --}}
    <div class="row mb-3">
        <div class="col-6">
            <label for="below_featured_image_ad" class="form-label">Below Featured Image Ads</label>
            <div class="row g-3">
                <div>
                    <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        style="cursor: pointer;" data-field="below_featured_image_ad" data-select="single">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                Browse</div>
                        </div>
                        <div class="form-control file-amount">Choose File</div>
                    </div>
                    {{-- preview --}}
                    <div class="preview-closer">
                        @if (isset($settings['below_featured_image_ad']) &&
                                ($media = MediaHelper::getModel()->where('id', $settings['below_featured_image_ad'])->first()))
                            <input type="hidden" id="below_featured_image_ad" name="below_featured_image_ad"
                                class="selected-files" value="{{ $settings['below_featured_image_ad'] }}">
                            <div id="below_featured_image_ad_select">
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
                                                data-slug="below_featured_image_ad"
                                                class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                    class="bi bi-x-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <input type="hidden" id="below_featured_image_ad" name="below_featured_image_ad"
                                class="selected-files" value="" />
                            <div id="below_featured_image_ad_select"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <label for="single_below_content" class="form-label">Below Content
                Ads</label>
            <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                style="cursor: pointer;" data-field="single_below_content" data-select="single">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                        Browse</div>
                </div>
                <div class="form-control file-amount">Choose File</div>
            </div>
            {{-- preview --}}
            <div class="preview-closer">
                @if (isset($settings['single_below_content']) &&
                        ($media = MediaHelper::getModel()->where('id', $settings['single_below_content'])->first()))
                    <input type="hidden" id="single_below_content" name="single_below_content"
                        class="selected-files" value="{{ $settings['single_below_content'] }}">
                    <div id="single_below_content_select">
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
                                <div class="remove"><button data-id="{{ $media->id }}"
                                        data-slug="single_below_content" class="btn btn-sm btn-link remove-attachment"
                                        type="button"><i class="bi bi-x-circle"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <input type="hidden" id="single_below_content" name="single_below_content"
                        class="selected-files" value="" />
                    <div id="single_below_content_select"></div>
                @endif
            </div>
        </div>
    </div>

</div>
