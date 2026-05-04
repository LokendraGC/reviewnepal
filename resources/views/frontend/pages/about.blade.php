@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $metaData, 'title' => $post->post_title])

@section('main-section')
    @php

    $postMeta = $post->GetAllMetaData();
        $featured_image = $postMeta['featured_image'];
        $media = MediaHelper::getImageById($featured_image);

        if (!empty($featured_image) && !empty($media->file_name)) {
            $image_url = asset('storage/' . $media->file_name);
        } else {
            $image_url = 'https://images.unsplash.com/photo-1497366216548-37526070297c';
        }

        $established_title = $postMeta['established_title'];
        $established_date = $postMeta['established_date'];

        $about_first_image = $postMeta['about_first_image'];
        $media = MediaHelper::getImageById($about_first_image);
        if (!empty($about_first_image) && !empty($media->file_name)) {
            $about_first_image_url = asset('storage/' . $media->file_name);
        } else {
            $about_first_image_url = null;
        }

        $about_second_image = $postMeta['about_second_image'];
        $media = MediaHelper::getImageById($about_second_image);
        if (!empty($about_second_image) && !empty($media->file_name)) {
            $about_second_image_url = asset('storage/' . $media->file_name);
        } else {
            $about_second_image_url = null;
        }

        $websiteName = SettingHelper::get_field('site_title');

        $commitment_bg_image = $postMeta['commitment_bg_image'];
        $media = MediaHelper::getImageById($commitment_bg_image);
        if (!empty($commitment_bg_image) && !empty($media->file_name)) {
            $commitment_bg_image_url = asset('storage/' . $media->file_name);
        } else {
            $commitment_bg_image_url = null;
        }

        $commitment_description = $postMeta['commitment_description'];
    @endphp

    <div class="container py-5">
        <h1>{{ $post->post_title }}</h1>

        <div class="row g-2 hero-grid mb-4">

            @if ($image_url)
                <div class="col-md-7"><img src="{{ $image_url }}" alt="{{ $post->post_title }}">
                </div>
            @endif

            @if ($about_first_image_url)
                <div class="col-md-3 d-lg-block d-none"><img src="{{ $about_first_image_url }}" alt="{{ $post->post_title }}">
                </div>
            @endif

            @if ($about_second_image_url)
                <div class="col-md-2 d-lg-block d-none"><img src="{{ $about_second_image_url }}"
                        alt="{{ $post->post_title }}">
                </div>
            @endif

        </div>

        <div class="row border-bottom-gray">
            <div class="col-lg-9">
                {!! $post->post_content !!}
            </div>

            @if ($established_title && $established_date)
                <div class="col-lg-3 text-end align-self-end">
                    <p class="mb-0 text-muted small">{{ $established_title }} | <strong
                            class="fs-4 text-dark">{{ $established_date }}</strong>
                    </p>
                </div>
            @endif

        </div>


        @php
            $mission_and_vision_details = $post->GetAllMetaData()['mission_and_vision_details'];
            $mission_and_vision_details = unserialize($mission_and_vision_details);
        @endphp

        @if (!empty($mission_and_vision_details))
            @php
                $count = 1;
            @endphp

            @foreach ($mission_and_vision_details as $item)
                @php
                    $image = $item['image'];
                    $media = MediaHelper::getImageById($image);
                    if (!empty($image) && !empty($media->file_name)) {
                        $image_url = asset('storage/' . $media->file_name);
                    } else {
                        $image_url = null;
                    }
                @endphp
                <div class="row align-items-center py-5 {{ $count % 2 == 0 ? 'flex-md-row-reverse' : '' }}">

                    @if ($image_url)
                        <div class="col-md-6">
                            <img src="{{ $image_url }}" class="img-fluid" alt="{{ $websiteName }}">
                        </div>
                    @endif

                    @if ($item['description'])
                        <div class="col-md-6 ">
                            {!! $item['description'] !!}
                        </div>
                    @endif

                </div>
                @php
                    $count++;
                @endphp
            @endforeach
        @endif


        @if (!empty($commitment_bg_image_url) || !empty($commitment_description))
            <div class="principles-section">

                @if (!empty($commitment_bg_image_url))
                    <div class="row">
                        <div class="col-lg-10">
                            <img src="{{ $commitment_bg_image_url }}" class="img-fluid w-100"
                                style="height: 450px; object-fit: cover;" alt="{{ $websiteName }}">
                        </div>
                    </div>
                @endif

                @if (!empty($commitment_description))
                    <div class="principles-card">
                        {!! $commitment_description !!}
                    </div>
                @endif

            </div>
        @endif

            @php
                $team_title = $postMeta['team_title'];
                $team_details = $postMeta['team_details'];
                $team_details = unserialize($team_details);
                $count = 1;
            @endphp

        @if (!empty($team_title) && !empty($team_details))
        <div class="py-5">
            <div class="section-header-featured">
                <h2>{{ $team_title }}</h2>
            </div>
            <div class="row mt-4">
                @foreach ($team_details as $item)
                    @php
                        $image = $item['image'];
                        $media = MediaHelper::getImageById($image);
                        if (!empty($image) && !empty($media->file_name)) {
                            $image_url = asset('storage/' . $media->file_name);
                        } else {
                            $image_url = null;
                        }
                    @endphp
                    <div class="col-md-4 mb-4">
                        <img src="{{ $image_url }}" class="author-img">
                        <span class="author-label">{{ $item['name'] }}</span>
                        <span class="author-sub">{{ $item['designation'] }}</span>
                    </div>
                    @php
                        $count++;
                    @endphp
                @endforeach

            </div>
        @endif
        </div>


        @php
        $faq_title = $postMeta['faq_title'];
        $faq_featured_image = $postMeta['faq_featured_image'];
        $media = MediaHelper::getImageById($faq_featured_image);
        if (!empty($faq_featured_image) && !empty($media->file_name)) {
            $faq_featured_image_url = asset('storage/' . $media->file_name);
        } else {
            $faq_featured_image_url = null;
        }
        $faq_details = $postMeta['faq_details'];
        $faq_details = unserialize($faq_details);

        @endphp

@if (!empty($faq_title) || !empty($faq_featured_image_url) || !empty($faq_details))
<div class="py-5">
            <div class="section-header-featured">
                <h2>{{ $faq_title }}</h2>
            </div>
            <div class="row mt-4">
                
                
                @if ($faq_featured_image_url)
                <div class="col-md-4">
                    <img src="{{ $faq_featured_image_url }}" class="img-fluid mb-4" alt="{{ $websiteName }}">
                </div>
                @endif

                <div class="col-md-8">
                    <div class="faq-custom-wrapper" id="faqAccordion">

                        @php
                            $count = 1;
                        @endphp
                        @foreach ($faq_details as $item)

                        
                        <div class="faq-item">
                            <button class="faq-trigger {{ $count == 1 ? 'collapsed' : '' }} " type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $count }}">
                                <span class="index-number">{{ $count }}</span>
                                <span class="faq-question">{{ $item['question'] }}</span>
                                <span class="toggle-icon"></span>
                            </button>
                            <div id="faq{{ $count }}" class="collapse {{ $count == 1 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                                <div class="faq-body">
                                    {!! $item['answer'] !!}
                                </div>
                            </div>
                        </div>
                        @php
                            $count++;
                        @endphp
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        @endif


    </div>
@endsection
