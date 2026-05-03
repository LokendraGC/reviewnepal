@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $metaData, 'title' => $post->post_title])

@section('main-section')
    <div class="container py-5">
        <h1 class="contact-title">{{ $post->post_title }}</h1>


        @php
            $websiteName = SettingHelper::get_field('site_title');
            $first_email = SettingHelper::get_field('first_email');
            $second_email = SettingHelper::get_field('second_email');
            $first_phone = SettingHelper::get_field('first_phone');
            $second_phone = SettingHelper::get_field('second_phone');

            $featured_image = $post->GetAllMetaData()['featured_image'];
            $media = MediaHelper::getImageById($featured_image);

            if (!empty($featured_image) && !empty($media->file_name)) {
                $image_url = asset('storage/' . $media->file_name);
            } else {
                $image_url = asset('assets/images/675ad1eb807fade3fa7b4a5a_contact-image-p-500.jpg');
            }
        @endphp


        <div class="row g-5">
            <div class="col-lg-6">
                <div class="row">

                    {!! $post->post_content !!}

                    <div class="d-flex flex-column justify-content-center mt-4 mt-sm-0 w-50">

                        <span class="info-label"><b>Contact Us:</b></span>

                        <span><a href="mailto:{{ $first_email }}" class="info-detail">{{ $first_email }}</a>
                            @if ($second_email)
                                ,
                                <a href="mailto:{{ $second_email }}" class="info-detail">{{ $second_email }}</a>
                            @endif
                        </span>

                        <span><a href="tel:{{ $first_phone }}" class="info-detail">{{ $first_phone }}</a>
                            @if ($second_phone)
                                ,
                                <a href="tel:{{ $second_phone }}" class="info-detail">{{ $second_phone }}</a>
                            @endif
                        </span>

                        <hr />

                        @php
                            $medias = SettingHelper::get_field('social_media');
                            $social_medias = unserialize($medias);
                        @endphp

                        @if (!empty($social_medias))
                            <span class="info-label">Follow Us</span>
                            <div class="d-flex">
                                @foreach ($social_medias as $social_media)
                                    <a href="{{ $social_media['link'] ? $social_media['link'] : 'javascript:void(0)' }}"
                                        target="{{ $social_media['link'] ? '_blank' : '_self' }}" class="social-btn">
                                        <i class="fa-brands {{ $social_media['media'] }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <img src="{{ $image_url }}"
                    alt="{{ $post->post_title }}" class="info-img" />
            </div>
        </div>
    </div>
@endsection
