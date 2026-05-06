@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $postMeta, 'title' => $post->post_title])

@section('main-section')


<div class="container main-wrapper py-5">
  <div class="row">
    <div class="post-header">
      <h1 class="post-title-inner mb-2">
        {{ $post->post_title }}
      </h1>

      <div class="post-meta d-flex flex-wrap align-items-center">
        <div class="meta-item">
          <span class="meta-label">by.</span>
          <span class="meta-value author">{{ $author->name ?? $user->name ?? 'Unknown' }}</span>
        </div>

        <div class="meta-item">
          <i class="fa-solid fa-layer-group"></i>
          <span class="meta-value">{{ $category->name ?? 'Unknown' }}</span>
        </div>

        <div class="meta-item">
          <i class="fa-regular fa-calendar-days"></i>
          <span class="meta-value">{{ $post->created_at->format('M d, Y') }}</span>
        </div>
      </div>
    </div>
    <div class="col-lg-9 article-body" id="content-col">
      <!-- <span class="top-tag">WORLD NEWS</span>
        <h1 class="entry-title">Global leaders unite to address climate crisis at COP26</h1>
        <div class="meta-info">World Photo | Author</div>
        <div class="meta-date">Updated July 12, 2024 12:32 PM</div> -->
      <div class="container py-3">
        <div class="row">
          <div class="col-12">
            <div class="ad-wrapper">
              <span class="ad-label">- Advertisement -</span>
              <a href="#">
                <img
                  src="{{ asset('assets/images/WhatsApp-GIF-2026-03-10-at-10.52.51.gif') }}"
                  alt="Full Width Ad"
                  class="ad-full-width" />
              </a>
            </div>
          </div>
        </div>
      </div>

      @php
        $featured_image = $postMeta['featured_image'] ?? null;
        $media = MediaHelper::getImageById($featured_image);
        if (!empty($featured_image) && !empty($media->file_name)) {
          $featured_image_url = asset('storage/' . $media->file_name);
        } else {
          $featured_image_url = null;
        }
      @endphp

      @if ($featured_image_url)
      <div class="main-featured-img my-4">
        <img src="{{ $featured_image_url }}" alt="{{ $post->post_title }}" />
      </div>
      @endif

      {{-- ADVERTISEMENT START --}}
      <div class="container py-3">
        <div class="row">
          <div class="col-12">
            <div class="ad-wrapper">
              <span class="ad-label">- Advertisement -</span>
              <a href="#">
                <img
                  src="{{ asset('assets/images/OnlinePortal_1230X100-ezgif.com-video-to-gif-converter.gif') }}"
                  alt="Full Width Ad"
                  class="ad-full-width" />
              </a>
            </div>
          </div>
        </div>
      </div>
      {{-- ADVERTISEMENT END --}}


      {{-- POST CONTENT START --}}
      <div class="single-post-content py-3">
      {!! $post->post_content !!}
      </div>
      {{-- POST CONTENT END --}}


    </div>

    {{-- TRENDING NEWS START --}}

    <div class="col-lg-3">
      <div id="sticky-sidear">
        <div class="sidebar-section mb-5">
          <h5 class="sidebar-heading">Trending News</h5>
          <hr class="heading-line" />
          <div class="d-flex mb-3 align-items-center sidebar-item">
            <img src="{{ asset('assets/images/1.jpg') }}" alt="News 1" />
            <div class="ms-3">
              <small class="tag-small">TECHNOLOGY</small>
              <h6 class="sidebar-item-title">
                Cybersecurity: aware alert of released threats
              </h6>
            </div>
          </div>
          <div class="d-flex mb-3 align-items-center sidebar-item">
            <img src="{{ asset('assets/images/4.jpg') }}" alt="News 1" />
            <div class="ms-3">
              <small class="tag-small">TECHNOLOGY</small>
              <h6 class="sidebar-item-title">
                Cybersecurity: aware alert of released threats
              </h6>
            </div>
          </div>
          <div class="d-flex mb-3 align-items-center sidebar-item">
            <img src="{{ asset('assets/images/5.jpg') }}" alt="News 1" />
            <div class="ms-3">
              <small class="tag-small">TECHNOLOGY</small>
              <h6 class="sidebar-item-title">
                Cybersecurity: aware alert of released threats
              </h6>
            </div>
          </div>
        </div>
        <hr style="border-color: #c7c7c7; margin: 0" />
        <!-- <div class="ad-wrapper py-3">
            <span class="ad-label">- Advertisement -</span>
            <a href="#">
              <img src="{{ asset('assets/images/WhatsApp-Image-2026-02-02-at-09.46.17.jpeg') }}" alt="Sidebar Ad" class="ad-one-third">
            </a>
          </div> -->
        <div class="ad-wrapper py-3">
          <span class="ad-label">- Advertisement -</span>
          <a href="#">
            <img
              src="{{ asset('assets/images/300x218.gif') }}"
              alt="Sidebar Ad"
              class="ad-one-third" />
          </a>
        </div>
      </div>
    </div>
    {{-- TRENDING NEWS END --}}


  </div>
  
  
  
  <hr style="border-color: #c7c7c7; margin: 0" />
  <div class="container py-3">
    <div class="row">
      <div class="col-12">
        <div class="ad-wrapper">
          <span class="ad-label">- Advertisement -</span>
          <a href="#">
            <img
              src="{{ asset('assets/images/WhatsApp-GIF-2026-03-10-at-10.52.51.gif') }}"
              alt="Full Width Ad"
              class="ad-full-width" />
          </a>
        </div>
      </div>
    </div>
  </div>


  {{-- SIMILAR NEWS START --}}
  @if (!empty($relatedPosts))
  <div class="mt-5">
    <h2 class="similar-news-title">Similar News</h2>
    <hr class="heading-line" />
    <div class="row mt-4">
    
      @foreach ($relatedPosts as $relatedPost)
      @php

        $postMeta = $relatedPost->GetAllMetaData();
        $featured_image = $postMeta['featured_image'] ?? null;

        $media = MediaHelper::getImageById($featured_image);
        if (!empty($featured_image) && !empty($media->file_name)) {
          $featured_image_url = asset('storage/' . $media->file_name);
        } else {
          $featured_image_url = null;
        }
      @endphp
      <div class="col-md-3">
        <div class="recent-news">

          @if ($featured_image_url)
         <a href="{{ route('frontend.post.index', $relatedPost->slug) }}">
          <img src="{{ $featured_image_url }}" alt="{{ $relatedPost->post_title }}" />
         </a>
          @endif

          <small class="text-muted d-block mt-2">{{ $relatedPost->created_at->format('M d, Y') }}</small>
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