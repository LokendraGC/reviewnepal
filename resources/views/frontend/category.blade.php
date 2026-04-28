@extends('frontend.layouts.app', ['payload' => $cat, 'payloadMeta' => $catMeta, 'title' => $cat->name])


@section('main-section')
<div class="container custom-sports-section py-5">
    <h1 class="main-category-title">Sports</h1>

    <div class="row mb-5 align-items-start">
        <div class="col-lg-4 order-2 order-lg-1">
            <h2 class="hero-headline">
                The Legacy of Champions: Athletes Who Defined Sports History in 2024
            </h2>
            <div class="hero-divider"></div>
            <p class="hero-subtext">
                A renowned filmmaker's library, including unreleased footage and
                interviews, will now stream exclusively on a leading platform.
            </p>
        </div>
        <div class="col-lg-8 order-1 order-lg-2 mb-4 mb-lg-0">
            <div class="img-wrapper hero-height">
                <img src="{{ asset('assets/images/5.jpg') }}" alt="Featured" />
            </div>
        </div>
    </div>

    <div class="row gy-5">
        <div class="col-md-4">
            <div class="img-wrapper grid-height mb-3">
                <img src="{{ asset('assets/images/1.jpg')}}" alt="News 1" />
            </div>
            <div class="post-meta">
                <i class="fa-regular fa-calendar-days"></i> December 16, 2024
            </div>
            <a href="category-detail.html">
                <h3 class="post-title">
                    Major Sporting Event Postponed Due to Extreme Weather
                </h3>
            </a>
        </div>

        <div class="col-md-4">
            <div class="img-wrapper grid-height mb-3">
                <img src="{{ asset('assets/images/2.jpg')}}" alt="News 2" />
            </div>
            <div class="post-meta">
                <i class="fa-regular fa-calendar-days"></i> December 16, 2024
            </div>
            <a href="category-detail.html">
                <h3 class="post-title">
                    Olympic Qualifiers Heat Up: Athletes to Watch This Season
                </h3>
            </a>
        </div>

        <div class="col-md-4">
            <div class="img-wrapper grid-height mb-3">
                <img src="{{ asset('assets/images/3.jpg')}}" alt="News 3" />
            </div>
            <div class="post-meta">
                <i class="fa-regular fa-calendar-days"></i> December 16, 2024
            </div>
            <a href="category-detail.html">
                <h3 class="post-title">
                    Cricket World Cup: Highlights from an Action-Packed Week
                </h3>
            </a>
        </div>
        <div class="col-12">
            <div class="d-flex flex-column align-items-center gap-3 py-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination-red">
                        <li class="page-item">
                            <a class="page-link icon-link" href="#" aria-label="Previous">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                        </li>

                        <li class="page-item d-none d-sm-block">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>

                        <li class="page-item">
                            <span class="page-link dots">...</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">10</a></li>

                        <li class="page-item">
                            <a class="page-link icon-link" href="#" aria-label="Next">
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <small class="text-muted">Showing 11-20 of 100 results</small>
            </div>
        </div>
    </div>
</div>
@endsection