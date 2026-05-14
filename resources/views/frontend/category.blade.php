@extends('frontend.layouts.app', ['payload' => $cat, 'payloadMeta' => $catMeta, 'title' => $cat->name])


@section('main-section')
    @if ($posts->count())
        @php
            $heroPost = $posts->first();
            $gridPosts = $posts->slice(1);
        @endphp

        @if ($heroPost)
            @php
                $heroMeta = $heroPost->GetAllMetaData();
                $heroImageId = $heroMeta['featured_image'] ?? null;
                $heroMedia = MediaHelper::getImageById($heroImageId);
                $heroImageUrl = !empty($heroMedia?->file_name) ? asset('storage/' . $heroMedia->file_name) : null;
            @endphp
            <div class="container custom-sports-section py-5">
                <h1 class="main-category-title">{{ $cat->name }}</h1>

                <div class="row mb-5 align-items-start mt-2">
                    <div class="col-lg-4 order-2 order-lg-1">
                        <h2 class="hero-headline">
                            <a href="{{ route('frontend.post.index', $heroPost->slug) }}">
                                {{ $heroPost->post_title }}
                            </a>
                        </h2>
                        <div class="hero-divider"></div>
                        <p class="hero-subtext">
                            {{ \Illuminate\Support\Str::words(html_entity_decode(strip_tags($heroPost->post_content)), 25) }}
                        </p>
                    </div>
                    <div class="col-lg-8 order-1 order-lg-2 mb-4 mb-lg-0">
                        <div class="img-wrapper hero-height">
                            @if ($heroImageUrl)
                                <a href="{{ route('frontend.post.index', $heroPost->slug) }}">
                                    <img src="{{ $heroImageUrl }}" alt="{{ $heroPost->post_title }}" />
                                </a>
                            @else
                                <a href="{{ route('frontend.post.index', $heroPost->slug) }}">
                                    <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                        alt="{{ $heroPost->post_title }}" />
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
        @endif

        <div class="row gy-5">
            @foreach ($gridPosts as $post)
                @php
                    $itemMeta = $post->GetAllMetaData();
                    $postImageId = $itemMeta['featured_image'] ?? null;
                    $postMedia = MediaHelper::getImageById($postImageId);
                    $postImageUrl = !empty($postMedia?->file_name) ? asset('storage/' . $postMedia->file_name) : null;
                @endphp
                <div class="col-md-4">
                    <div class="img-wrapper grid-height mb-3">
                        @if ($postImageUrl)
                            <a href="{{ route('frontend.post.index', $post->slug) }}">
                                <img src="{{ $postImageUrl }}" alt="{{ $post->post_title }}" />
                            </a>
                        @else
                            <a href="{{ route('frontend.post.index', $post->slug) }}">
                                <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                    alt="{{ $post->post_title }}" />
                            </a>
                        @endif
                    </div>
                    <div class="post-meta">
                        <i class="fa-regular fa-calendar-days"></i>
                        {{ $post->created_at?->format('F d, Y') }}
                    </div>
                    <h3 class="post-title">
                        <a href="{{ route('frontend.post.index', $post->slug) }}">
                            {{ $post->post_title }}
                        </a>
                    </h3>
                </div>
            @endforeach

            <div class="col-12">
                <div class="d-flex flex-column align-items-center gap-3 py-4">
                    @if ($posts->lastPage() > 1)
                        @php
                            $currentPage = $posts->currentPage();
                            $lastPage = $posts->lastPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($lastPage, $currentPage + 2);
                        @endphp
                        <nav aria-label="Page navigation">
                            <ul class="pagination-red">
                                <li class="page-item {{ $posts->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link icon-link" href="{{ $posts->previousPageUrl() ?: '#' }}"
                                        aria-label="Previous">
                                        <i class="fa-solid fa-angle-left"></i>
                                    </a>
                                </li>

                                @if ($startPage > 1)
                                    <li class="page-item d-none d-sm-block">
                                        <a class="page-link" href="{{ $posts->url(1) }}">1</a>
                                    </li>
                                    @if ($startPage > 2)
                                        <li class="page-item">
                                            <span class="page-link dots">...</span>
                                        </li>
                                    @endif
                                @endif

                                @for ($page = $startPage; $page <= $endPage; $page++)
                                    <li class="page-item {{ $page === $currentPage ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $posts->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor

                                @if ($endPage < $lastPage)
                                    @if ($endPage < $lastPage - 1)
                                        <li class="page-item">
                                            <span class="page-link dots">...</span>
                                        </li>
                                    @endif
                                    <li class="page-item d-none d-sm-block">
                                        <a class="page-link" href="{{ $posts->url($lastPage) }}">{{ $lastPage }}</a>
                                    </li>
                                @endif

                                <li class="page-item {{ $posts->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link icon-link" href="{{ $posts->nextPageUrl() ?: '#' }}"
                                        aria-label="Next">
                                        <i class="fa-solid fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                    <small class="text-muted">
                        Showing {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }}
                        results
                    </small>
                </div>
            </div>
        </div>
        </div>
    @else
        <div class="container custom-sports-section py-5">
            <h1 class="main-category-title text-center">
                {{ $language == 'en' ? $cat->name : $catMeta['name_ne'] }}
            </h1>
            <p class="text-center">
                {{ $language == 'en' ? 'No posts found in this category.' : 'यस श्रेणीमा कुनै पोष्टहरू भेटिएनन्।' }}
            </p>
        </div>
    @endif
@endsection
