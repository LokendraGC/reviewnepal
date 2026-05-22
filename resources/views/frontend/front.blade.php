@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $postMeta, 'title' => $post->post_title])

@section('main-section')

    <main>

      
        {{-- RECENT POSTS START --}}
        @php
            $recent_posts_meta =
                $language == 'en' ? SettingHelper::get_field('latest_news_details') : SettingHelper::get_field('latest_news_details_ne');

            $recent_posts_meta = $recent_posts_meta ? unserialize($recent_posts_meta) : [];

            // Extract only IDs and filter falsy values
            $recent_post_ids = collect($recent_posts_meta)->pluck('post_id')->filter()->toArray();

            // If no IDs provided, return empty collection to avoid SQL errors
            if (!empty($recent_post_ids)) {
                // Preserve order
                $ids_order = implode(',', $recent_post_ids);

                $recent_posts = PostHelper::getModel()
                    ->whereIn('id', $recent_post_ids)
                    ->orderByRaw("FIELD(id, $ids_order)")
                    ->get();
            } else {
                $recent_posts = collect();
            }
        @endphp


        @if (!empty($recent_posts) && count($recent_posts) > 0)
      
        {{-- BEFORE RECENT NEWS AD START --}}
        @php
            $above_recent_news_ad = SettingHelper::get_field('above_recent_news_ad');
            $link = MediaHelper::getDescriptionById($above_recent_news_ad);
            $websiteName = SettingHelper::get_field('site_title');

            if ($above_recent_news_ad) {
                $media = MediaHelper::getImageById($above_recent_news_ad);
                if (!empty($media->file_name)) {
                    $before_image_url = asset('storage/' . $media->file_name);
                } else {
                    $before_image_url = null;
                }
            }
        @endphp

        @if (!empty($before_image_url))
            <div class="container py-3">
                <div class="row">
                    <div class="col-12">
                        <div class="ad-wrapper">
                            <span class="ad-label">- Advertisement -</span>

                            @if (!empty($link))
                                <a href="{{ $link }}" target="_blank">
                                    <img src="{{ $before_image_url }}" alt="{{ $websiteName }}" class="ad-full-width">
                                </a>
                            @else
                                <img src="{{ $before_image_url }}" alt="{{ $websiteName }}" class="ad-full-width">
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- BEFORE RECENT NEWS AD END --}}


            @foreach ($recent_posts as $recent_post)
                <section class="container my-5">



                    <div class="news-header-section">
                        <h2 class="main-headline">
                            <a
                                href="{{ route('frontend.post.index', $recent_post->slug) }}">{{ $recent_post->post_title }}</a>
                        </h2>

                        @php
                            $author = $recent_post->categories()->where('categories.type', 'author')->first();

                            $author_meta = $author ? $author->GetAllMetaData() : [];

                            if ($language == 'en') {
                                $author_name = $author->name ?? ($user->name ?? 'Review Nepal');
                            } else {
                                $author_name = $author_meta['name_ne'] ?? ($user->name ?? 'Review Nepal');
                            }

                            $featured_image = isset($author_meta['featured_image'])
                                ? $author_meta['featured_image']
                                : null;
                            $media = $featured_image ? MediaHelper::getImageById($featured_image) : null;
                            if (!empty($featured_image) && !empty($media?->file_name)) {
                                $featured_image_url = asset('storage/' . $media->file_name);
                            } else {
                                $featured_image_url = null;
                            }
                        @endphp

                        <div class="news-meta">
                            <div class="d-flex align-items-center">
                                @if (!empty($featured_image_url))
                                    <img src="{{ $featured_image_url }}" alt="{{ $author_name }}" class="meta-logo me-2">
                                @endif
                                <span class="meta-author">
                                    <i class="fa-regular fa-user-circle"></i>
                                    {{ $author_name }}
                                </span>
                            </div>
                            <span><i class="fa-regular fa-calendar-days"></i>
                                {{ $language == 'en' ? $recent_post->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($recent_post->created_at) }}</span>
                        </div>
                    </div>

                    <div class="featured-image-container">

                        @php
                            $itemMeta = $recent_post->GetAllMetaData();
                            $featured_image = $itemMeta['featured_image'] ?? null;
                            $show_banner = $itemMeta['show_banner'] ?? '0';

                            $media = $featured_image ? MediaHelper::getImageById($featured_image) : null;

                            if (!empty($featured_image) && !empty($media?->file_name)) {
                                $featured_image_url = asset('storage/' . $media->file_name);
                            } elseif (!empty($itemMeta['youtube_video_id'])) {
                                $featured_image_url =
                                    'https://img.youtube.com/vi/' . $itemMeta['youtube_video_id'] . '/hqdefault.jpg';
                            } else {
                                $featured_image_url = null;
                            }
                        @endphp

                        @if ($show_banner == '1')
                            @if (!empty($itemMeta['youtube_video_id']))
                                <div class="main-featured-video mb-4">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="https://www.youtube.com/embed/{{ $itemMeta['youtube_video_id'] }}"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen></iframe>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('frontend.post.index', $recent_post->slug) }}">

                                    @if ($featured_image_url)
                                        <img src="{{ $featured_image_url }}" alt="{{ $recent_post->post_title }}"
                                            class="featured-image">
                                    @endif
                                </a>
                            @endif
                        @endif                        
                        <p class="banner-description">
                            {{ \Illuminate\Support\Str::words(html_entity_decode(strip_tags($recent_post->post_content)), 40) }}
                         </p>                   
                    </div>
                </section>
            @endforeach
        @endif
        {{-- RECENT POSTS END --}}

        {{-- TOP ADVERTISEMENT START --}}
        @php
            $banner_ads = SettingHelper::get_field('banner_ads');
            $link = MediaHelper::getDescriptionById($banner_ads);
            $websiteName = SettingHelper::get_field('site_title');

            if ($banner_ads) {
                $media = MediaHelper::getImageById($banner_ads);
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
        {{-- TOP ADVERTISEMENT END --}}

        {{-- NEWS AND FEATURES CATEGORY START --}}
        @if (!empty($news_n_features_posts) && $news_n_features_posts->count() > 0)
            <section class="container py-3 morning-hero-section">
                @if (!empty($news_n_features_cat))
                    <div class="mb-4">
                        <div class="category-title-flex section-header">
                            <h2 class="m-0">
                                <a href="{{ route('frontend.category.index', $news_n_features_cat->slug) }}"
                                    style="color: inherit; text-decoration: none;">
                                    {{ $language == 'en' ? $news_n_features_cat->name : $news_n_features_cat->GetAllMetaData()['name_ne'] ?? $news_n_features_cat->name }}
                                </a>
                            </h2>
                            
                             <div class="child-categories-wrapper">
                            <div class="child-categories-list">
                                @foreach ($news_n_features_cat->children as $child)
                                    @php
                                        $childMeta = $child->GetAllMetaData();
                                        $childName =
                                            $language == 'en' ? $child->name : $childMeta['name_ne'] ?? $child->name;
                                    @endphp
                                    <a href="{{ route('frontend.category.index', $child->slug) }}"
                                        class="child-category-link">
                                        {{ $childName }}
                                    </a>
                                    @if (!$loop->last)
                                        <span class="child-cat-divider">|</span>
                                    @endif
                                @endforeach
                            </div>
                            
                            <a href="{{ route('frontend.category.index', $news_n_features_cat->slug) }}"
                                class="category-circle-btn">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            
                            </div>
                            
                            
                        </div>
                    </div>
                @endif

                <div class="morning-container">
                    <div class="hero-left-col">
                        @foreach ($news_n_features_posts->slice(0, 4) as $post_item)
                            @php
                                $cate = $post_item->categories()->first();
                                $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                                $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                                $itemMeta = $post_item->GetAllMetaData();

                                // POST IMAGE
                                $post_image_id = $itemMeta['featured_image'] ?? null;
                                $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;
                                if (!empty($post_media?->file_name)) {
                                    $post_image_url = asset('storage/' . $post_media->file_name);
                                } elseif (!empty($itemMeta['youtube_video_id'])) {
                                    $post_image_url =
                                        'https://img.youtube.com/vi/' .
                                        $itemMeta['youtube_video_id'] .
                                        '/hqdefault.jpg';
                                } else {
                                    $post_image_url = null;
                                }

                                // AUTHOR
                                $author = $post_item->categories()->where('categories.type', 'author')->first();
                                $author_meta = $author ? $author->GetAllMetaData() : [];
                                if ($language == 'en') {
                                    $author_name = $author->name ?? ($user->name ?? 'Review Nepal');
                                } else {
                                    $author_name = $author_meta['name_ne'] ?? ($user->name ?? 'Review Nepal');
                                }
                            @endphp

                            {{-- FIRST POST (PRIMARY DESIGN) --}}
                            @if ($loop->first)
                                <div class="hero-primary-grid">
                                    <div class="primary-content">
                                        <span class="story-tag">{{ $cat_name }}</span>
                                        <h1 class="primary-title">
                                            <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                                {{ $post_item->post_title }}
                                            </a>
                                        </h1>
                                        <p class="primary-excerpt">
                                            {{ \Illuminate\Support\Str::words(html_entity_decode(strip_tags($post_item->post_content)), 40) }}
                                        </p>
                                        <div class="story-meta">
                                            <span class="author">{{ $author_name }}</span>
                                            <span
                                                class="date">{{ $language == 'en' ? $post_item->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($post_item->created_at) }}</span>
                                        </div>
                                    </div>
                                    <div class="primary-image-wrapper">
                                        @if ($post_image_url)
                                            <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                                <img src="{{ $post_image_url }}" alt="{{ $post_item->post_title }}">
                                            </a>
                                        @else
                                            <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                                <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                                    alt="{{ $post_item->post_title }}">
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                {{-- START secondary grid container AFTER first item --}}
                                @if ($loop->count > 1)
                                    <div class="hero-secondary-grid">
                                @endif
                            @else
                                {{-- OTHER POSTS (SECONDARY DESIGN) --}}
                                <article class="bottom-card">
                                    @if ($post_image_url)
                                        <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                            <img src="{{ $post_image_url }}" alt="{{ $post_item->post_title }}">
                                        </a>
                                    @else
                                        <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                            <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                                alt="{{ $post_item->post_title }}">
                                        </a>
                                    @endif
                                    <h3 class="card-title">
                                        <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                            {{ $post_item->post_title }}
                                        </a>
                                    </h3>
                                    <div class="story-meta">
                                        <span class="author">{{ $author_name }}</span>
                                        <span
                                            class="date">{{ $language == 'en' ? $post_item->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($post_item->created_at) }}</span>
                                    </div>
                                </article>
                            @endif

                            {{-- CLOSE secondary grid at last --}}
                            @if ($loop->last && !$loop->first)
                    </div>
        @endif
        @endforeach
        </div>

        @if ($news_n_features_posts->count() > 4)
            <div class="hero-right-col">
                @foreach ($news_n_features_posts->slice(4) as $post_item)
                    @php
                        // CATEGORY
                        $cate = $post_item->categories()->first();
                        $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                        $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                        // POST META
                        $itemMeta = $post_item->GetAllMetaData();

                        // IMAGE
                        $post_image_id = $itemMeta['featured_image'] ?? null;
                        $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;
                        if (!empty($post_media?->file_name)) {
                            $post_image_url = asset('storage/' . $post_media->file_name);
                        } elseif (!empty($itemMeta['youtube_video_id'])) {
                            $post_image_url =
                                'https://img.youtube.com/vi/' . $itemMeta['youtube_video_id'] . '/hqdefault.jpg';
                        } else {
                            $post_image_url = null;
                        }

                        $author = $post_item->categories()->where('categories.type', 'author')->first();
                        $author_meta = $author ? $author->GetAllMetaData() : [];
                        $author_name =
                            $language == 'en'
                                ? $author->name ?? ($user->name ?? 'Review Nepal')
                                : $author_meta['name_ne'] ?? ($user->name ?? 'Review Nepal');
                    @endphp

                    {{-- FIRST POST (FEATURED IN SIDEBAR) --}}
                    @if ($loop->first)
                        <article class="sidebar-featured">
                            @if ($post_image_url)
                                <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                    <img src="{{ $post_image_url }}" alt="{{ $post_item->post_title }}">
                                </a>
                            @else
                                <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                    <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                        alt="{{ $post_item->post_title }}">
                                </a>
                            @endif
                            <span class="story-tag">{{ $cat_name }}</span>
                            <h3 class="sidebar-featured-title">
                                <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                    {{ $post_item->post_title }}
                                </a>
                            </h3>
                            <div class="story-meta">
                                <span class="author">{{ $author_name }}</span>
                                <span
                                    class="date">{{ $language == 'en' ? $post_item->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($post_item->created_at) }}</span>
                            </div>
                        </article>

                        {{-- START LIST --}}
                        @if ($loop->count > 1)
                            <div class="sidebar-list">
                        @endif
                    @else
                        {{-- LIST ITEMS --}}
                        <article class="list-item">
                            @if ($post_image_url)
                                <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                    <img src="{{ $post_image_url }}" alt="{{ $post_item->post_title }}">
                                </a>
                            @else
                                <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                    <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                        alt="{{ $post_item->post_title }}">
                                </a>
                            @endif
                            <div class="list-content">
                                <span class="story-tag">{{ $cat_name }}</span>
                                <h4 class="list-title" style="text-wrap: wrap; line-height: 1rem;">
                                    <a href="{{ route('frontend.post.index', $post_item->slug) }}">
                                        {{ $post_item->post_title }}
                                    </a>
                                </h4>
                            </div>
                        </article>
                    @endif

                    {{-- CLOSE LIST --}}
                    @if ($loop->last && !$loop->first)
            </div>
        @endif
        @endforeach
        </div>
        @endif
        </div>
        </section>
        @endif
        {{-- NEWS AND FEATURES CATEGORY END --}}

        {{-- SPORTS ADVERTISEMENT START --}}
        @php
            $above_sports_ad = SettingHelper::get_field('above_sports_ad');
            $link = MediaHelper::getDescriptionById($above_sports_ad);

            if ($above_sports_ad) {
                $media = MediaHelper::getImageById($above_sports_ad);
                if (!empty($media->file_name)) {
                    $below_nepal_insights_image_url = asset('storage/' . $media->file_name);
                } else {
                    $below_nepal_insights_image_url = null;
                }
            }
        @endphp

        @if (!empty($below_nepal_insights_image_url))
            <hr style="border-color: #c7c7c7; margin: 0;">
            <div class="container py-3">
                <div class="row">
                    <div class="col-12">
                        <div class="ad-wrapper">
                            <span class="ad-label">- Advertisement -</span>
                            @if (!empty($link))
                                <a href="{{ $link }}" target="_blank">
                                    <img src="{{ $below_nepal_insights_image_url }}" alt="{{ $websiteName }}"
                                        class="ad-full-width">
                                </a>
                            @else
                                <img src="{{ $below_nepal_insights_image_url }}" alt="{{ $websiteName }}"
                                    class="ad-full-width">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- SPORTS ADVERTISEMENT END --}}

        {{-- SPORTS START --}}
        @if ($sports_cat_posts->count() > 0 && !empty($sports_cat_posts))
            <div class="container py-5">

                @if (!empty($sports_cat))
                    <div class="mb-4">
                        <div class="category-title-flex section-header">
                            <h2 class="m-0">
                                <a href="{{ route('frontend.category.index', $sports_cat->slug) }}"
                                    style="color: inherit; text-decoration: none;">
                                    {{ $language == 'en' ? $sports_cat->name : $sports_cat->GetAllMetaData()['name_ne'] ?? $sports_cat->name }}
                                </a>
                            </h2>
                            
                            <div class="child-categories-wrapper">
                            <div class="child-categories-list">
                                @foreach ($sports_cat->children as $child)
                                    @php
                                        $childMeta = $child->GetAllMetaData();
                                        $childName =
                                            $language == 'en' ? $child->name : $childMeta['name_ne'] ?? $child->name;
                                    @endphp
                                    <a href="{{ route('frontend.category.index', $child->slug) }}"
                                        class="child-category-link">
                                        {{ $childName }}
                                    </a>
                                    @if (!$loop->last)
                                        <span class="child-cat-divider">|</span>
                                    @endif
                                @endforeach
                            </div>
                            
                             <a href="{{ route('frontend.category.index', $sports_cat->slug) }}"
                                class="category-circle-btn">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            
                            </div>
                            
                            
                           
                        </div>
                    </div>
                @endif

                <div class="row gy-5">

                    @foreach ($sports_cat_posts as $fourth_post)
                        @php
                            // CATEGORY
                            $cate = $fourth_post->categories()->first();
                            $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                            $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                            // POST META
                            $itemMeta = $fourth_post->GetAllMetaData();

                            // IMAGE
                            $post_image_id = $itemMeta['featured_image'] ?? null;
                            $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;

                            if (!empty($post_media?->file_name)) {
                                $post_image_url = asset('storage/' . $post_media->file_name);
                            } elseif (!empty($itemMeta['youtube_video_id'])) {
                                $post_image_url =
                                    'https://img.youtube.com/vi/' . $itemMeta['youtube_video_id'] . '/hqdefault.jpg';
                            } else {
                                $post_image_url = null;
                            }

                            $author = $fourth_post->categories()->where('categories.type', 'author')->first();

                            $author_meta = $author ? $author->GetAllMetaData() : [];

                            $author_name =
                                $language == 'en'
                                    ? $author->name ?? ($user->name ?? 'Review Nepal')
                                    : $author_meta['name_ne'] ?? ($user->name ?? 'Review Nepal');

                        @endphp
                        <div class="col-md-6">
                            <a href="{{ route('frontend.post.index', $fourth_post->slug) }}" class="featured-article">
                                <div class="featured-content">
                                    <h3 class="featured-title">
                                        {{ $fourth_post->post_title }}
                                    </h3>
                                    <div class="featured-meta">
                                        <span class="meta-category">{{ $cat_name }}</span>
                                        <span class="meta-divider">|</span>
                                        <span>{{ $language == 'en' ? $fourth_post->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($fourth_post->created_at) }}</span>
                                    </div>
                                </div>
                                @if ($post_image_url)
                                    <img src="{{ $post_image_url }}" alt="{{ $fourth_post->post_title }}"
                                        class="featured-img">
                                @else
                                    <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                        alt="{{ $fourth_post->post_title }}" class="featured-img">
                                @endif
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif
        {{-- SPORTS END --}}


        {{-- MIDDLE ADVERTISEMENT START --}}
        @php
            $below_sports_news = SettingHelper::get_field('below_sports_news');
            $link = MediaHelper::getDescriptionById($below_sports_news);
            $websiteName = SettingHelper::get_field('site_title');

            if ($below_sports_news) {
                $media = MediaHelper::getImageById($below_sports_news);
                if (!empty($media->file_name)) {
                    $below_recent_image_url = asset('storage/' . $media->file_name);
                } else {
                    $below_recent_image_url = null;
                }
            }
        @endphp

        @if (!empty($below_recent_image_url))
            <div class="container py-3">
                <div class="row">
                    <div class="col-12">
                        <div class="ad-wrapper">
                            <span class="ad-label">- Advertisement -</span>
                            @if (!empty($link))
                                <a href="{{ $link }}" target="_blank">
                                    <img src="{{ $below_recent_image_url }}" alt="{{ $websiteName }}"
                                        class="ad-full-width">
                                </a>
                            @else
                                <img src="{{ $below_recent_image_url }}" alt="{{ $websiteName }}"
                                    class="ad-full-width">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- MIDDLE ADVERTISEMENT END --}}


        {{-- VIEWS AND OPINION SECTION START --}}
        @if ($views_n_opinion_posts->count() > 0 && !empty($views_n_opinion_posts) && !empty($views_n_opinion_cat))
            <div class="container py-5">

                  @if (!empty($views_n_opinion_cat))
                    <div class="mb-4">
                        <div class="category-title-flex section-header">
                            <h2 class="m-0">
                                <a href="{{ route('frontend.category.index', $views_n_opinion_cat->slug) }}"
                                    style="color: inherit; text-decoration: none;">
                                    {{ $language == 'en' ? $views_n_opinion_cat->name : $views_n_opinion_cat->GetAllMetaData()['name_ne'] ?? $views_n_opinion_cat->name }}
                                </a>
                            </h2>
                            
                            <div class="child-categories-wrapper">
                            <div class="child-categories-list">
                                @foreach ($views_n_opinion_cat->children as $child)
                                    @php
                                        $childMeta = $child->GetAllMetaData();
                                        $childName =
                                            $language == 'en' ? $child->name : $childMeta['name_ne'] ?? $child->name;
                                    @endphp
                                    <a href="{{ route('frontend.category.index', $child->slug) }}"
                                        class="child-category-link">
                                        {{ $childName }}
                                    </a>
                                    @if (!$loop->last)
                                        <span class="child-cat-divider">|</span>
                                    @endif
                                @endforeach
                            </div>
                            
                             <a href="{{ route('frontend.category.index', $views_n_opinion_cat->slug) }}"
                                class="category-circle-btn">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            
                            </div>
                            
                            
                           
                        </div>
                    </div>
                @endif

                <div class="row justify-content-between">

                    {{-- VIEWS AND OPINION COLUMN START --}}
                    @if ($views_n_opinion_posts->count() > 0 && !empty($views_n_opinion_posts))
                        <div class="col-lg-7">


                            @foreach ($views_n_opinion_posts as $third_post)
                                @php
                                    // CATEGORY
                                    $cate = $third_post->categories()->first();
                                    $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                                    $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                                    // POST META
                                    $itemMeta = $third_post->GetAllMetaData();

                                    // IMAGE
                                    $post_image_id = $itemMeta['featured_image'] ?? null;
                                    $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;

                                    if (!empty($post_media?->file_name)) {
                                        $post_image_url = asset('storage/' . $post_media->file_name);
                                    } elseif (!empty($itemMeta['youtube_video_id'])) {
                                        $post_image_url =
                                            'https://img.youtube.com/vi/' .
                                            $itemMeta['youtube_video_id'] .
                                            '/hqdefault.jpg';
                                    } else {
                                        $post_image_url = null;
                                    }

                                    $author = $third_post->categories()->where('categories.type', 'author')->first();

                                    $author_meta = $author ? $author->GetAllMetaData() : [];

                                    $author_name =
                                        $language == 'en'
                                            ? $author->name ?? ($user->name ?? 'Review Nepal')
                                            : $author_meta['name_ne'] ?? ($user->name ?? 'Review Nepal');

                                @endphp

                                <article class="d-flex flex-column flex-md-row gap-4 mb-5">

                                    @if ($post_image_url)
                                        <a href="{{ route('frontend.post.index', $third_post->slug) }}">
                                            <img src="{{ $post_image_url }}" alt="{{ $third_post->post_title }}"
                                                class="news-img flex-shrink-0">
                                        </a>
                                    @else
                                        <a href="{{ route('frontend.post.index', $third_post->slug) }}">
                                            <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                                alt="{{ $third_post->post_title }}" class="news-img flex-shrink-0">
                                        </a>
                                    @endif

                                    <div>
                                        <a href="{{ route('frontend.post.index', $third_post->slug) }}"
                                            class="article-title d-block">
                                            {{ $third_post->post_title }}
                                        </a>

                                        <p class="article-excerpt">
                                            {{ \Illuminate\Support\Str::words(html_entity_decode(strip_tags($third_post->post_content)), 40) }}
                                        </p>
                                        <div class="meta-text">
                                            <span class="meta-category">{{ $cat_name }}</span> | <span
                                                class="ms-2">{{ $language == 'en' ? $third_post->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($third_post->created_at) }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    @endif
                    {{-- VIEWS AND OPINION COLUMN END --}}

                    {{-- TRENDING COLUMN START --}}
                    @if (!empty($trendingPosts) && $trendingPosts->count() > 0)
                        @php
                            $main_title = $language == 'en' ? 'Trending News' : 'ट्रेंडिंग न्यूज';
                        @endphp
                        <div class="col-lg-4">
                            <div class="trending-card">
                                <h3 class="trending-header">{{ $main_title }}</h3>

                                @foreach ($trendingPosts as $trendingPost)
                                    @php
                                        $author = $trendingPost
                                            ->categories()
                                            ->where('categories.type', 'author')
                                            ->first();
                                        $author_meta = $author ? $author->GetAllMetaData() : [];
                                        $author_name =
                                            $language == 'en'
                                                ? $author->name ?? ($user->name ?? 'Review Nepal')
                                                : $author_meta['name_ne'] ?? ($user->name ?? 'Review Nepal');
                                    @endphp
                                    <div class="d-flex gap-3 mb-4 pb-2">
                                        <div class="trending-number">{{ $loop->iteration }}</div>
                                        <div class="w-100">
                                            <a href="{{ route('frontend.post.index', $trendingPost->slug) }}"
                                                class="trending-title d-block">{{ $trendingPost->post_title }}</a>
                                            <div class="meta-text d-flex justify-content-between mt-2">
                                                <span>{{ $language == 'en' ? $trendingPost->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($trendingPost->created_at) }}</span>
                                                <span>{{ $author_name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <!-- below trending news first ad -->
                            @php
                                $websiteName = SettingHelper::get_field('site_title');

                                $homepage_below_trending_news_first_ad = SettingHelper::get_field(
                                    'homepage_below_trending_news_first_ad',
                                );
                                $homepage_below_trending_news_first_ad_link = MediaHelper::getDescriptionById(
                                    $homepage_below_trending_news_first_ad,
                                );

                                $homepage_below_trending_news_first_ad_url = null;

                                if ($homepage_below_trending_news_first_ad) {
                                    $media = MediaHelper::getImageById($homepage_below_trending_news_first_ad);

                                    if (!empty($media?->file_name)) {
                                        $homepage_below_trending_news_first_ad_url = asset(
                                            'storage/' . $media->file_name,
                                        );
                                    }
                                }
                            @endphp

                            @if (!empty($homepage_below_trending_news_first_ad_url))
                                <div class="ad-wrapper py-3">
                                    <span class="ad-label">- Advertisementt -</span>

                                    @if (!empty($homepage_below_trending_news_first_ad_link))
                                        <a href="{{ $homepage_below_trending_news_first_ad_link }}" target="_blank">
                                            <img src="{{ $homepage_below_trending_news_first_ad_url }}"
                                                alt="{{ $websiteName }}" class="ad-one-third">
                                        </a>
                                    @else
                                        <img src="{{ $homepage_below_trending_news_first_ad_url }}"
                                            alt="{{ $websiteName }}" class="ad-one-third">
                                    @endif
                                </div>
                            @endif


                            <!-- below trending news second ad -->
                            @php
                                $homepage_below_trending_news_second_ad = SettingHelper::get_field(
                                    'homepage_below_trending_news_second_ad',
                                );
                                $homepage_below_trending_news_second_ad_link = MediaHelper::getDescriptionById(
                                    $homepage_below_trending_news_second_ad,
                                );

                                $homepage_below_trending_news_second_ad_url = null;

                                if ($homepage_below_trending_news_second_ad) {
                                    $media = MediaHelper::getImageById($homepage_below_trending_news_second_ad);

                                    if (!empty($media?->file_name)) {
                                        $homepage_below_trending_news_second_ad_url = asset(
                                            'storage/' . $media->file_name,
                                        );
                                    }
                                }
                            @endphp

                            @if (!empty($homepage_below_trending_news_second_ad_url))
                                <div class="ad-wrapper py-3">
                                    <span class="ad-label">- Advertisement -</span>

                                    @if (!empty($homepage_below_trending_news_second_ad_link))
                                        <a href="{{ $homepage_below_trending_news_second_ad_link }}" target="_blank">
                                            <img src="{{ $homepage_below_trending_news_second_ad_url }}"
                                                alt="{{ $websiteName }}" class="ad-one-third">
                                        </a>
                                    @else
                                        <img src="{{ $homepage_below_trending_news_second_ad_url }}"
                                            alt="{{ $websiteName }}" class="ad-one-third">
                                    @endif
                                </div>
                            @endif
                    @endif
                    {{-- TRENDING COLUMN END --}}

                </div>
            </div>
        @endif
        {{-- THIRD SECTION END --}}

        {{-- THIRD ADVERTISEMENT START --}}
        @php
            $above_nepal_insights_ad = SettingHelper::get_field('above_nepal_insights_ad');
            $link = MediaHelper::getDescriptionById($above_nepal_insights_ad);
            $websiteName = SettingHelper::get_field('site_title');

            if ($above_nepal_insights_ad) {
                $media = MediaHelper::getImageById($above_nepal_insights_ad);
                if (!empty($media->file_name)) {
                    $above_insight_image_url = asset('storage/' . $media->file_name);
                } else {
                    $above_insight_image_url = null;
                }
            }

        @endphp

        @if (!empty($above_insight_image_url))
            <div class="container py-3">
                <div class="row">
                    <div class="col-12">
                        <div class="ad-wrapper">
                            <span class="ad-label">- Advertisement -</span>
                            @if (!empty($link))
                                <a href="{{ $link }}" target="_blank">
                                    <img src="{{ $above_insight_image_url }}" alt="{{ $websiteName }}"
                                        class="ad-full-width">
                                </a>
                            @else
                                <img src="{{ $above_insight_image_url }}" alt="{{ $websiteName }}"
                                    class="ad-full-width">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- THIRD ADVERTISEMENT END --}}


        <hr style="border-color: #c7c7c7; margin: 0;">

        <div class="container py-5">
            <div class="row gy-5">

                {{-- LIFESTYLE CATEGORY START --}}
                @if ($lifestyle_ent_posts->count() > 0 && !empty($lifestyle_ent_posts) && !empty($lifestyle_ent_cat))
                    <div class="col-lg-4 col-md-6 col-spacing d-flex flex-column">
                        <h2 class="section-title">
                            {{ $language == 'en' ? $lifestyle_ent_cat->name : $lifestyle_ent_cat->GetAllMetaData()['name_ne'] ?? $lifestyle_ent_cat->name }}
                        </h2>

                        @foreach ($lifestyle_ent_posts as $fifth_left_post)
                            @php
                                // CATEGORY
                                $fifth_left_cate = $fifth_left_post->categories()->first();
                                $fifth_left_cateMeta = $fifth_left_cate ? $fifth_left_cate->GetAllMetaData() : [];
                                $cat_name =
                                    $language == 'en'
                                        ? $fifth_left_cate->name ?? ''
                                        : $fifth_left_cateMeta['name_ne'] ?? '';

                                // POST META
                                $itemMeta = $fifth_left_post->GetAllMetaData();

                                // IMAGE
                                $post_image_id = $itemMeta['featured_image'] ?? null;
                                $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;
                                if (!empty($post_media?->file_name)) {
                                    $post_image_url = asset('storage/' . $post_media->file_name);
                                } elseif (!empty($itemMeta['youtube_video_id'])) {
                                    $post_image_url =
                                        'https://img.youtube.com/vi/' .
                                        $itemMeta['youtube_video_id'] .
                                        '/hqdefault.jpg';
                                } else {
                                    $post_image_url = null;
                                }

                                $author = $fifth_left_post->categories()->where('categories.type', 'author')->first();

                                $author_meta = $author ? $author->GetAllMetaData() : [];

                                $author_name =
                                    $language == 'en'
                                        ? $author->name ?? ($user->name ?? 'Review Nepal')
                                        : $author_meta['name_ne'] ?? ($user->name ?? 'Review Nepal');

                            @endphp

                            <a href="{{ route('frontend.post.index', $fifth_left_post->slug) }}" class="news-item">
                                @if ($post_image_url)
                                    <img src="{{ $post_image_url }}" alt="{{ $fifth_left_post->post_title }}"
                                        class="small-thumb">
                                @else
                                    <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                        alt="{{ $fifth_left_post->post_title }}" class="small-thumb">
                                @endif
                                <div class="news-content">
                                    <h3 class="news-title">
                                        {{ $fifth_left_post->post_title }}
                                    </h3>
                                    <div class="featured-meta">
                                        <span class="meta-category">{{ $cat_name }}</span>
                                        <span class="meta-divider">|</span>
                                        <span>{{ $language == 'en' ? $fifth_left_post->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($fifth_left_post->created_at) }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach


                    </div>
                @endif
                {{-- LIFESTYLE CATEGORY END --}}

                {{-- ART AND CULTURE CATEGORY START --}}
                @if ($art_cult_lit_posts->count() > 0 && !empty($art_cult_lit_posts) && !empty($art_cult_lit_cat))
                    <div class="col-lg-4 col-md-6 col-spacing d-flex flex-column">

                        {{-- CATEGORY TITLE --}}
                        <h2 class="section-title">
                            {{ $language == 'en' ? $art_cult_lit_cat->name : $art_cult_lit_cat->GetAllMetaData()['name_ne'] ?? $art_cult_lit_cat->name }}
                        </h2>

                        @foreach ($art_cult_lit_posts as $fifth_middle_post)
                            @php
                                $cate = $fifth_middle_post->categories()->first();
                                $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                                $cat_name = $language == 'en' ? $cate->name ?? '' : $catMeta['name_ne'] ?? '';

                                // POST META
                                $itemMeta = $fifth_middle_post->GetAllMetaData();

                                // IMAGE
                                $post_image_id = $itemMeta['featured_image'] ?? null;
                                $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;

                                $post_image_url = !empty($post_media?->file_name)
                                    ? asset('storage/' . $post_media->file_name)
                                    : (!empty($itemMeta['youtube_video_id'])
                                        ? 'https://img.youtube.com/vi/' .
                                            $itemMeta['youtube_video_id'] .
                                            '/hqdefault.jpg'
                                        : asset('assets/images/review_nepal_logo.webp'));

                                // AUTHOR (FIXED VARIABLE)
                                $author = $fifth_middle_post->categories()->where('categories.type', 'author')->first();

                                $author_meta = $author ? $author->GetAllMetaData() : [];

                                $author_name =
                                    $language == 'en'
                                        ? $author->name ?? ($user->name ?? 'Review Nepal')
                                        : $author_meta['name_ne'] ?? ($user->name ?? 'Review Nepal');

                                $date = $fifth_middle_post->created_at;
                            @endphp

                            {{-- FIRST POST (FEATURED DESIGN) --}}
                            @if ($loop->first)
                                <a href="{{ route('frontend.post.index', $fifth_middle_post->slug) }}"
                                    class="featured-item">

                                    <img src="{{ $post_image_url }}" alt="{{ $fifth_middle_post->post_title }}"
                                        class="large-thumb">

                                    <h3 class="news-title">
                                        {{ $fifth_middle_post->post_title }}
                                    </h3>

                                    <div class="featured-meta">
                                        <span class="meta-category">{{ $cat_name }}</span>
                                        <span class="meta-divider">|</span>
                                        <span>
                                            {{ $language == 'en' ? $date->format('M d, Y') : NepaliDateHelper::toNepaliDate($date) }}
                                        </span>
                                    </div>

                                </a>

                                {{-- OTHER POSTS (LIST DESIGN) --}}
                            @else
                                <a href="{{ route('frontend.post.index', $fifth_middle_post->slug) }}"
                                    class="news-item">

                                    <img src="{{ $post_image_url }}" alt="{{ $fifth_middle_post->post_title }}"
                                        class="small-thumb">

                                    <div class="news-content">

                                        <h3 class="news-title">
                                            {{ $fifth_middle_post->post_title }}
                                        </h3>

                                        <div class="featured-meta">
                                            <span class="meta-category">{{ $cat_name }}</span>
                                            <span class="meta-divider">|</span>
                                            <span>
                                                {{ $language == 'en' ? $date->format('M d, Y') : NepaliDateHelper::toNepaliDate($date) }}
                                            </span>
                                        </div>

                                    </div>

                                </a>
                            @endif
                        @endforeach

                        {{-- CATEGORY LINK --}}


                    </div>
                @endif
                {{-- ART AND CULTURE CATEGORY END --}}

                {{-- SCIENCE AND TECH CATEGORY START --}}
                @if ($sci_tech_posts->count() > 0 && !empty($sci_tech_posts) && !empty($sci_tech_cat))
                    <div class="col-lg-4 col-md-12 d-flex flex-column mt-5">

                        {{-- CATEGORY TITLE --}}
                        <h2 class="section-title">
                            {{ $language == 'en' ? $sci_tech_cat->name : $sci_tech_cat->GetAllMetaData()['name_ne'] ?? $sci_tech_cat->name }}
                        </h2>

                        <div class="row">

                            <div class="col-md-6 col-lg-12">

                                @foreach ($sci_tech_posts as $fifth_right_post)
                                    @php
                                        // CATEGORY
                                        $cate = $fifth_right_post->categories()->first();
                                        $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                                        $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                                        // POST META
                                        $itemMeta = $fifth_right_post->GetAllMetaData();

                                        // IMAGE
                                        $post_image_id = $itemMeta['featured_image'] ?? null;
                                        $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;

                                        $post_image_url = !empty($post_media?->file_name)
                                            ? asset('storage/' . $post_media->file_name)
                                            : (!empty($itemMeta['youtube_video_id'])
                                                ? 'https://img.youtube.com/vi/' .
                                                    $itemMeta['youtube_video_id'] .
                                                    '/hqdefault.jpg'
                                                : asset('assets/images/review_nepal_logo.webp'));

                                        // AUTHOR
                                        $author = $fifth_right_post
                                            ->categories()
                                            ->where('categories.type', 'author')
                                            ->first();

                                        $author_meta = $author ? $author->GetAllMetaData() : [];

                                        $author_name =
                                            $language == 'en'
                                                ? $author->name ?? ($user->name ?? 'Review Nepal')
                                                : $author_meta['name_ne'] ?? ($user->name ?? 'Review Nepal');

                                        $date = $fifth_right_post->created_at;
                                    @endphp

                                    {{-- FIRST POST (BIG ITEM STYLE) --}}
                                    @if ($loop->first)
                                        <a href="{{ route('frontend.post.index', $fifth_right_post->slug) }}"
                                            class="featured-item">

                                            <img src="{{ $post_image_url }}" alt="{{ $fifth_right_post->post_title }}"
                                                class="large-thumb">

                                            <h3 class="news-title">
                                                {{ $fifth_right_post->post_title }}
                                            </h3>

                                            <div class="featured-meta">
                                                <span class="meta-category">{{ $cat_name }}</span>
                                                <span class="meta-divider">|</span>
                                                <span>
                                                    {{ $language == 'en' ? $date->format('M d, Y') : NepaliDateHelper::toNepaliDate($date) }}
                                                </span>
                                            </div>

                                        </a>
                                    @else
                                        {{-- OTHER POSTS --}}
                                        <a href="{{ route('frontend.post.index', $fifth_right_post->slug) }}"
                                            class="news-item">

                                            <img src="{{ $post_image_url }}" alt="{{ $fifth_right_post->post_title }}"
                                                class="small-thumb">

                                            <div class="news-content">

                                                <h3 class="news-title">
                                                    {{ $fifth_right_post->post_title }}
                                                </h3>

                                                <div class="featured-meta">
                                                    <span class="meta-category">{{ $cat_name }}</span>
                                                    <span class="meta-divider">|</span>
                                                    <span>
                                                        {{ $language == 'en' ? $date->format('M d, Y') : NepaliDateHelper::toNepaliDate($date) }}
                                                    </span>
                                                </div>

                                            </div>

                                        </a>
                                    @endif
                                @endforeach

                            </div>

                        </div>



                    </div>
                @endif
                {{-- SCIENCE AND TECH CATEGORY END --}}

            </div>
        </div>
        <hr style="border-color: #c7c7c7; margin: 0;">
        @php
            $above_brands_ad = SettingHelper::get_field('above_brands_ad');
            $link = MediaHelper::getDescriptionById($above_brands_ad);

            if ($above_brands_ad) {
                $media = MediaHelper::getImageById($above_brands_ad);
                if (!empty($media->file_name)) {
                    $above_brands_ad_img_url = asset('storage/' . $media->file_name);
                } else {
                    $above_brands_ad_img_url = null;
                }
            }
        @endphp

        @if (!empty($above_brands_ad_img_url))
            <div class="container py-3">
                <div class="row">
                    <div class="col-12">
                        <div class="ad-wrapper">
                            <span class="ad-label">- Advertisement -</span>
                            @if (!empty($link))
                                <a href="{{ $link }}" target="_blank">
                                    <img src="{{ $above_brands_ad_img_url }}" alt="{{ $websiteName }}"
                                        class="ad-full-width">
                                </a>
                            @else
                                <img src="{{ $above_brands_ad_img_url }}" alt="{{ $websiteName }}"
                                    class="ad-full-width">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- ADVERTISEMENT START --}}
        @php
            $above_articles_ad = SettingHelper::get_field('above_articles_ad');
            $link = MediaHelper::getDescriptionById($above_articles_ad);

            if ($above_articles_ad) {
                $media = MediaHelper::getImageById($above_articles_ad);
                if (!empty($media->file_name)) {
                    $above_articles_image_url = asset('storage/' . $media->file_name);
                } else {
                    $above_articles_image_url = null;
                }
            }
        @endphp

        @if (!empty($above_articles_image_url))
            <div class="container py-3">
                <div class="row">
                    <div class="col-12">
                        <div class="ad-wrapper">
                            <span class="ad-label">- Advertisementt -</span>
                            @if (!empty($link))
                                <a href="{{ $link }}" target="_blank">
                                    <img src="{{ $above_articles_image_url }}" alt="{{ $websiteName }}"
                                        class="ad-full-width">
                                </a>
                            @else
                                <img src="{{ $above_articles_image_url }}" alt="{{ $websiteName }}"
                                    class="ad-full-width">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- ADVERTISEMENT END --}}

        {{-- NOTICE START --}}
        @if ($business_brands_posts->count() > 0 && !empty($business_brands_posts) && !empty($business_brands_cat))
            <hr style="border-color: #c7c7c7; margin: 0;">
            <div class="container py-5">

                 @if (!empty($business_brands_cat))
                    <div class="mb-4">
                        <div class="category-title-flex section-header">
                            <h2 class="m-0">
                                <a href="{{ route('frontend.category.index', $business_brands_cat->slug) }}"
                                    style="color: inherit; text-decoration: none;">
                                    {{ $language == 'en' ? $business_brands_cat->name : $business_brands_cat->GetAllMetaData()['name_ne'] ?? $business_brands_cat->name }}
                                </a>
                            </h2>
                            
                            <div class="child-categories-wrapper">
                            <div class="child-categories-list">
                                @foreach ($business_brands_cat->children as $child)
                                    @php
                                        $childMeta = $child->GetAllMetaData();
                                        $childName =
                                            $language == 'en' ? $child->name : $childMeta['name_ne'] ?? $child->name;
                                    @endphp
                                    <a href="{{ route('frontend.category.index', $child->slug) }}"
                                        class="child-category-link">
                                        {{ $childName }}
                                    </a>
                                    @if (!$loop->last)
                                        <span class="child-cat-divider">|</span>
                                    @endif
                                @endforeach
                            </div>
                            
                             <a href="{{ route('frontend.category.index', $business_brands_cat->slug) }}"
                                class="category-circle-btn">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                            
                            </div>
                            
                            
                           
                        </div>
                    </div>
                @endif

                <div class="row gy-5 mt-4">


                    @foreach ($business_brands_posts as $seventh_post)
                        @php
                            // CATEGORY
                            $cate = $seventh_post->categories()->first();
                            $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                            $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                            // POST META
                            $itemMeta = $seventh_post->GetAllMetaData();

                            // IMAGE
                            $post_image_id = $itemMeta['featured_image'] ?? null;
                            $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;

                            $post_image_url = !empty($post_media?->file_name)
                                ? asset('storage/' . $post_media->file_name)
                                : (!empty($itemMeta['youtube_video_id'])
                                    ? 'https://img.youtube.com/vi/' . $itemMeta['youtube_video_id'] . '/hqdefault.jpg'
                                    : asset('assets/images/review_nepal_logo.webp'));

                            // AUTHOR
                            $author = $seventh_post->categories()->where('categories.type', 'author')->first();

                            $author_meta = $author ? $author->GetAllMetaData() : [];

                            $author_name =
                                $language == 'en'
                                    ? $author->name ?? ($user->name ?? 'Review Nepal')
                                    : $author_meta['name_ne'] ?? ($user->name ?? 'Review Nepal');

                            $date = $seventh_post->created_at;
                        @endphp
                        <div class="col-lg-4 col-md-6 mt-0">
                            <a href="{{ route('frontend.post.index', $seventh_post->slug) }}" class="news-item">

                                @if ($post_image_url)
                                    <img src="{{ $post_image_url }}" alt="{{ $seventh_post->post_title }}"
                                        class="small-thumb">
                                @endif

                                <div class="news-content">
                                    <h3 class="news-title">
                                        {{ $seventh_post->post_title }}
                                    </h3>
                                    <div class="featured-meta">
                                        <span class="meta-category">{{ $cat_name }}</span>
                                        <span class="meta-divider">|</span>
                                        <span>{{ $language == 'en' ? $date->format('M d, Y') : NepaliDateHelper::toNepaliDate($date) }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach


                </div>
            </div>
        @endif
        {{-- NOTICE END --}}


    </main>

@endsection
