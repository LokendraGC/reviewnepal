@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $postMeta, 'title' => $post->post_title])

@push('schema')
@php
  $schemaWebsiteName = $settings['site_title'];
  $schemaLogoUrl = $settings['logo_url'];

  $schemaFeaturedId = $postMeta['featured_image'] ?? null;
  $schemaFeaturedMedia = MediaHelper::getImageById($schemaFeaturedId);
  $schemaFeaturedFile = $schemaFeaturedMedia ? $schemaFeaturedMedia->file_name : null;
  if (!empty($schemaFeaturedId) && !empty($schemaFeaturedFile)) {
    $schemaImageUrl = asset('storage/' . $schemaFeaturedFile);
  } elseif (!empty($postMeta['youtube_video_id'])) {
    $schemaImageUrl = 'https://img.youtube.com/vi/' . $postMeta['youtube_video_id'] . '/hqdefault.jpg';
  } else {
    $schemaImageUrl = '';
  }

  $schemaNeMeta = $author ? $author->GetAllMetaData() : [];
  $schemaAuthorType = $author ? 'Person' : 'Organization';
  $schemaAuthorName = $schemaNeMeta['name_ne'] ?? ($author ? $author->name : ($schemaWebsiteName ?? 'Review Nepal'));

  $schemaJson = json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'NewsArticle',
    'headline' => $post->post_title,
    'image'    => $schemaImageUrl,
    'author'   => [
      '@type' => $schemaAuthorType,
      'name'  => $schemaAuthorName,
    ],
    'publisher' => [
      '@type' => 'Organization',
      'name'  => $schemaWebsiteName,
      'logo'  => [
        '@type' => 'ImageObject',
        'url'   => $schemaLogoUrl,
      ],
    ],
    'datePublished' => $post->created_at->toIso8601String(),
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
@endphp
<script type="application/ld+json">{!! $schemaJson !!}</script>
@endpush

@section('main-section')
  @php
    PostHelper::setTrendingPosts($post);
  @endphp


  @php
    $websiteName = $settings['site_title'];
  @endphp

  @if (!empty($settings['above_title']['url']))
    <div class="container py-3">
      <div class="row">
        <div class="col-12">
          <div class="ad-wrapper">
            <span class="ad-label">- Advertisement -</span>
            @if (!empty($settings['above_title']['link']))
              <a href="{{ $settings['above_title']['link'] }}" target="_blank">
                <img src="{{ $settings['above_title']['url'] }}" alt="{{ $websiteName }}" class="ad-full-width" />
              </a>
            @else
              <img src="{{ $settings['above_title']['url'] }}" alt="{{ $websiteName }}" class="ad-full-width" />
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif
  <hr style="border-color: #c7c7c7; margin: 0;">


  <div class="container main-wrapper py-5">
    <div class="row">
      <div class="post-header">
        <h1 class="post-title-inner mb-2">
          {{ $post->post_title }}
        </h1>

      @php
          $author_meta = $author ? $author->GetAllMetaData() : [];
          $author_name = $author_meta['name_ne'] ?? $user->name ?? 'Review Nepal';
          $category_name = ($categoryMeta['name_ne'] ?? ($category->name ?? ''));
          $date = NepaliDateHelper::toNepaliDate($post->created_at);
        @endphp
        <div class="post-meta d-flex flex-wrap align-items-center">
          
          
           @if($author)
          <div class="meta-item">
            <span class="meta-label">by.</span>
            <span class="meta-value author cat-value">
                  @if($author)
                <a href="{{ route('frontend.author.index', $author->slug) }}">{{ $author_name }}</a>
                @else 
                {{ $author_name }}
                @endif
              </span>
          </div>
          @endif

          @if(!empty($category_name))
          <div class="meta-item">
            <i class="fa-solid fa-layer-group"></i>
            <span class="meta-value cat-value">
              @if($category)
                <a href="{{ route('frontend.category.index', $category->slug) }}">{{ $category_name }}</a>
              @else
                {{ $category_name }}
              @endif
            </span>
          </div>
          @endif

          <div class="meta-item">
            <i class="fa-regular fa-calendar-days"></i>
            <span class="meta-value">{{ $date }}</span>
          </div>
        </div>
      </div>
      <div class="col-lg-9 article-body" id="content-col">
        <!-- <span class="top-tag">WORLD NEWS</span>
                      <h1 class="entry-title">Global leaders unite to address climate crisis at COP26</h1>
                      <div class="meta-info">World Photo | Author</div>
                      <div class="meta-date">Updated July 12, 2024 12:32 PM</div> -->
        @if (!empty($settings['below_title']['url']))
          <div class="container py-3">
            <div class="row">
              <div class="col-12">
                <div class="ad-wrapper">
                  <span class="ad-label">- Advertisement -</span>
                  @if (!empty($settings['below_title']['link']))
                    <a href="{{ $settings['below_title']['link'] }}" target="_blank">
                      <img src="{{ $settings['below_title']['url'] }}" alt="{{ $websiteName }}" class="ad-full-width" />
                    </a>
                  @else
                    <img src="{{ $settings['below_title']['url'] }}" alt="{{ $websiteName }}" class="ad-full-width" />
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endif

                @php
                    $featured_image = $postMeta['featured_image'] ?? null;
                    $media = MediaHelper::getImageById($featured_image);
                    if (!empty($featured_image) && !empty($media->file_name)) {
                        $featured_image_url = MediaHelper::WsrvService($media);
                    } elseif (!empty($postMeta['youtube_video_id'])) {
                        $featured_image_url =
                            'https://img.youtube.com/vi/' . $postMeta['youtube_video_id'] . '/hqdefault.jpg';
                    } else {
                        $featured_image_url = null;
                    }
                @endphp

                @if (!empty($postMeta['youtube_video_id']))
                    <div class="main-featured-video my-4">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/{{ $postMeta['youtube_video_id'] }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                @elseif ($featured_image_url)
                    <div class="main-featured-img my-4">
                        <img src="{{ $featured_image_url }}" alt="{{ $post->post_title }}" />
                    </div>
                @endif
                
                
        {{-- ADVERTISEMENT START --}}
        @if (!empty($settings['below_featured']['url']))
          <div class="container py-3">
            <div class="row">
              <div class="col-12">
                <div class="ad-wrapper">
                  <span class="ad-label">- Advertisement -</span>
                  @if (!empty($settings['below_featured']['link']))
                    <a href="{{ $settings['below_featured']['link'] }}" target="_blank">
                      <img src="{{ $settings['below_featured']['url'] }}" alt="{{ $websiteName }}" class="ad-full-width" />
                    </a>
                  @else
                    <img src="{{ $settings['below_featured']['url'] }}" alt="{{ $websiteName }}" class="ad-full-width" />
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endif
        {{-- ADVERTISEMENT END --}}
        
            @php
            $aiSummary = $postMeta['ai_summary'] ?? null;
                @endphp

                @if (!empty($aiSummary))
                    <div class="ai-summary-card">
                        <div class="ai-summary-header">
                            <div class="ai-summary-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon
                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                    </polygon>
                                </svg>
                                <span>सारांश</span>
                            </div>
                        </div>
                        <div class="ai-summary-body">
                            {!! $aiSummary !!}
                        </div>
                    </div>
                @endif


        {{-- POST CONTENT START --}}
        <div class="single-post-content py-3">
          {!! $post->post_content !!}
        </div>
        {{-- POST CONTENT END --}}

<!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->

      </div>

      {{-- TRENDING NEWS START --}}
      @if (!empty($trendingPosts))
        <div class="col-lg-3 trend-posts">
          <div id="sticky-sidear">
            <div class="sidebar-section mb-5">
              <h5 class="sidebar-heading">ट्रेंडिंग न्यूज</h5>
              <hr class="heading-line" />

              @foreach ($trendingPosts as $trendingPost)
                @php
                  $category = $trendingPost->categories()->first();
                  $catMeta = $category ? $category->GetAllMetaData() : [];
                  $category_name = $catMeta['name_ne'] ?? $category->name ?? 'Unknown';

                  $itemMeta = $trendingPost->GetAllMetaData();
                  $featured_image = $itemMeta['featured_image'] ?? null;
                  $media = MediaHelper::getImageById($featured_image);
                  $featured_image_url = MediaHelper::WsrvService($media) ?? asset('assets/images/review_nepal_logo.webp');
                @endphp
                <div class="d-flex align-items-center sidebar-item single-trend-post">
                  @if ($featured_image_url)
                    <a href="{{ route('frontend.post.index', $trendingPost->slug) }}">
                      <img src="{{ $featured_image_url }}" alt="{{ $trendingPost->post_title }}" />
                    </a>
                  @endif
                  <div class="ms-3">
                    <small class="tag-small">{{ $catMeta['name_ne'] ?? 'Unknown' }}</small>
                    <h6 class="sidebar-item-title">
                      <a href="{{ route('frontend.post.index', $trendingPost->slug) }}">{{ $trendingPost->post_title }}</a>
                    </h6>
                  </div>
                </div>
              @endforeach


            </div>
            <hr style="border-color: #c7c7c7; margin: 0" />
            <!-- <div class="ad-wrapper py-3">
                                        <span class="ad-label">- Advertisement -</span>
                                        <a href="#">
                                          <img src="{{ asset('assets/images/WhatsApp-Image-2026-02-02-at-09.46.17.jpeg') }}" alt="Sidebar Ad" class="ad-one-third">
                                        </a>
                                      </div> -->
            @if (!empty($settings['sidebar_first']['url']))
              <div class="ad-wrapper py-3">
                <span class="ad-label">- Advertisement -</span>
                @if (!empty($settings['sidebar_first']['link']))
                  <a href="{{ $settings['sidebar_first']['link'] }}" target="_blank">
                    <img src="{{ $settings['sidebar_first']['url'] }}" alt="{{ $websiteName }}" class="ad-one-third" />
                  </a>
                @else
                  <img src="{{ $settings['sidebar_first']['url'] }}" alt="{{ $websiteName }}" class="ad-one-third" />
                @endif
              </div>
            @endif

            <hr style="border-color: #c7c7c7; margin: 0;">

            @if (!empty($settings['sidebar_second']['url']))
              <div class="ad-wrapper py-3">
                <span class="ad-label">- Advertisement -</span>
                @if (!empty($settings['sidebar_second']['link']))
                  <a href="{{ $settings['sidebar_second']['link'] }}" target="_blank">
                    <img src="{{ $settings['sidebar_second']['url'] }}" alt="{{ $websiteName }}" class="ad-one-third" />
                  </a>
                @else
                  <img src="{{ $settings['sidebar_second']['url'] }}" alt="{{ $websiteName }}" class="ad-one-third" />
                @endif
              </div>
            @endif



          </div>
        </div>
      @endif
      {{-- TRENDING NEWS END --}}


    </div>



    @if (!empty($settings['below_content']['url']))
      <hr style="border-color: #c7c7c7; margin: 0" />
      <div class="container py-3">
        <div class="row">
          <div class="col-12">
            <div class="ad-wrapper">
              <span class="ad-label">- Advertisement -</span>
              @if (!empty($settings['below_content']['link']))
                <a href="{{ $settings['below_content']['link'] }}" target="_blank">
                  <img src="{{ $settings['below_content']['url'] }}" alt="{{ $websiteName }}" class="ad-full-width" />
                </a>
              @else
                <img src="{{ $settings['below_content']['url'] }}" alt="{{ $websiteName }}" class="ad-full-width" />
              @endif
            </div>
          </div>
        </div>
      </div>
    @endif


    {{-- SIMILAR NEWS START --}}
       @if (!empty($relatedPosts) && count($relatedPosts) > 0)
      <div class="mt-5">
        <h2 class="similar-news-title">सम्बन्धित खबर</h2>
        <hr class="heading-line" />
        <div class="row mt-4">

          @foreach ($relatedPosts as $relatedPost)
            @php

              $itemMeta = $relatedPost->GetAllMetaData();
              $featured_image = $itemMeta['featured_image'] ?? null;

              $media = MediaHelper::getImageById($featured_image);
              $featured_image_url = MediaHelper::WsrvService($media) ?? asset('assets/images/review_nepal_logo.webp');
              $date = NepaliDateHelper::toNepaliDate($relatedPost->created_at);
            @endphp
            <div class="col-md-3">
              <div class="recent-news">

                @if ($featured_image_url)
                  <a href="{{ route('frontend.post.index', $relatedPost->slug) }}">
                    <img src="{{ $featured_image_url }}" alt="{{ $relatedPost->post_title }}" />
                  </a>
                @endif

                <small class="text-muted d-block mt-2">{{ $date }}</small>
                <h6 class="fw-bold mt-1 similar-news-item-title">
                  <a href="{{ route('frontend.post.index', $relatedPost->slug) }}">{{ $relatedPost->post_title }}</a>
                </h6>
              </div>
            </div>
          @endforeach


        </div>
      </div>
    @endif
    {{-- SIMILAR NEWS END --}}

  </div>
@endsection