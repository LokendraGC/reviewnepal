<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-2 d-flex align-content-center border-1 border-bottom">
                    <h4 class="header-title">Single Post Builder</h4>
                </div>
                <div class="tab-heading">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a href="#general" data-bs-toggle="tab"
                                aria-expanded="{{ !request()->has('tab') || request()->query('tab') == 'general' ? 'true' : 'false' }}"
                                class="nav-link {{ !request()->has('tab') || request()->query('tab') == 'general' ? 'active' : '' }}">
                                General
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="#breaking-news" data-bs-toggle="tab"
                                aria-expanded="{{ request()->query('tab') == 'breaking-news' ? 'true' : 'false' }}"
                                class="nav-link {{ request()->query('tab') == 'breaking-news' ? 'active' : '' }}">
                                Breaking News
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#wiki" data-bs-toggle="tab"
                                aria-expanded="{{ request()->query('tab') == 'wiki' ? 'true' : 'false' }}"
                                class="nav-link {{ request()->query('tab') == 'wiki' ? 'active' : '' }}">
                                Wiki
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#video" data-bs-toggle="tab"
                                aria-expanded="{{ request()->query('tab') == 'video' ? 'true' : 'false' }}"
                                class="nav-link {{ request()->query('tab') == 'video' ? 'active' : '' }}">
                                Video
                            </a>
                        </li> --}}
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade {{ !request()->has('tab') || request()->query('tab') === 'general' ? 'active show' : '' }}"
                        id="general" role="tabpanel">

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div
                                    class="d-flex align-items-center justify-content-between border rounded-3 px-3 py-3 bg-light-subtle">
                                    <div>
                                        <label for="show_banner" class="form-label fw-semibold mb-1">Show Banner on
                                            Homepage</label>
                                        <p class="text-muted mb-0 small">Enable this to display the banner on the
                                            homepage.</p>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input type="checkbox" class="form-check-input" id="show_banner"
                                            name="show_banner" value="1"
                                            {{ isset($metaDatas['show_banner']) && $metaDatas['show_banner'] == 1 ? 'checked' : '' }}
                                            style="width: 3rem; height: 1.5rem; cursor: pointer;" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="youtube_video_id">Youtube Video ID</label>
                                    <input name="youtube_video_id" type="text" class="form-control"
                                        id="youtube_video_id"
                                        value="{{ isset($metaDatas['youtube_video_id']) ? $metaDatas['youtube_video_id'] : '' }}">
                                    <small class="text-muted">Enter the video ID (e.g., dsGuSZYDNmk)</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
