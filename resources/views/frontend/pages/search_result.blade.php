@extends('frontend.layouts.app', ['payload' => $payload, 'payloadMeta' => $payloadMeta, 'title' => $title])

@section('main-section')

    @push('frontend-css')
        <style>
            .search-results-container {
                max-width: 1300px;
                margin: 0 auto;
                padding: 0 16px;
            }

            .search-results-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 24px;
            }

            .search-result-card {
                width: 100%;
                margin-top: 0 !important;
            }

            @media (max-width: 992px) {
                .search-results-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 576px) {
                .search-results-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush

    @if (!empty($posts) && count($posts) > 0)
        <section class="morning-hero-section">

            <div class="post-header text-center">
                <h1 class="post-title-inner mb-2">
                    Search Results
                </h1>
                <p class="text-muted">Search results for "{{ $query }}"</p>
            </div>

            <div class="search-results-container">


                <div class="search-results-grid">

                    @foreach ($posts as $post)
                        @php
                            $itemMeta = $post->GetAllMetaData();

                            // POST IMAGE
                            $post_image_id = $itemMeta['featured_image'] ?? null;
                            $post_media = $post_image_id ? MediaHelper::getImageById($post_image_id) : null;
                            $post_image_url = !empty($post_media?->file_name)
                                ? asset('storage/' . $post_media->file_name)
                                : null;

                            // AUTHOR
                            $author = $post->categories()->where('categories.type', 'author')->first();
                            $author_meta = $author ? $author->GetAllMetaData() : [];

                            if ($language == 'en') {
                                $author_name = $author->name ?? 'Unknown Author';
                            } else {
                                $author_name = $author_meta['name_ne'] ?? ($author->name ?? 'Unknown Author');
                            }
                        @endphp

                        <article class="bottom-card mt-4 search-result-card">

                            @if ($post_image_url)
                                <a href="{{ route('frontend.post.index', $post->slug) }}">
                                    <img src="{{ $post_image_url }}" alt="{{ $post->post_title }}">
                                </a>
                            @else
                                <a href="{{ route('frontend.post.index', $post->slug) }}">
                                    <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                        alt="{{ $post->post_title }}">
                                </a>
                            @endif

                            <h3 class="card-title">
                                <a href="{{ route('frontend.post.index', $post->slug) }}">
                                    {{ $post->post_title }}
                                </a>
                            </h3>

                            <div class="story-meta">
                                <span class="author">{{ $author_name }}</span>
                                <span
                                    class="date">{{ $language == 'en' ? $post->created_at->format('M d, Y') : NepaliDateHelper::toNepaliDate($post->created_at) }}</span>
                            </div>

                        </article>
                    @endforeach
                </div>
                {{-- pagination --}}
                <div class="col-12 mt-4">
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
                                            <a class="page-link"
                                                href="{{ $posts->url($lastPage) }}">{{ $lastPage }}</a>
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
                {{-- pagination end --}}

            </div>
        </section>
    @elseif (!empty($categories) && count($categories) > 0)
    <section class="morning-hero-section">

        <div class="post-header text-center">
            <h1 class="post-title-inner mb-2">
                Search Results
            </h1>
            <p class="text-muted">Search results for "{{ $query }}"</p>
        </div>

        <div class="search-results-container">


            <div class="search-results-grid">
                    @foreach ($categories as $category)
                        <article class="bottom-card">

                           
                            <a href="{{ route('frontend.category.index', $category->slug) }}">
                                <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                    alt="{{ $category->name }}">
                            </a>
                     
                            <h3 class="card-title text-center">
                                <a href="{{ route('frontend.category.index', $category->slug) }}">
                                    {{ $category->name }}
                                </a>
                            </h3>
                        </article>
                    @endforeach
                </div>
            </div>
        
    </section>
    @else
        <section class="morning-hero-section">
            <div class="search-results-container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2>No results found</h2>
                        @if ($query)
                            <p class="mt-3">No matches found for "{{ $query }}"</p>
                        @endif
                        <div class="mt-4">
                            <a class="btn btn-subscribe mt-5" href="{{ url('/') }}">
                                <span>Back to Home</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
