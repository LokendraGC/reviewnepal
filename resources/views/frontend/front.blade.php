@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $postMeta, 'title' => $post->post_title])

@section('main-section')

    <main>

        @php
            // dd($left_second_posts->posts);
        @endphp

        {{-- RECENT POSTS START --}}
        @if (!empty($recent_posts))
            @foreach ($recent_posts as $recent_post)
                <section class="container my-5">
                    <div class="news-header-section">
                        <h1 class="main-headline">
                            <a
                                href="{{ route('frontend.post.index', $recent_post->slug) }}">{{ $recent_post->post_title }}</a>
                        </h1>

                        @php
                            $author = $recent_post->categories()->where('categories.type', 'author')->first();

                            $author_meta = $author ? $author->GetAllMetaData() : [];

                            if ($language == 'en') {
                                $author_name = isset($author->name) ? $author->name : $user->name;
                            } else {
                                $author_name = isset($author_meta['name_ne']) ? $author_meta['name_ne'] : $user->name;
                            }

                            $featured_image = isset($author_meta['featured_image'])
                                ? $author_meta['featured_image']
                                : null;
                            $media = MediaHelper::getImageById($featured_image);
                            if (!empty($featured_image) && !empty($media->file_name)) {
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
                                <span class="meta-author">{{ $author_name }}</span>
                            </div>
                            <span><i class="fa-regular fa-calendar-days"></i>
                                {{ $language == 'en' ? $recent_post->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($recent_post->created_at) }}</span>
                        </div>
                    </div>

                    <div class="featured-image-container">

                        @php
                            $postMeta = $recent_post->GetAllMetaData();
                            $featured_image = $postMeta['featured_image'];
                            $show_banner = $postMeta['show_banner'] ?? '0';

                            $media = MediaHelper::getImageById($featured_image);
                            if (!empty($featured_image) && !empty($media->file_name)) {
                                $featured_image_url = asset('storage/' . $media->file_name);
                            } else {
                                $featured_image_url = null;
                            }
                        @endphp

                        @if (!empty($featured_image_url) && $show_banner == '1')
                            <a href="{{ route('frontend.post.index', $recent_post->slug) }}">
                                <img src="{{ $featured_image_url }}" alt="{{ $recent_post->post_title }}"
                                    class="featured-image">
                            </a>
                        @endif

                        <p class="image-caption">
                            {{ \Illuminate\Support\Str::words(html_entity_decode(strip_tags($recent_post->post_content)), 20) }}
                        </p>

                    </div>
                </section>
            @endforeach
        @endif
        {{-- RECENT POSTS END --}}

        {{-- TOP ADVERTISEMENT START --}}
        <div class="container py-3">
            <div class="row">
                <div class="col-12">
                    <div class="ad-wrapper">
                        <span class="ad-label">- Advertisement -</span>
                        <a href="#">
                            <img src="{{ asset('assets/images/OnlinePortal_1230X100-ezgif.com-video-to-gif-converter.gif') }}"
                                alt="Full Width Ad" class="ad-full-width">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- TOP ADVERTISEMENT END --}}

        {{-- LEFT AND RIGHT SECOND CATEGORY START --}}
        @if (!empty($left_second_posts->posts) || !empty($right_second_posts->posts))
            <section class="morning-hero-section">
                <div class="morning-container">

                    @if (!empty($left_second_posts) && !empty($left_second_posts->posts))
                        <div class="hero-left-col">

                            @foreach ($left_second_posts->posts as $left_second_post)
                                @php

                                    $cateMeta = $left_second_post->categories()->first()->GetAllMetaData();

                                    $cat_name = $language == 'en' ? $left_second_posts->name : $cateMeta['name_ne'];

                                    $postMeta = $left_second_post->GetAllMetaData();

                                    // POST IMAGE
                                    $post_image_id = $postMeta['featured_image'] ?? null;
                                    $post_media = MediaHelper::getImageById($post_image_id);
                                    $post_image_url = !empty($post_media->file_name)
                                        ? asset('storage/' . $post_media->file_name)
                                        : null;

                                    // AUTHOR
                                    $author = $left_second_post
                                        ->categories()
                                        ->where('categories.type', 'author')
                                        ->first();
                                    $author_meta = $author ? $author->GetAllMetaData() : [];

                                    if ($language == 'en') {
                                        $author_name = $author->name ?? $user->name;
                                    } else {
                                        $author_name = $author_meta['name_ne'] ?? $user->name;
                                    }
                                @endphp

                                {{-- FIRST POST (PRIMARY DESIGN) --}}
                                @if ($loop->first)
                                    <div class="hero-primary-grid">

                                        <div class="primary-content">
                                            <span class="story-tag">{{ $cat_name }}</span>

                                            <h2 class="primary-title">
                                                <a href="{{ route('frontend.post.index', $left_second_post->slug) }}">
                                                    {{ $left_second_post->post_title }}
                                                </a>
                                            </h2>


                                            <p class="primary-excerpt">
                                                {{ \Illuminate\Support\Str::words(html_entity_decode(strip_tags($left_second_post->post_content)), 40) }}
                                            </p>

                                            <div class="story-meta">
                                                <span class="author">{{ $author_name }}</span>
                                                <span
                                                    class="date">{{ $language == 'en' ? $left_second_post->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($left_second_post->created_at) }}</span>
                                            </div>
                                        </div>

                                        <div class="primary-image-wrapper">
                                            @if ($post_image_url)
                                                <a href="{{ route('frontend.post.index', $left_second_post->slug) }}">
                                                    <img src="{{ $post_image_url }}"
                                                        alt="{{ $left_second_post->post_title }}">
                                                </a>
                                            @endif

                                            {{-- <div class="live-updates-badge">
                                            <span class="pulse-dot"></span> Live Updates
                                        </div> --}}
                                        </div>

                                    </div>

                                    {{-- START secondary grid container AFTER first item --}}
                                    <div class="hero-secondary-grid">
                                    @else
                                        {{-- OTHER POSTS (SECONDARY DESIGN) --}}
                                        <article class="bottom-card">

                                            @if ($post_image_url)
                                                <a href="{{ route('frontend.post.index', $left_second_post->slug) }}">
                                                    <img src="{{ $post_image_url }}"
                                                        alt="{{ $left_second_post->post_title }}">
                                                </a>
                                            @endif

                                            <h3 class="card-title">
                                                <a href="{{ route('frontend.post.index', $left_second_post->slug) }}">
                                                    {{ $left_second_post->post_title }}
                                                </a>
                                            </h3>

                                            <div class="story-meta">
                                                <span class="author">{{ $author_name }}</span>
                                                <span
                                                    class="date">{{ $language == 'en' ? $left_second_post->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($left_second_post->created_at) }}</span>
                                            </div>

                                        </article>
                                @endif

                                {{-- CLOSE secondary grid at last --}}
                                @if ($loop->last && !$loop->first)
                        </div>
                    @endif
        @endforeach

        </div>
        @endif
        {{-- LEFT AND RIGHT SECOND CATEGORY END --}}

        {{-- RIGHT SIDEBAR CATEGORY START --}}
        @if (!empty($right_second_posts) && !empty($right_second_posts->posts))
            <div class="hero-right-col">

                @foreach ($right_second_posts->posts as $right_second_post)
                    @php
                        // CATEGORY
                        $cate = $right_second_post->categories()->first();
                        $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                        $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                        // POST META
                        $postMeta = $right_second_post->GetAllMetaData();

                        // IMAGE
                        $post_image_id = $postMeta['featured_image'] ?? null;
                        $post_media = MediaHelper::getImageById($post_image_id);
                        $post_image_url = !empty($post_media->file_name)
                            ? asset('storage/' . $post_media->file_name)
                            : null;

                        $author = $right_second_post->categories()->where('categories.type', 'author')->first();

                        $author_meta = $author ? $author->GetAllMetaData() : [];

                        $author_name =
                            $language == 'en' ? $author->name ?? $user->name : $author_meta['name_ne'] ?? $user->name;
                    @endphp

                    {{-- FIRST POST (FEATURED) --}}
                    @if ($loop->first)
                        <article class="sidebar-featured">

                            @if ($post_image_url)
                                <a href="{{ route('frontend.post.index', $right_second_post->slug) }}">
                                    <img src="{{ $post_image_url }}" alt="{{ $right_second_post->post_title }}">
                                </a>
                            @endif

                            <span class="story-tag">{{ $cat_name }}</span>

                            <h3 class="sidebar-featured-title">
                                <a href="{{ route('frontend.post.index', $right_second_post->slug) }}">
                                    {{ $right_second_post->post_title }}
                                </a>
                            </h3>

                            <div class="story-meta">
                                <span class="author">{{ $author_name }}</span>
                                <span class="date">
                                    {{ $language == 'en'
                                        ? $right_second_post->created_at->format('M d, Y')
                                        : NepaliDateHelper::toNepaliDate($right_second_post->created_at) }}
                                </span>
                            </div>

                        </article>

                        {{-- START LIST --}}
                        <div class="sidebar-list">
                        @else
                            {{-- LIST ITEMS --}}
                            <article class="list-item">

                                @if ($post_image_url)
                                    <a href="{{ route('frontend.post.index', $right_second_post->slug) }}">
                                        <img src="{{ $post_image_url }}" alt="{{ $right_second_post->post_title }}">
                                    </a>
                                @endif

                                <div class="list-content">
                                    <span class="story-tag">{{ $cat_name }}</span>

                                    <h4 class="list-title">
                                        <a href="{{ route('frontend.post.index', $right_second_post->slug) }}">
                                            {{ $right_second_post->post_title }}
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
        {{-- RIGHT SIDEBAR CATEGORY END --}}

        </div>
        </section>
        @endif
        {{-- LEFT AND RIGHT SECOND CATEGORY END --}}

        {{-- MIDDLE ADVERTISEMENT START --}}
        <div class="container py-3">
            <div class="row">
                <div class="col-12">
                    <div class="ad-wrapper">
                        <span class="ad-label">- Advertisement -</span>
                        <a href="#">
                            <img src="{{ asset('assets/images/OnlinePortal_1230X100-ezgif.com-video-to-gif-converter.gif') }}"
                                alt="Full Width Ad" class="ad-full-width">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- MIDDLE ADVERTISEMENT END --}}


        {{-- THIRD SECTION START --}}
        <div class="container py-5">

            @php
                $postMeta = $post->GetAllMetaData();
                $main_title = $language == 'en' ? $postMeta['main_title_third'] : $postMeta['main_title_nepali_third'];
                $view_all_text = $language == 'en' ? 'View All' : 'सबै हेर्नुहोस्';
            @endphp

            <div class="section-header d-flex justify-content-between">
                <h2 class="m-0">{{ $main_title }}</h2>
                <a href="{{ route('frontend.category.index', $third_cat->slug) }}"
                    class="cat-link mt-auto">{{ $view_all_text }} <span>&rarr;</span></a>
            </div>

            <div class="row justify-content-between">

                {{-- THIRD LEFT COLUMN START --}}
                @if (!empty($third_cat) && !empty($third_cat->posts))
                    <div class="col-lg-7">


                        @foreach ($third_cat->posts as $third_post)
                            @php
                                // CATEGORY
                                $cate = $third_post->categories()->first();
                                $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                                $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                                // POST META
                                $postMeta = $third_post->GetAllMetaData();

                                // IMAGE
                                $post_image_id = $postMeta['featured_image'] ?? null;
                                $post_media = MediaHelper::getImageById($post_image_id);
                                $post_image_url = !empty($post_media->file_name)
                                    ? asset('storage/' . $post_media->file_name)
                                    : null;

                                $author = $third_post->categories()->where('categories.type', 'author')->first();

                                $author_meta = $author ? $author->GetAllMetaData() : [];

                                $author_name =
                                    $language == 'en'
                                        ? $author->name ?? $user->name
                                        : $author_meta['name_ne'] ?? $user->name;

                            @endphp

                            <article class="d-flex flex-column flex-md-row gap-4 mb-5">

                                @if ($post_image_url)
                                    <a href="{{ route('frontend.post.index', $third_post->slug) }}">
                                        <img src="{{ $post_image_url }}" alt="{{ $third_post->post_title }}"
                                            class="news-img flex-shrink-0">
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
                {{-- THIRD LEFT COLUMN END --}}

                {{-- TRENDING COLUMN START --}}
                @if (!empty($trendingPosts))
                    @php
                        $main_title = $language == 'en' ? 'Trending News' : 'ट्रेंडिंग न्यूज';
                    @endphp
                    <div class="col-lg-4">
                        <div class="trending-card">
                            <h3 class="trending-header">{{ $main_title }}</h3>

                            @foreach ($trendingPosts as $trendingPost)
                                @php
                                    $author = $trendingPost->categories()->where('categories.type', 'author')->first();
                                    $author_meta = $author ? $author->GetAllMetaData() : [];
                                    $author_name = $language == 'en' ? $author->name ?? $user->name : $author_meta['name_ne'] ?? $user->name;
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

                        <div class="ad-wrapper py-3">
                            <span class="ad-label">- Advertisement -</span>
                            <a href="#">
                                <img src="{{ asset('assets/images/WhatsApp-Image-2026-02-02-at-09.46.17.jpeg') }}"
                                    alt="Sidebar Ad" class="ad-one-third">
                            </a>
                        </div>
                        <div class="ad-wrapper py-3">
                            <span class="ad-label">- Advertisement -</span>
                            <a href="#">
                                <img src="{{ asset('assets/images/300x218.gif') }}" alt="Sidebar Ad"
                                    class="ad-one-third">
                            </a>
                        </div>
                    </div>
                @endif
                {{-- TRENDING COLUMN END --}}

            </div>
        </div>
        {{-- THIRD SECTION END --}}

        {{--  THIRD ADVERTISEMENT START --}}
        <div class="container py-3">
            <div class="row">
                <div class="col-12">
                    <div class="ad-wrapper">
                        <span class="ad-label">- Advertisement -</span>
                        <a href="#">
                            <img src="{{ asset('assets/images/WhatsApp-GIF-2026-03-10-at-10.52.51.gif') }}"
                                alt="Full Width Ad" class="ad-full-width">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{--  THIRD ADVERTISEMENT END --}}

        {{--  NEPAL INSIGHTS START --}}
        @if (!empty($fourth_cat) && !empty($fourth_cat->posts))
            <div class="container py-5">

                @php
                    $postMeta = $post->GetAllMetaData();
                    $main_title =
                        $language == 'en' ? $postMeta['main_title_fourth'] : $postMeta['main_title_nepali_fourth'];
                    $view_all_text = $language == 'en' ? 'View All' : 'सबै हेर्नुहोस्';
                @endphp

                <div class="section-header-featured d-flex justify-content-between">
                    <h2>{{ $main_title }}</h2>
                    <a href="{{ route('frontend.category.index', $fourth_cat->slug) }}"
                        class="cat-link mt-auto">{{ $view_all_text }}<span>&rarr;</span></a>
                </div>

                <div class="row gy-5">

                    @foreach ($fourth_cat->posts as $fourth_post)
                        @php
                            // CATEGORY
                            $cate = $fourth_post->categories()->first();
                            $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                            $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                            // POST META
                            $postMeta = $fourth_post->GetAllMetaData();

                            // IMAGE
                            $post_image_id = $postMeta['featured_image'] ?? null;
                            $post_media = MediaHelper::getImageById($post_image_id);
                            $post_image_url = !empty($post_media->file_name)
                                ? asset('storage/' . $post_media->file_name)
                                : null;

                            $author = $fourth_post->categories()->where('categories.type', 'author')->first();

                            $author_meta = $author ? $author->GetAllMetaData() : [];

                            $author_name =
                                $language == 'en'
                                    ? $author->name ?? $user->name
                                    : $author_meta['name_ne'] ?? $user->name;

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
                                @endif
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif
        {{--  NEPAL INSIGHTS END --}}

        {{--  NEPAL INSIGHTS ADVERTISEMENT START --}}
        <hr style="border-color: #c7c7c7; margin: 0;">
        <div class="container py-3">
            <div class="row">
                <div class="col-12">
                    <div class="ad-wrapper">
                        <span class="ad-label">- Advertisement -</span>
                        <a href="#">
                            <img src="https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&h=250&q=80"
                                alt="Full Width Ad" class="ad-full-width">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{--  NEPAL INSIGHTS ADVERTISEMENT END --}}

        <hr style="border-color: #c7c7c7; margin: 0;">

        <div class="container py-5">
            <div class="row gy-5">

                {{-- FIFTH LEFT CATEGORY START --}}
                @if (!empty($fifth_left_cat) && !empty($fifth_left_cat->posts))
                    <div class="col-lg-4 col-md-6 col-spacing d-flex flex-column">
                        <h2 class="section-title">
                            {{ $language == 'en' ? $fifth_left_cat->name : $fifth_left_cat->GetAllMetaData()['name_ne'] ?? $fifth_left_cat->name }}
                        </h2>

                        @foreach ($fifth_left_cat->posts as $fifth_left_post)
                            @php
                                // CATEGORY
                                $fifth_left_cate = $fifth_left_post->categories()->first();
                                $fifth_left_cateMeta = $fifth_left_cate ? $fifth_left_cate->GetAllMetaData() : [];
                                $cat_name =
                                    $language == 'en'
                                        ? $fifth_left_cate->name ?? ''
                                        : $fifth_left_cateMeta['name_ne'] ?? '';

                                // POST META
                                $postMeta = $fifth_left_post->GetAllMetaData();

                                // IMAGE
                                $post_image_id = $postMeta['featured_image'] ?? null;
                                $post_media = MediaHelper::getImageById($post_image_id);
                                $post_image_url = !empty($post_media->file_name)
                                    ? asset('storage/' . $post_media->file_name)
                                    : null;

                                $author = $fifth_left_post->categories()->where('categories.type', 'author')->first();

                                $author_meta = $author ? $author->GetAllMetaData() : [];

                                $author_name =
                                    $language == 'en'
                                        ? $author->name ?? $user->name
                                        : $author_meta['name_ne'] ?? $user->name;

                            @endphp

                            <a href="{{ route('frontend.post.index', $fifth_left_post->slug) }}" class="news-item">
                                @if ($post_image_url)
                                    <img src="{{ $post_image_url }}" alt="{{ $fifth_left_post->post_title }}"
                                        class="small-thumb">
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

                        <a href="{{ route('frontend.category.index', $fifth_left_cat->slug) }}"
                            class="cat-link mt-auto">{{ $language == 'en' ? 'View All' : 'सबै हेर्नुहोस्' }}
                            <span>&rarr;</span></a>
                    </div>
                @endif
                {{-- FIFTH LEFT CATEGORY END --}}

                {{-- FIFTH MIDDLE CATEGORY START --}}
                @if (!empty($fifth_middle_cat) && !empty($fifth_middle_cat->posts))
                    <div class="col-lg-4 col-md-6 col-spacing d-flex flex-column">

                        {{-- CATEGORY TITLE --}}
                        <h2 class="section-title">
                            {{ $language == 'en' ? $fifth_middle_cat->name : $fifth_middle_cat->GetAllMetaData()['name_ne'] ?? $fifth_middle_cat->name }}
                        </h2>

                        @foreach ($fifth_middle_cat->posts as $fifth_middle_post)
                            @php
                                // CATEGORY
                                $cate = $fifth_middle_post->categories()->first();
                                $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                                $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                                // POST META
                                $postMeta = $fifth_middle_post->GetAllMetaData();

                                // IMAGE
                                $post_image_id = $postMeta['featured_image'] ?? null;
                                $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;

                                $post_image_url =
                                    !empty($post_media) && !empty($post_media->file_name)
                                        ? asset('storage/' . $post_media->file_name)
                                        : asset('assets/images/default.jpg');

                                // AUTHOR (FIXED VARIABLE)
                                $author = $fifth_middle_post->categories()->where('categories.type', 'author')->first();

                                $author_meta = $author ? $author->GetAllMetaData() : [];

                                $author_name =
                                    $language == 'en'
                                        ? $author->name ?? $user->name
                                        : $author_meta['name_ne'] ?? $user->name;

                                $date = $fifth_middle_post->created_at;
                            @endphp

                            {{-- 🔥 FIRST POST (FEATURED DESIGN) --}}
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

                                {{-- 📰 OTHER POSTS (LIST DESIGN) --}}
                            @else
                                <a href="{{ route('frontend.post.index', $fifth_middle_post->slug) }}" class="news-item">

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
                        <a href="{{ route('frontend.category.index', $fifth_middle_cat->slug) }}"
                            class="cat-link mt-auto">
                            {{ $language == 'en' ? 'View All' : 'सबै हेर्नुहोस्' }}
                            <span>&rarr;</span>
                        </a>

                    </div>
                @endif
                {{-- FIFTH MIDDLE CATEGORY END --}}

                {{-- FIFTH RIGHT CATEGORY START --}}
                @if (!empty($fifth_right_cat) && !empty($fifth_right_cat->posts))
                    <div class="col-lg-4 col-md-12 d-flex flex-column mt-5">

                        {{-- CATEGORY TITLE --}}
                        <h2 class="section-title">
                            {{ $language == 'en'
                                ? $fifth_right_cat->name
                                : $fifth_right_cat->GetAllMetaData()['name_ne'] ?? $fifth_right_cat->name }}
                        </h2>

                        <div class="row">

                            <div class="col-md-6 col-lg-12">

                                @foreach ($fifth_right_cat->posts as $fifth_right_post)
                                    @php
                                        // CATEGORY
                                        $cate = $fifth_right_post->categories()->first();
                                        $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                                        $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                                        // POST META
                                        $postMeta = $fifth_right_post->GetAllMetaData();

                                        // IMAGE
                                        $post_image_id = $postMeta['featured_image'] ?? null;
                                        $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;

                                        $post_image_url =
                                            !empty($post_media) && !empty($post_media->file_name)
                                                ? asset('storage/' . $post_media->file_name)
                                                : asset('assets/images/default.jpg');

                                        // AUTHOR
                                        $author = $fifth_right_post
                                            ->categories()
                                            ->where('categories.type', 'author')
                                            ->first();

                                        $author_meta = $author ? $author->GetAllMetaData() : [];

                                        $author_name =
                                            $language == 'en'
                                                ? $author->name ?? $user->name
                                                : $author_meta['name_ne'] ?? $user->name;

                                        $date = $fifth_right_post->created_at;
                                    @endphp

                                    {{-- 🔥 FIRST POST (BIG ITEM STYLE) --}}
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
                                        {{-- 📰 OTHER POSTS --}}
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

                        {{-- CATEGORY LINK --}}
                        <a href="{{ route('frontend.category.index', $fifth_right_cat->slug) }}"
                            class="cat-link mt-auto">
                            {{ $language == 'en' ? 'View All' : 'सबै हेर्नुहोस्' }}
                            <span>&rarr;</span>
                        </a>

                    </div>
                @endif
                {{-- FIFTH RIGHT CATEGORY END --}}

            </div>
        </div>
        <hr style="border-color: #c7c7c7; margin: 0;">
        <div class="container py-3">
            <div class="row">
                <div class="col-12">
                    <div class="ad-wrapper">
                        <span class="ad-label">- Advertisement -</span>
                        <a href="#">
                            <img src="{{ asset('assets/images/OnlinePortal_1230X100-ezgif.com-video-to-gif-converter.gif') }}"
                                alt="Full Width Ad" class="ad-full-width">
                        </a>
                    </div>
                </div>
            </div>
        </div>


        {{-- BRANDS START --}}
        @if (!empty($sixth_cat) && !empty($sixth_cat->posts))
            <div class="container py-5">

                {{-- HEADER --}}
                <div class="section-header-featured d-flex justify-content-between">
                    <h2>
                        {{ $language == 'en' ? $sixth_cat->name : $sixth_cat->GetAllMetaData()['name_ne'] ?? $sixth_cat->name }}
                    </h2>

                    <a href="{{ route('frontend.category.index', $sixth_cat->slug) }}" class="cat-link mt-auto">
                        {{ $language == 'en' ? 'View All' : 'सबै हेर्नुहोस्' }}
                        <span>&rarr;</span>
                    </a>
                </div>

                <div class="row g-4">

                    {{-- LEFT CONTENT --}}
                    <div class="col-lg-8 full-height-col">
                        <div class="row g-4 h-100">

                            @foreach ($sixth_cat->posts as $sixth_post)
                                @php
                                    // CATEGORY
                                    $cate = $sixth_post->categories()->first();
                                    $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                                    $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                                    // POST META
                                    $postMeta = $sixth_post->GetAllMetaData();

                                    // IMAGE
                                    $post_image_id = $postMeta['featured_image'] ?? null;
                                    $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;

                                    $post_image_url =
                                        !empty($post_media) && !empty($post_media->file_name)
                                            ? asset('storage/' . $post_media->file_name)
                                            : asset('assets/images/default.jpg');

                                    // AUTHOR
                                    $author = $sixth_post->categories()->where('categories.type', 'author')->first();

                                    $author_meta = $author ? $author->GetAllMetaData() : [];

                                    $author_name =
                                        $language == 'en'
                                            ? $author->name ?? $user->name
                                            : $author_meta['name_ne'] ?? $user->name;

                                    $date = $sixth_post->created_at;
                                @endphp

                                {{-- FIRST POST (BIG FEATURED CARD) --}}
                                @if ($loop->first)
                                    <div class="col-12">
                                        <div class="card overflow-hidden">

                                            <div class="row g-0 h-100">

                                                <div class="col-md-5">
                                                    <a href="{{ route('frontend.post.index', $sixth_post->slug) }}">
                                                        <img src="{{ $post_image_url }}"
                                                            class="img-fluid h-100 object-fit-cover"
                                                            alt="{{ $sixth_post->post_title }}">
                                                    </a>
                                                </div>

                                                <div class="col-md-7">
                                                    <div class="card-body d-flex flex-column h-100 p-4">

                                                        <p class="small-text mb-2">
                                                            {{ $language == 'en' ? $date->format('M d, Y') : NepaliDateHelper::toNepaliDate($date) }}
                                                        </p>

                                                        <h2 class="h4 mb-3 brands-title">
                                                            <a
                                                                href="{{ route('frontend.post.index', $sixth_post->slug) }}">
                                                                {{ $sixth_post->post_title }}
                                                            </a>
                                                        </h2>

                                                        <p class="small-text">
                                                            {{ \Illuminate\Support\Str::words(strip_tags($sixth_post->post_content), 25) }}
                                                        </p>

                                                        <p class="author-text mb-0">
                                                            by. <span class="text-dark">{{ $author_name }}</span>
                                                        </p>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                @else
                                    {{-- SMALL CARDS --}}
                                    <div class="col-md-6">
                                        <div class="card overflow-hidden">

                                            <div class="row g-0 h-100">

                                                <div class="col-4">
                                                    <a href="{{ route('frontend.post.index', $sixth_post->slug) }}">
                                                        <img src="{{ $post_image_url }}"
                                                            class="img-fluid h-100 object-fit-cover"
                                                            alt="{{ $sixth_post->post_title }}">
                                                    </a>
                                                </div>

                                                <div class="col-8">
                                                    <div class="card-body p-3">

                                                        <p class="small-text mb-1">
                                                            {{ $language == 'en' ? $date->format('M d, Y') : NepaliDateHelper::toNepaliDate($date) }}
                                                        </p>

                                                        <h3 class="mb-2 brands-title" style="font-size: 0.9rem;">
                                                            <a
                                                                href="{{ route('frontend.post.index', $sixth_post->slug) }}">
                                                                {{ $sixth_post->post_title }}
                                                            </a>
                                                        </h3>

                                                        <p class="author-text mb-0">{{ $author_name }}</p>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>

                    {{-- ADVERTISEMENT --}}
                    <div class="col-lg-4">
                        <div class="ad-wrapper py-3">
                            <span class="ad-label">- Advertisement -</span>
                            <a href="#">
                                <img src="{{ asset('assets/images/WhatsApp-Image-2026-02-02-at-09.46.17.jpeg') }}"
                                    class="ad-one-third">
                            </a>
                        </div>

                        <div class="ad-wrapper py-3">
                            <span class="ad-label">- Advertisement -</span>
                            <a href="#">
                                <img src="{{ asset('assets/images/300x218.gif') }}" class="ad-one-third">
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        @endif
        {{-- BRANDS END --}}

        {{-- ADVERTISEMENT START --}}
        <div class="container py-3">
            <div class="row">
                <div class="col-12">
                    <div class="ad-wrapper">
                        <span class="ad-label">- Advertisement -</span>
                        <a href="#">
                            <img src="https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&h=250&q=80"
                                alt="Full Width Ad" class="ad-full-width">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- ADVERTISEMENT END --}}

        {{-- NOTICE START --}}
        @if (!empty($seventh_cat) && !empty($seventh_cat->posts))
            <hr style="border-color: #c7c7c7; margin: 0;">
            <div class="container py-5">

                <div class="section-header-featured d-flex justify-content-between">
                    <h2>{{ $language == 'en' ? $seventh_cat->name : $seventh_cat->GetAllMetaData()['name_ne'] ?? $seventh_cat->name }}
                    </h2>
                    <a href="{{ route('frontend.category.index', $seventh_cat->slug) }}" class="cat-link mt-auto">
                        {{ $language == 'en' ? 'View All' : 'सबै हेर्नुहोस्' }}
                        <span>&rarr;</span>
                    </a>
                </div>
                <div class="row gy-5 mt-4">


                    @foreach ($seventh_cat->posts as $seventh_post)
                        @php
                            // CATEGORY
                            $cate = $seventh_post->categories()->first();
                            $cateMeta = $cate ? $cate->GetAllMetaData() : [];
                            $cat_name = $language == 'en' ? $cate->name ?? '' : $cateMeta['name_ne'] ?? '';

                            // POST META
                            $postMeta = $seventh_post->GetAllMetaData();

                            // IMAGE
                            $post_image_id = $postMeta['featured_image'] ?? null;
                            $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;

                            $post_image_url =
                                !empty($post_media) && !empty($post_media->file_name)
                                    ? asset('storage/' . $post_media->file_name)
                                    : asset('assets/images/default.jpg');

                            // AUTHOR
                            $author = $seventh_post->categories()->where('categories.type', 'author')->first();

                            $author_meta = $author ? $author->GetAllMetaData() : [];

                            $author_name =
                                $language == 'en'
                                    ? $author->name ?? $user->name
                                    : $author_meta['name_ne'] ?? $user->name;

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
