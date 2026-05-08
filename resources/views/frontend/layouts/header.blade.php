@if (request()->is('/'))

    @php
        $advertisement = SettingHelper::get_field('header_ads');
        $link = MediaHelper::getDescriptionById($advertisement);
        $websiteName = SettingHelper::get_field('site_title');

        if ($advertisement) {
            $media = MediaHelper::getImageById($advertisement);
            if (!empty($media->file_name)) {
                $image_url = asset('storage/' . $media->file_name);
            } else {
                $image_url = null;
            }
        }
    @endphp

    @if (!empty($image_url))
        <div class="container py-3">
            <div class="row">
                <div class="col-12">
                    <div class="ad-wrapper">
                        <span class="ad-label">- Advertisement -</span>

                        @if (!empty($link))
                            <a href="{{ $link }}" target="_blank">
                                <img src="{{ $image_url }}" alt="{{ $websiteName }}" class="ad-full-width">
                            </a>
                        @else
                            <img src="{{ $image_url }}" alt="{{ $websiteName }}" class="ad-full-width">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <hr style="border-color: #c7c7c7; margin: 0;">
@endif

@php
    $current_date = date('F d, Y');
    $nepali_date = NepaliDateHelper::toNepaliDate($current_date);
    $language = LanguageHelper::getUserLanguage();
    $checked = $language == 'ne' ? true : false;
@endphp

<header class="amko-header">
    <div class="header-top">
        <div class="header-right-actions d-none d-lg-block">
            <div class="header-date-container ">
                <i class="fa-regular fa-calendar-days"></i>
                <span id="current-date" class="date-text">{{ $checked ? $nepali_date : $current_date }}</span>
            </div>
        </div>


        @php
            $header_logo = SettingHelper::get_field('header_logo');
            $media = $header_logo ? MediaHelper::getImageById($header_logo) : null;
            $websiteName = SettingHelper::get_field('site_title');

            if (!empty($media) && !empty($media->file_name)) {
                $image_url = asset('storage/' . $media->file_name);
            } else {
                $image_url = asset('assets/images/reviewnepal-logo.svg');
            }

        @endphp



        <div class="header-logo">
            <a href="{{ '/' }}"><img src="{{ $image_url }}" alt="{{ $websiteName }}"></a>
        </div>

        <div class="header-left-actions">

            <button class="icon-btn d-none d-lg-block search-trigger-btn" aria-label="Search">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
            <div class="notification-wrapper">
                <button class="notification-btn icon-btn" aria-label="Notifications">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="notification-badge"></span>
                </button>

                @php
                    $language = LanguageHelper::getUserLanguage();
                    $postType = $language == 'ne' ? 'post_ne' : 'post';
                    $latestPosts = PostHelper::getModel()
                        ->where('post_type', $postType)
                        ->where('post_status', 'publish')
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp
                <div class="notification-dropdown">
                    <div class="dropdown-header-notify">
                        <h3>{{ $language == 'ne' ? 'ताजा समाचार' : 'NEWS ALERTS' }}</h3>
                    </div>

                    <div class="dropdown-alerts">
                        @forelse ($latestPosts as $post)
                            @php
                                $postUrl = route('frontend.post.index', $post->slug);
                                if ($language == 'ne') {
                                    $displayDate = NepaliDateHelper::toNepaliDate($post->created_at);
                                } else {
                                    $displayDate = $post->created_at->diffForHumans();
                                }
                            @endphp
                            <div class="alert-item unread">
                                <a href="{{ $postUrl }}" class="text-decoration-none">
                                    <p class="alert-title">{{ $post->post_title }}</p>
                                </a>
                                <p class="alert-meta">{{ $displayDate }}
                                    {{-- •{{ $language == 'ne' ? 'ब्रेकिङ न्यूज' : 'Breaking News' }} --}}
                                </p>
                            </div>
                        @empty
                            <div class="alert-item">
                                <p class="alert-title text-muted">
                                    {{ $language == 'ne' ? 'कुनै समाचार उपलब्ध छैन' : 'No alerts available' }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <button class="open-menu-btn icon-btn" aria-label="Menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            @php
                $language = LanguageHelper::getUserLanguage();
                $checked = $language == 'ne' ? true : false;
            @endphp
            <div class="language-toggle-container">
                <span class="toggle-label" id="lang-en">EN</span>

                <label class="switch" for="lang-toggle">
                    <input type="checkbox" id="lang-toggle" aria-labelledby="lang-en lang-np"
                        {{ $checked ? 'checked' : '' }}>
                    <span class="slider">
                        <span class="flag-icon"></span>
                    </span>
                </label>

                <span class="toggle-label" id="lang-np">NP</span>
            </div>

        </div>
    </div>
    {{-- <nav class="header-nav">
        <ul class="nav-list">
            <li class="nav-item-dropdown">
                <a href="#">News/Feature
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>

                <ul class="nav-dropdown-menu">
                    <li><a href="category.html">Political</a></li>
                    <li><a href="category.html">Economical</a></li>
                    <li><a href="category.html">Socio-Cultural</a></li>
                    <li><a href="category.html">Educational</a></li>
                    <li><a href="category.html">Diaspora</a></li>
                    <li><a href="category.html">Environmental</a></li>
                    <li><a href="category.html">Entertainment</a></li>
                    <li><a href="category.html">Veraties</a></li>
                </ul>
            </li>

            <li class="nav-item-dropdown">
                <a href="#">Sports
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>

                <ul class="nav-dropdown-menu">
                    <li><a href="category.html">Cricket</a></li>
                    <li><a href="category.html">Football</a></li>
                    <li><a href="category.html">Volleyball</a></li>
                </ul>
            </li>
            <li class="nav-item-dropdown">
                <a href="#">Op-ed
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>

                <ul class="nav-dropdown-menu">
                    <li><a href="category.html">Articles</a></li>
                    <li><a href="category.html">Interviews</a></li>
                </ul>
            </li>
            <li class="nav-item-dropdown">
                <a href="#">Market
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>

                <ul class="nav-dropdown-menu">
                    <li><a href="category.html">Brand Identity</a></li>
                    <li><a href="category.html">Products</a></li>
                    <li><a href="category.html">Service</a></li>
                </ul>
            </li>
            <li class="nav-item-dropdown">
                <a href="#">Announcement
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </a>

                <ul class="nav-dropdown-menu">
                    <li><a href="category.html">Public Notice</a></li>
                    <li><a href="category.html">Tender</a></li>

                </ul>
            </li>

        </ul>
    </nav> --}}

    @php
        $menu = CategoryHelper::getModel()
            ->where(['id' => 147, 'type' => 'nav_menu'])
            ->first();
    @endphp

    @if (!empty($menu))
        <nav class="header-nav">


            @include('frontend.layouts.header-menu', [
                'menu' => $menu,
            ])

        </nav>
    @endif

</header>
<div id="nav-overlay" class="nav-overlay">
    <div class="overlay-header">
        <div class="header-logo popup">
            <a href="{{ '/' }}"><img src="{{ $image_url }}" alt="{{ $websiteName }}"></a>
        </div>
        <button id="close-menu-btn" class="close-btn" aria-label="Close Menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="overlay-content">

        <div class="tabs-container d-lg-none">
            <button class="tab-trigger active" data-tab="mobile-categories">Categories</button>
            <p class="br-line type-vertical bg-line h23"></p>
            <button class="tab-trigger" data-tab="mobile-general">Menu</button>
        </div>
        <form class="form-search d-lg-none">
            <fieldset>
                <input type="search" placeholder="Search for products" value="" required="">
            </fieldset>
            <button type="submit" class="button-submit" aria-label="Submit">
                <i class="fa fa-search"></i>
            </button>
        </form>

        <div class="overlay-nav-wrapper">

            <div class="mobile-only-pane d-lg-none active" id="mobile-categories">


                @php
                    $headerMenu = CategoryHelper::getModel()
                        ->where(['id' => 147, 'type' => 'nav_menu'])
                        ->first();

                @endphp

                @if (!empty($headerMenu))
                    @include('frontend.layouts.header-mobile-menu', [
                        'menu' => $headerMenu,
                    ])
                @endif


                {{-- <ul class="overlay-nav-column">
                  
                    <li class="mobile-dropdown">
                        <a href="#" class="mobile-dropdown-toggle">
                            News/Features
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>
                        <ul class="mobile-dropdown-menu">
                            <li><a href="category.html">Political</a></li>
                            <li><a href="category.html">Economical</a></li>
                            <li><a href="category.html">Socio-Cultural</a></li>
                            <li><a href="category.html">Educational</a></li>
                            <li><a href="category.html">Diaspora</a></li>
                            <li><a href="category.html">Environmental</a></li>
                            <li><a href="category.html">Entertainment</a></li>
                            <li><a href="category.html">Veraties</a></li>

                        </ul>
                    </li>
                    <li class="mobile-dropdown">
                        <a class="mobile-dropdown-toggle" href="#">Sports
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>

                        <ul class="mobile-dropdown-menu">
                            <li><a href="category.html">Cricket</a></li>
                            <li><a href="category.html">Football</a></li>
                            <li><a href="category.html">Volleyball</a></li>
                        </ul>
                    </li>
                    <li class="mobile-dropdown">
                        <a class="mobile-dropdown-toggle" href="#">Op-ed
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>

                        <ul class="mobile-dropdown-menu">
                            <li><a href="category.html">Articles</a></li>
                            <li><a href="category.html">Interviews</a></li>
                        </ul>
                    </li>
                    <li class="mobile-dropdown">
                        <a class="mobile-dropdown-toggle" href="#">Market
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>

                        <ul class="mobile-dropdown-menu">
                            <li><a href="category.html">Brand Identity</a></li>
                            <li><a href="category.html">Products</a></li>
                            <li><a href="category.html">Service</a></li>
                        </ul>
                    </li>
                    <li class="mobile-dropdown">
                        <a class="mobile-dropdown-toggle" href="#">Announcement
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </a>

                        <ul class="mobile-dropdown-menu">
                            <li><a href="category.html">Public Notice</a></li>
                            <li><a href="category.html">Tender</a></li>

                        </ul>
                    </li>

                </ul> --}}



            </div>


            @php
                $menu = CategoryHelper::getModel()
                    ->where(['id' => 148, 'type' => 'nav_menu'])
                    ->first();
            @endphp

            @if (!empty($menu))
                <div class="general-menu-pane" id="mobile-general">
                    <div class="d-flex flex-row gap-lg-5">


                        @include('frontend.layouts.header-overlay-menu', [
                            'menu' => $menu,
                        ])

                    </div>
                </div>
            @endif

        </div>
    </div>

    <div class="overlay-footer">
        <div class="copyright">© {{ date('Y') }} {{ $websiteName }}. All rights reserved.</div>
    </div>
</div>

<div id="sticky-header-fixed" class="sticky-header-container">
    <div class="sticky-inner container">
        <div class="sticky-logo">
            <a href="{{ '/' }}"><img src="{{ $image_url }}" alt="{{ $websiteName }}"></a>
        </div>


        @php
            $headerMenu = CategoryHelper::getModel()
                ->where(['id' => 147, 'type' => 'nav_menu'])
                ->first();

        @endphp

        @if (!empty($headerMenu))
            <nav class="sticky-nav-links d-none d-lg-block">

                @include('frontend.layouts.header-menu', [
                    'menu' => $headerMenu,
                ])
            </nav>
        @endif


        {{-- <nav class="sticky-nav-links d-none d-lg-block">
            <ul class="nav-list">
                <li class="nav-item-dropdown">
                    <a href="#">News/Feature</a>
                    <ul class="nav-dropdown-menu">
                        <li><a href="category.html">Political</a></li>
                        <li><a href="category.html">Economical</a></li>
                        <li><a href="category.html">Socio-Cultural</a></li>
                        <li><a href="category.html">Educational</a></li>
                        <li><a href="category.html">Diaspora</a></li>
                        <li><a href="category.html">Environmental</a></li>
                        <li><a href="category.html">Entertainment</a></li>
                        <li><a href="category.html">Veraties</a></li>
                    </ul>
                </li>
                <li class="nav-item-dropdown">
                    <a href="#">Sports</a>
                    <ul class="nav-dropdown-menu">
                        <li><a href="category.html">Cricket</a></li>
                        <li><a href="category.html">Football</a></li>
                        <li><a href="category.html">Volleyball</a></li>
                    </ul>
                </li>
                <li class="nav-item-dropdown">
                    <a href="#">Op-ed</a>
                    <ul class="nav-dropdown-menu">
                        <li><a href="category.html">Brand Identity</a></li>
                        <li><a href="category.html">Products</a></li>
                        <li><a href="category.html">Service</a></li>
                    </ul>
                </li>
                <li class="nav-item-dropdown">
                    <a href="#">Market</a>
                    <ul class="nav-dropdown-menu">
                        <li><a href="category.html">Articles</a></li>
                        <li><a href="category.html">Interviews</a></li>
                    </ul>
                </li>
                <li class="nav-item-dropdown">
                    <a href="#">Announcement</a>
                    <ul class="nav-dropdown-menu">
                        <li><a href="category.html">Public Notice</a></li>
                        <li><a href="category.html">Tender</a></li>
                    </ul>
                </li>
            </ul>
        </nav> --}}

        <div class="sticky-right-actions">
            <button class="icon-btn d-none d-lg-block search-trigger-btn" aria-label="Search">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
            <div class="notification-wrapper  ">
                <button class="notification-btn icon-btn" aria-label="Notifications">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="notification-badge"></span>
                </button>

                <div class="notification-dropdown">
                    <div class="dropdown-header-notify">
                        <h4>NEWS ALERTS</h4>
                    </div>


                    <div class="dropdown-alerts">
                        <div class="alert-item unread">
                            <p class="alert-title">D.C. police sought to arrest Rep. Cory Mills (R-Florida) after
                                assault call,
                                records show</p>
                            <p class="alert-meta">Today at 3:04 PM • Breaking News</p>
                        </div>
                        <div class="alert-item unread">
                            <p class="alert-title">Iran says it's closing Strait of Hormuz again, citing U.S.
                                blockade
                            </p>
                            <p class="alert-meta">Yesterday at 7:20 AM • Breaking News</p>
                        </div>
                        <div class="alert-item unread">
                            <p class="alert-title">Satellite images show tankers loading Iranian oil amid U.S.
                                blockade
                            </p>
                            <p class="alert-meta">Friday at 1:08 PM • Breaking News</p>
                        </div>
                        <div class="alert-item unread">
                            <p class="alert-title">Iran says Strait of Hormuz to reopen amid push to end war; oil
                                prices quickly
                                fall</p>
                            <p class="alert-meta">Friday at 9:41 AM • Breaking News</p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="open-menu-btn icon-btn" aria-label="Menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
</div>

<div id="search-overlay" class="nav-overlay search-overlay d-none d-lg-block">
    <div class="overlay-header">
        <div class="header-logo popup">
            <a href="{{ '/' }}"><img src="{{ $image_url }}" alt="{{ $websiteName }}"></a>
        </div>
        <button id="close-search-btn" class="close-btn search-close-red" aria-label="Close Search">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="overlay-content search-content-center">
        <div class="search-form-container">
            <input type="text" id="search-input-main" placeholder="Search news and articles..." autofocus>
            <button type="submit" class="search-submit-arrow" aria-label="Submit search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </div>

</div>
