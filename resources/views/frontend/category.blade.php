@extends('frontend.layouts.app', ['payload' => $cat, 'payloadMeta' => $catMeta, 'title' => $cat->name])


@section('main-section')
<div class="container custom-sports-section py-5">
    <h1 class="main-category-title">{{ $cat->name }}</h1>

    @if ($posts->count())
        <div class="row gy-5 mt-2">
            @foreach ($posts as $post)
                <div class="col-md-4">
                    <div class="post-meta">
                        <i class="fa-regular fa-calendar-days"></i>
                        {{ $post->created_at?->format('F d, Y') }}
                    </div>
                    <a href="{{ route('frontend.post.index', $post->slug) }}">
                        <h3 class="post-title">{{ $post->post_title }}</h3>
                    </a>
                </div>
            @endforeach

            <div class="col-12">
                <div class="d-flex flex-column align-items-center gap-3 py-4">
                    @if ($posts->lastPage() > 1)
                        @php
                            $currentPage = $posts->currentPage();
                            $lastPage = $posts->lastPage();
                            $startPage = max(1, $currentPage - 1);
                            $endPage = min($lastPage, $currentPage + 1);
                        @endphp
                        <nav aria-label="Page navigation">
                            <ul class="pagination-red">
                                <li class="page-item {{ $posts->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link icon-link" href="{{ $posts->previousPageUrl() ?: '#' }}" aria-label="Previous">
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
                                    <a class="page-link icon-link" href="{{ $posts->nextPageUrl() ?: '#' }}" aria-label="Next">
                                        <i class="fa-solid fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                    <small class="text-muted">
                        Showing {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} results
                    </small>
                </div>
            </div>
        </div>
    @else
        <p class="mt-4">No posts found in this category.</p>
    @endif
</div>
@endsection