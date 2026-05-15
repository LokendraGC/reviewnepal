@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $postMeta, 'title' => $post->post_title])

@section('main-section')

    @php
        PostHelper::setTrendingPosts($post);
    @endphp


    @php
        $single_above_title = SettingHelper::get_field('single_above_title');
        $link = MediaHelper::getDescriptionById($single_above_title);
        $websiteName = SettingHelper::get_field('site_title');

        if ($single_above_title) {
            $media = MediaHelper::getImageById($single_above_title);
            if (!empty($media->file_name)) {
                $single_above_title_url = asset('storage/' . $media->file_name);
            } else {
                $single_above_title_url = null;
            }
        }
    @endphp

    @if (!empty($single_above_title_url))
        <div class="container py-3">
            <div class="row">
                <div class="col-12">
                    <div class="ad-wrapper">
                        <span class="ad-label">- Advertisement -</span>
                        @if (!empty($link))
                            <a href="{{ $link }}" target="_blank">
                                <img src="{{ $single_above_title_url }}" alt="{{ $websiteName }}" class="ad-full-width" />
                            </a>
                        @else
                            <img src="{{ $single_above_title_url }}" alt="{{ $websiteName }}" class="ad-full-width" />
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

                <div class="post-meta d-flex flex-wrap align-items-center">
                    <div class="meta-item">
                        <span class="meta-label">by.</span>
                        <span class="meta-value author">{{ $author->name ?? ($user->name ?? 'Unknown') }}</span>
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
                @php
                    $single_below_title = SettingHelper::get_field('single_below_title');
                    $link = MediaHelper::getDescriptionById($single_below_title);
                    $websiteName = SettingHelper::get_field('site_title');

                    if ($single_below_title) {
                        $media = MediaHelper::getImageById($single_below_title);
                        if (!empty($media->file_name)) {
                            $single_below_title_url = asset('storage/' . $media->file_name);
                        } else {
                            $single_below_title_url = null;
                        }
                    }
                @endphp

                @if (!empty($single_below_title_url))
                    <div class="container py-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="ad-wrapper">
                                    <span class="ad-label">- Advertisement -</span>
                                    @if (!empty($link))
                                        <a href="{{ $link }}" target="_blank">
                                            <img src="{{ $single_below_title_url }}" alt="{{ $websiteName }}"
                                                class="ad-full-width" />
                                        </a>
                                    @else
                                        <img src="{{ $single_below_title_url }}" alt="{{ $websiteName }}"
                                            class="ad-full-width" />
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
                        $featured_image_url = asset('storage/' . $media->file_name);
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
                @php
                    $below_featured_image_ad = SettingHelper::get_field('below_featured_image_ad');
                    $link = MediaHelper::getDescriptionById($below_featured_image_ad);

                    if ($below_featured_image_ad) {
                        $media = MediaHelper::getImageById($below_featured_image_ad);
                        if (!empty($media->file_name)) {
                            $below_featured_image_url = asset('storage/' . $media->file_name);
                        } else {
                            $below_featured_image_url = null;
                        }
                    }
                @endphp

                @if (!empty($below_featured_image_url))
                    <div class="container py-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="ad-wrapper">
                                    <span class="ad-label">- Advertisement -</span>
                                    @if (!empty($link))
                                        <a href="{{ $link }}" target="_blank">
                                            <img src="{{ $below_featured_image_url }}" alt="{{ $websiteName }}"
                                                class="ad-full-width" />
                                        </a>
                                    @else
                                        <img src="{{ $below_featured_image_url }}" alt="{{ $websiteName }}"
                                            class="ad-full-width" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- ADVERTISEMENT END --}}

                <!-- AI Summary -->
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
                                <span>News Summary</span>
                            </div>
                        </div>
                        <div class="ai-summary-body">
                            {!! $aiSummary !!}
                        </div>
                    </div>
                @endif


                {{-- TEXT TO SPEECH START --}}
                <div class="tts-player mb-4 d-flex align-items-center gap-2"
                    style="background: #f8f9fa; padding: 10px 15px; border-radius: 8px; border: 1px solid #e9ecef;">
                    <button id="tts-play-btn" class="btn btn-sm"
                        style="background: rgb(210, 30, 1); color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: none; outline: none; cursor: pointer;">
                        <i class="fa-solid fa-play" id="tts-play-icon"></i>
                    </button>
                    <div class="tts-info flex-grow-1 mx-2">
                        <span style="font-weight: 600; font-size: 14px; color: #333;">Listen to this article</span>
                        <div class="progress"
                            style="height: 5px; margin-top: 5px; border-radius: 5px; background-color: #e9ecef;">
                            <div class="progress-bar" id="tts-progress" role="progressbar"
                                style="width: 0%; background-color: rgb(210, 30, 1); transition: width 0.1s linear;"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <button id="tts-stop-btn" class="btn btn-sm btn-light"
                        style="border-radius: 50%; width: 40px; height: 40px; align-items: center; justify-content: center; border: 1px solid #ddd; outline: none; display: none; cursor: pointer;">
                        <i class="fa-solid fa-stop text-danger"></i>
                    </button>
                </div>
                {{-- TEXT TO SPEECH END --}}

                {{-- POST CONTENT START --}}
                <div class="single-post-content py-3">
                    {!! $post->post_content !!}
                </div>
                {{-- POST CONTENT END --}}


            </div>

            {{-- TRENDING NEWS START --}}
            @if (!empty($trendingPosts))
                <div class="col-lg-3">
                    <div id="sticky-sidear">
                        <div class="sidebar-section mb-5">
                            <h5 class="sidebar-heading">Trending News</h5>
                            <hr class="heading-line" />

                            @foreach ($trendingPosts as $trendingPost)
                                @php
                                    $category = $trendingPost->categories()->first();
                                    $category_name = $category->name ?? 'Unknown';

                                    $itemMeta = $trendingPost->GetAllMetaData();
                                    $featured_image = $itemMeta['featured_image'] ?? null;
                                    $media = MediaHelper::getImageById($featured_image);
                                    if (!empty($featured_image) && !empty($media->file_name)) {
                                        $featured_image_url = asset('storage/' . $media->file_name);
                                    } elseif (!empty($itemMeta['youtube_video_id'])) {
                                        $featured_image_url =
                                            'https://img.youtube.com/vi/' .
                                            $itemMeta['youtube_video_id'] .
                                            '/hqdefault.jpg';
                                    } else {
                                        $featured_image_url = null;
                                    }
                                @endphp
                                <div class="d-flex mb-3 align-items-center sidebar-item">
                                    @if ($featured_image_url)
                                        <a href="{{ route('frontend.post.index', $trendingPost->slug) }}">
                                            <img src="{{ $featured_image_url }}"
                                                alt="{{ $trendingPost->post_title }}" />
                                        </a>
                                    @else
                                        <a href="{{ route('frontend.post.index', $trendingPost->slug) }}">
                                            <img src="{{ asset('assets/images/review_nepal_logo.webp') }}"
                                                alt="{{ $trendingPost->post_title }}" />
                                        </a>
                                    @endif
                                    <div class="ms-3">
                                        <small class="tag-small">{{ $category_name }}</small>
                                        <h6 class="sidebar-item-title">
                                            <a
                                                href="{{ route('frontend.post.index', $trendingPost->slug) }}">{{ $trendingPost->post_title }}</a>
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
                        @php
                            $single_news_below_trending_news_first_ad = SettingHelper::get_field(
                                'single_news_below_trending_news_first_ad',
                            );
                            $link = MediaHelper::getDescriptionById($single_news_below_trending_news_first_ad);

                            if ($single_news_below_trending_news_first_ad) {
                                $media = MediaHelper::getImageById($single_news_below_trending_news_first_ad);
                                if (!empty($media->file_name)) {
                                    $single_news_below_trending_url = asset('storage/' . $media->file_name);
                                } else {
                                    $single_news_below_trending_url = null;
                                }
                            }
                        @endphp

                        @if (!empty($single_news_below_trending_url))
                            <div class="ad-wrapper py-3">
                                <span class="ad-label">- Advertisement -</span>
                                @if (!empty($link))
                                    <a href="{{ $link }}" target="_blank">
                                        <img src="{{ $single_news_below_trending_url }}" alt="{{ $websiteName }}"
                                            class="ad-one-third" />
                                    </a>
                                @else
                                    <img src="{{ $single_news_below_trending_url }}" alt="{{ $websiteName }}"
                                        class="ad-one-third" />
                                @endif
                            </div>
                        @endif


                        <hr style="border-color: #c7c7c7; margin: 0;">
                        @php
                            $single_news_below_trending_news_second_ad = SettingHelper::get_field(
                                'single_news_below_trending_news_second_ad',
                            );
                            $link = MediaHelper::getDescriptionById($single_news_below_trending_news_second_ad);

                            if ($single_news_below_trending_news_second_ad) {
                                $media = MediaHelper::getImageById($single_news_below_trending_news_second_ad);
                                if (!empty($media->file_name)) {
                                    $single_news_below_trending_news_second_ad_url = asset(
                                        'storage/' . $media->file_name,
                                    );
                                } else {
                                    $single_news_below_trending_news_second_ad_url = null;
                                }
                            }
                        @endphp

                        @if (!empty($single_news_below_trending_news_second_ad_url))
                            <div class="ad-wrapper py-3">
                                <span class="ad-label">- Advertisement -</span>
                                @if (!empty($link))
                                    <a href="{{ $link }}" target="_blank">
                                        <img src="{{ $single_news_below_trending_news_second_ad_url }}"
                                            alt="{{ $websiteName }}" class="ad-one-third" />
                                    </a>
                                @else
                                    <img src="{{ $single_news_below_trending_news_second_ad_url }}"
                                        alt="{{ $websiteName }}" class="ad-one-third" />
                                @endif
                            </div>
                        @endif

                    </div>
                </div>
            @endif
            {{-- TRENDING NEWS END --}}


        </div>



        @php
            $single_below_content = SettingHelper::get_field('single_below_content');
            $link = MediaHelper::getDescriptionById($single_below_content);

            if ($single_below_content) {
                $media = MediaHelper::getImageById($single_below_content);
                if (!empty($media->file_name)) {
                    $single_below_content_url = asset('storage/' . $media->file_name);
                } else {
                    $single_below_content_url = null;
                }
            }
        @endphp

        @if (!empty($single_below_content_url))
            <hr style="border-color: #c7c7c7; margin: 0" />
            <div class="container py-3">
                <div class="row">
                    <div class="col-12">
                        <div class="ad-wrapper">
                            <span class="ad-label">- Advertisement -</span>
                            @if (!empty($link))
                                <a href="{{ $link }}" target="_blank">
                                    <img src="{{ $single_below_content_url }}" alt="{{ $websiteName }}"
                                        class="ad-full-width" />
                                </a>
                            @else
                                <img src="{{ $single_below_content_url }}" alt="{{ $websiteName }}"
                                    class="ad-full-width" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- SIMILAR NEWS START --}}
        @if (!empty($relatedPosts) && count($relatedPosts) > 0)
            <div class="mt-5">
                <h2 class="similar-news-title">Similar News</h2>
                <hr class="heading-line" />
                <div class="row mt-4">

                    @foreach ($relatedPosts as $relatedPost)
                        @php

                            $itemMeta = $relatedPost->GetAllMetaData();
                            $featured_image = $itemMeta['featured_image'] ?? null;

                            $media = MediaHelper::getImageById($featured_image);
                            if (!empty($featured_image) && !empty($media->file_name)) {
                                $featured_image_url = asset('storage/' . $media->file_name);
                            } else {
                                $featured_image_url = asset('assets/images/review_nepal_logo.webp');
                            }
                        @endphp
                        <div class="col-md-3">
                            <div class="recent-news">

                                @if ($featured_image_url)
                                    <a href="{{ route('frontend.post.index', $relatedPost->slug) }}">
                                        <img src="{{ $featured_image_url }}" alt="{{ $relatedPost->post_title }}" />
                                    </a>
                                @endif

                                <small
                                    class="text-muted d-block mt-2">{{ $relatedPost->created_at->format('M d, Y') }}</small>
                                <h6 class="fw-bold mt-1 similar-news-item-title">
                                    <a
                                        href="{{ route('frontend.post.index', $relatedPost->slug) }}">{{ $relatedPost->post_title }}</a>
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

@push('frontend-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const playBtn = document.getElementById('tts-play-btn');
            const stopBtn = document.getElementById('tts-stop-btn');
            const playIcon = document.getElementById('tts-play-icon');
            const progressBar = document.getElementById('tts-progress');
            const infoSpan = document.querySelector('.tts-info span');

            let audio = null;
            let isLoading = false;
            const postId = '{{ $post->id }}';
            const apiUrl = '{{ route('frontend.post.tts', ':id') }}'.replace(':id', postId);

            function setPlayState(playing) {
                if (playing) {
                    playIcon.className = 'fa-solid fa-pause';
                    stopBtn.style.display = 'flex';
                } else {
                    playIcon.className = 'fa-solid fa-play';
                }
            }

            function initAudio(url) {
                audio = new Audio(url);

                audio.addEventListener('play', () => setPlayState(true));
                audio.addEventListener('pause', () => setPlayState(false));
                audio.addEventListener('ended', () => {
                    setPlayState(false);
                    progressBar.style.width = '0%';
                    stopBtn.style.display = 'none';
                });

                audio.addEventListener('timeupdate', () => {
                    if (audio.duration) {
                        const progress = (audio.currentTime / audio.duration) * 100;
                        progressBar.style.width = progress + '%';
                    }
                });

                audio.play().catch(e => {
                    console.error("Audio playback failed:", e);
                    infoSpan.textContent = 'Playback failed. Try again.';
                    setPlayState(false);
                });
            }

            if (playBtn) {
                playBtn.addEventListener('click', async function() {
                    if (isLoading) return;

                    if (audio) {
                        if (audio.paused) {
                            audio.play();
                        } else {
                            audio.pause();
                        }
                        return;
                    }

                    // Need to load audio
                    isLoading = true;
                    playIcon.className = 'fa-solid fa-spinner fa-spin';
                    infoSpan.textContent = 'Generating audio...';

                    try {
                        const response = await fetch(apiUrl);

                        // Read response text first in case there is a dd() or error
                        const text = await response.text();

                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {
                            console.error("Server returned non-JSON:", text);
                            throw new Error("Invalid response from server");
                        }

                        if (data.audio_url) {
                            infoSpan.textContent = 'Listen to this article';
                            initAudio(data.audio_url);
                        } else {
                            throw new Error("No audio URL returned");
                        }
                    } catch (error) {
                        console.error("Failed to generate TTS:", error);
                        infoSpan.textContent = 'Failed to load audio.';
                        playIcon.className = 'fa-solid fa-play';
                    } finally {
                        isLoading = false;
                    }
                });
            }

            if (stopBtn) {
                stopBtn.addEventListener('click', function() {
                    if (audio) {
                        audio.pause();
                        audio.currentTime = 0;
                        setPlayState(false);
                        progressBar.style.width = '0%';
                        stopBtn.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endpush
