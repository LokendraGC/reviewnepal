<div class="tab-pane fade {{ request()->query('tab') == 'homepage' ? 'active show' : '' }}" id="homepage"
    role="tabpanel" aria-labelledby="homepage-tab">
    
    <small>Please Insert the URL by clicking on the browse button and edit the file description.</small>
    
    <div class="row">
        {{-- Recent News ads --}}
               <div class="mb-3 col-6">
            <div>
                <label for="above_recent_news_ad" class="form-label">Above Recent News Ads</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="above_recent_news_ad" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['above_recent_news_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['above_recent_news_ad'])->first())
                        )
                        <input type="hidden" id="above_recent_news_ad" name="above_recent_news_ad" class="selected-files"
                            value="{{ $settings['above_recent_news_ad'] }}">
                        <div id="above_recent_news_ad_select">
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
                                    <div class="remove"><button data-id="{{ $media->id }}" data-slug="above_recent_news_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="above_recent_news_ad" name="above_recent_news_ad" class="selected-files" value="" />
                        <div id="above_recent_news_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>
 
 
        <div class="mb-3 col-6">
            <div>
                <label for="homepage_banner_ads" class="form-label">Below Recent News Ads</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="homepage_banner_ads" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['banner_ads']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['banner_ads'])->first())
                        )
                        <input type="hidden" id="homepage_banner_ads" name="banner_ads" class="selected-files"
                            value="{{ $settings['banner_ads'] }}">
                        <div id="homepage_banner_ads_select">
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
                                    <div class="remove"><button data-id="{{ $media->id }}" data-slug="homepage_banner_ads"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="homepage_banner_ads" name="banner_ads" class="selected-files" value="" />
                        <div id="homepage_banner_ads_select"></div>
                    @endif
                </div>
            </div>
        </div>


        {{-- below Sports news --}}
        <div class="mb-3 col-6">
            <div>
                <label for="homepage_below_recent_news" class="form-label">Below Sports News</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="homepage_below_recent_news" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['below_recent_news']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['below_recent_news'])->first())
                        )
                        <input type="hidden" id="homepage_below_recent_news" name="below_recent_news" class="selected-files"
                            value="{{ $settings['below_recent_news'] }}">
                        <div id="homepage_below_recent_news_select">
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
                                            data-slug="homepage_below_recent_news"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="homepage_below_recent_news" name="below_recent_news" class="selected-files"
                            value="" />
                        <div id="homepage_below_recent_news_select"></div>
                    @endif
                </div>
            </div>
        </div>


        {{-- Lifestyles and Entertainment Insight --}}
        <div class="mb-3 col-6">
            <div>
                <label for="homepage_above_nepal_insights_ad" class="form-label">Above Lifestyles and Entertainment Ads</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="homepage_above_nepal_insights_ad" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['above_nepal_insights_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['above_nepal_insights_ad'])->first())
                        )
                        <input type="hidden" id="homepage_above_nepal_insights_ad" name="above_nepal_insights_ad"
                            class="selected-files" value="{{ $settings['above_nepal_insights_ad'] }}">
                        <div id="homepage_above_nepal_insights_ad_select">
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
                                            data-slug="homepage_above_nepal_insights_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="homepage_above_nepal_insights_ad" name="above_nepal_insights_ad"
                            class="selected-files" value="" />
                        <div id="homepage_above_nepal_insights_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>


        {{-- Sports News --}}
        <div class="mb-3 col-6">
            <div>
                <label for="homepage_below_nepal_insights_ad" class="form-label">Above Sports News Ads</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="homepage_below_nepal_insights_ad" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['below_nepal_insights_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['below_nepal_insights_ad'])->first())
                        )
                        <input type="hidden" id="homepage_below_nepal_insights_ad" name="below_nepal_insights_ad"
                            class="selected-files" value="{{ $settings['below_nepal_insights_ad'] }}">
                        <div id="homepage_below_nepal_insights_ad_select">
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
                                            data-slug="homepage_below_nepal_insights_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="homepage_below_nepal_insights_ad" name="below_nepal_insights_ad"
                            class="selected-files" value="" />
                        <div id="homepage_below_nepal_insights_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- homepage below trending news first --}}
        <div class="mb-3 col-6">
            <div>
                <label for="homepage_below_trending_news_first_ad" class="form-label">Below Trending News First
                    Ads (Short Head)</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="homepage_below_trending_news_first_ad" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['homepage_below_trending_news_first_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['homepage_below_trending_news_first_ad'])->first())
                        )
                        <input type="hidden" id="homepage_below_trending_news_first_ad"
                            name="homepage_below_trending_news_first_ad" class="selected-files"
                            value="{{ $settings['homepage_below_trending_news_first_ad'] }}">
                        <div id="homepage_below_trending_news_first_ad_select">
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
                                            data-slug="homepage_below_trending_news_first_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="homepage_below_trending_news_first_ad"
                            name="homepage_below_trending_news_first_ad" class="selected-files" value="" />
                        <div id="homepage_below_trending_news_first_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- below trending news second --}}
        <div class="mb-3 col-6">
            <div>
                <label for="homepage_below_trending_news_second_ad" class="form-label">Below Trending News Second
                    Ads (Short Head)</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="homepage_below_trending_news_second_ad" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['homepage_below_trending_news_second_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['homepage_below_trending_news_second_ad'])->first())
                        )
                        <input type="hidden" id="homepage_below_trending_news_second_ad"
                            name="homepage_below_trending_news_second_ad" class="selected-files"
                            value="{{ $settings['homepage_below_trending_news_second_ad'] }}">
                        <div id="homepage_below_trending_news_second_ad_select">
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
                                            data-slug="homepage_below_trending_news_second_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="homepage_below_trending_news_second_ad"
                            name="homepage_below_trending_news_second_ad" class="selected-files" value="" />
                        <div id="homepage_below_trending_news_second_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>


        {{-- Lifestyles and Entertainment Brands ad --}}
        <div class="mb-3 col-6">
            <div>
                <label for="above_brands_ad" class="form-label">Below Lifestyles and Entertainment Ad
                    </label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="above_brands_ad" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['above_brands_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['above_brands_ad'])->first())
                        )
                        <input type="hidden" id="above_brands_ad" name="above_brands_ad" class="selected-files"
                            value="{{ $settings['above_brands_ad'] }}">
                        <div id="above_brands_ad_select">
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
                                    <div class="remove"><button data-id="{{ $media->id }}" data-slug="above_brands_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="above_brands_ad" name="above_brands_ad" class="selected-files" value="" />
                        <div id="above_brands_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- above Business and Brands Ads --}}
        <div class="mb-3 col-6">
            <div>
                <label for="homepage_above_articles_ad" class="form-label">Above Business and Brands Ads</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="homepage_above_articles_ad" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['above_articles_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['above_articles_ad'])->first())
                        )
                        <input type="hidden" id="homepage_above_articles_ad" name="above_articles_ad" class="selected-files"
                            value="{{ $settings['above_articles_ad'] }}">
                        <div id="homepage_above_articles_ad_select">
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
                                            data-slug="homepage_above_articles_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="homepage_above_articles_ad" name="above_articles_ad" class="selected-files"
                            value="" />
                        <div id="homepage_above_articles_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>


          {{-- below Business and Brands Ads --}}
        <div class="mb-3 col-6">
            <div>
                <label for="below_business_ad" class="form-label">Below Business and Brands Ads</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="below_business_ad" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['below_business_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['below_business_ad'])->first())
                        )
                        <input type="hidden" id="below_business_ad" name="below_business_ad" class="selected-files"
                            value="{{ $settings['below_business_ad'] }}">
                        <div id="below_business_ad_select">
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
                                            data-slug="below_business_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="below_business_ad" name="below_business_ad" class="selected-files"
                            value="" />
                        <div id="below_business_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>

            {{-- below Tender and Notices Ads --}}
        <div class="mb-3 col-6">
            <div>
                <label for="below_tender_ad" class="form-label">Below Tender Ads</label>
                <div class="input-group open-media-manager" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    style="cursor: pointer;" data-field="below_tender_ad" data-select="single">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            Browse</div>
                    </div>
                    <div class="form-control file-amount">Choose File</div>
                </div>
                {{-- preview --}}
                <div class="preview-closer">
                    @if (
                            isset($settings['below_tender_ad']) &&
                            ($media = MediaHelper::getModel()->where('id', $settings['below_tender_ad'])->first())
                        )
                        <input type="hidden" id="below_tender_ad" name="below_tender_ad" class="selected-files"
                            value="{{ $settings['below_tender_ad'] }}">
                        <div id="below_tender_ad_select">
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
                                            data-slug="below_tender_ad"
                                            class="btn btn-sm btn-link remove-attachment" type="button"><i
                                                class="bi bi-x-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" id="below_tender_ad" name="below_tender_ad" class="selected-files"
                            value="" />
                        <div id="below_tender_ad_select"></div>
                    @endif
                </div>
            </div>
        </div>
         {{-- below Tender and Notices Ads end--}}

    </div>
</div>