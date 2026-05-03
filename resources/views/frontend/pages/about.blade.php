@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $metaData, 'title' => $post->post_title])

@section('main-section')
    @php
        $featured_image = $post->GetAllMetaData()['featured_image'];
        $media = MediaHelper::getImageById($featured_image);

        if (!empty($featured_image) && !empty($media->file_name)) {
            $image_url = asset('storage/' . $media->file_name);
        } else {
            $image_url = 'https://images.unsplash.com/photo-1497366216548-37526070297c';
        }

        $established_title = $post->GetAllMetaData()['established_title'];
        $established_date = $post->GetAllMetaData()['established_date'];

        $about_first_image = $post->GetAllMetaData()['about_first_image'];
        $media = MediaHelper::getImageById($about_first_image);
        if (!empty($about_first_image) && !empty($media->file_name)) {
            $about_first_image_url = asset('storage/' . $media->file_name);
        } else {
            $about_first_image_url = null;
        }

        $about_second_image = $post->GetAllMetaData()['about_second_image'];
        $media = MediaHelper::getImageById($about_second_image);
        if (!empty($about_second_image) && !empty($media->file_name)) {
            $about_second_image_url = asset('storage/' . $media->file_name);
        } else {
            $about_second_image_url = null;
        }

        $websiteName = SettingHelper::get_field('site_title');

        $commitment_bg_image = $post->GetAllMetaData()['commitment_bg_image'];
        $media = MediaHelper::getImageById($commitment_bg_image);
        if (!empty($commitment_bg_image) && !empty($media->file_name)) {
            $commitment_bg_image_url = asset('storage/' . $media->file_name);
        } else {
            $commitment_bg_image_url = null;
        }

        $commitment_description = $post->GetAllMetaData()['commitment_description'];
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


        <div class="">
            <div class="section-header-featured">
                <h2>Our Team</h2>
            </div>
            <div class="row mt-4">
                <div class="col-md-4 mb-4">
                    <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6" class="author-img">
                    <span class="author-label">Kevin Perron</span>
                    <span class="author-sub">Author</span>
                </div>
                <div class="col-md-4 mb-4">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d" class="author-img">
                    <span class="author-label">Martin McKensey</span>
                    <span class="author-sub">Senior Reporter</span>
                </div>
                <div class="col-md-4 mb-4">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330" class="author-img">
                    <span class="author-label">Maria Florez</span>
                    <span class="author-sub">Author</span>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="section-header-featured">
                <h2>Have Any Questions?</h2>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/sidebar-banner.jpg') }}" class="img-fluid mb-4" alt="Interview">
                </div>
                <div class="col-md-8">
                    <div class="faq-custom-wrapper" id="faqAccordion">

                        <div class="faq-item">
                            <button class="faq-trigger" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <span class="index-number">1</span>
                                <span class="faq-question">How can I submit a news tip or story idea?</span>
                                <span class="toggle-icon"></span>
                            </button>
                            <div id="faq1" class="collapse show" data-bs-parent="#faqAccordion">
                                <div class="faq-body">
                                    You can submit news tips or story ideas by contacting our editorial team through the
                                    designated form on our website or via email at <a
                                        href="mailto:info@morningnews.io">info@morningnews.io</a>.
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-trigger collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq2">
                                <span class="index-number">2</span>
                                <span class="faq-question">How can I watch your news channel?</span>
                                <span class="toggle-icon"></span>
                            </button>
                            <div id="faq2" class="collapse" data-bs-parent="#faqAccordion">
                                <div class="faq-body">
                                    Details about channel frequency and streaming platforms go here.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-trigger collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq3">
                                <span class="index-number">3</span>
                                <span class="faq-question">How can I watch your news channel?</span>
                                <span class="toggle-icon"></span>
                            </button>
                            <div id="faq3" class="collapse" data-bs-parent="#faqAccordion">
                                <div class="faq-body">
                                    Details about channel frequency and streaming platforms go here.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
