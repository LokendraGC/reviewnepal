@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $postMeta, 'title' => $post->post_title])

@section('main-section')


<div class="container main-wrapper py-5">
  <div class="row">
    <div class="post-header">
      <h1 class="post-title-inner mb-2">
        How countries use art and culture for global influence
      </h1>

      <div class="post-meta d-flex flex-wrap align-items-center">
        <div class="meta-item">
          <span class="meta-label">by.</span>
          <span class="meta-value author">Theresa Webb</span>
        </div>

        <div class="meta-item">
          <i class="fa-solid fa-layer-group"></i>
          <span class="meta-value">Culture</span>
        </div>

        <div class="meta-item">
          <i class="fa-regular fa-calendar-days"></i>
          <span class="meta-value">Dec 14, 2024</span>
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
      <div class="main-featured-img my-4">
        <img src="{{ asset('assets/images/2.jpg') }}" alt="Leader" />
      </div>

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

      <p class="intro-text">
        Welcome to <strong>Business</strong>, your premier destination for
        staying informed, entertained, and inspired...
      </p>

      <h4 class="section-subhead">
        Exclusive interview insights from industry leaders
      </h4>
      <ul class="bullet-list">
        <li>
          Nibh libero condimentum vitae habitant interdum molestie tellus
          turpis
        </li>
        <li>Turpis lous sed sagittis mollis aliquam lorem</li>
        <li>Feugiat maecenas ultricies viverra sollicitudin venenatis</li>
      </ul>

      <div class="quote-container my-5">
        <p>
          Exploit our curated selection of articles, interviews, and
          analysis meticulously crafted to keep you informed and engaged...
        </p>
      </div>

      <p class="standard-text">
        Odio augue habitant elementum lectus metus nisl pharetra. Donec non
        auctor tellus nibh elementum nunc elementum. Aenean diam est
        tincidunt urna.
      </p>

      <h4 class="section-subhead">
        Trending topics stay informed with hot discussions
      </h4>
      <p class="standard-text">
        Sollicitudin feugiat orci, lorem interdum pellentesque. Massa,
        scelerisque in placerat venenatis scelerisque habitasse.
      </p>

      <div class="secondary-img my-4">
        <img src="{{ asset('assets/images/3.jpg') }}" alt="Office" />
      </div>
    </div>

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

  <div class="mt-5">
    <h2 class="similar-news-title">Similar News</h2>
    <hr class="heading-line" />
    <div class="row mt-4">
      <div class="col-md-3">
        <div class="recent-news">
          <img src="{{ asset('assets/images/1.jpg') }}" alt="News 1" />
          <small class="text-muted d-block mt-2">May 12, 2024</small>
          <h6 class="fw-bold mt-1">
            Local community called to support homeless.
          </h6>
        </div>
      </div>
      <div class="col-md-3">
        <div class="recent-news">
          <img src="{{ asset('assets/images/2.jpg') }}" alt="News 1" />
          <small class="text-muted d-block mt-2">May 12, 2024</small>
          <h6 class="fw-bold mt-1">
            Local community called to support homeless.
          </h6>
        </div>
      </div>
      <div class="col-md-3">
        <div class="recent-news">
          <img src="{{ asset('assets/images/3.jpg') }}" alt="News 1" />
          <small class="text-muted d-block mt-2">May 12, 2024</small>
          <h6 class="fw-bold mt-1">
            Local community called to support homeless.
          </h6>
        </div>
      </div>
      <div class="col-md-3">
        <div class="recent-news">
          <img src="{{ asset('assets/images/4.jpg') }}" alt="News 1" />
          <small class="text-muted d-block mt-2">May 12, 2024</small>
          <h6 class="fw-bold mt-1">
            Local community called to support homeless.
          </h6>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection