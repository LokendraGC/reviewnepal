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
                    <div class="tab-pane {{ !request()->has('tab') || request()->query('tab') == 'general' ? 'show active' : '' }}"
                        id="general">


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
