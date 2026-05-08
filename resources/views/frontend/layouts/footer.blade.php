<footer class="amko-footer">
    <div class="container">

        <div class="row align-items-start ">

            @php
                $footer_logo = SettingHelper::get_field('footer_logo');
                $media = $footer_logo ? MediaHelper::getImageById($footer_logo) : null;
                $websiteName = SettingHelper::get_field('site_title');
                $footer_text = SettingHelper::get_field('footer_text');
                $first_email = SettingHelper::get_field('first_email');
                $second_email = SettingHelper::get_field('second_email');
                $first_phone = SettingHelper::get_field('first_phone');
                $second_phone = SettingHelper::get_field('second_phone');
                $subscribe_text = SettingHelper::get_field('subscribe_text');

                if (!empty($media) && !empty($media->file_name)) {
                    $image_url = asset('storage/' . $media->file_name);
                } else {
                    $image_url = asset('assets/images/reviewnepal-logo-footer.svg');
                }

            @endphp

            <div class="col-lg-4 col-md-12 mb-5 mb-lg-0">
                <a href="{{ '/' }}"><img src="{{ $image_url }}" alt="{{ $websiteName }}"></a>
                <p class="footer-tagline">{{ $footer_text }}</p>
            </div>

            @php
                $medias = SettingHelper::get_field('social_media');
                $social_medias = unserialize($medias);
            @endphp

            @if (!empty($social_medias))
                <div class="col-lg-4 col-md-6 mb-5 mb-md-0">
                    <div class="row social-links">
                        @foreach ($social_medias as $social_media)
                            @php
                                $media = $social_media['media'];
                                $media_text = '';
                                foreach (\App\Enums\SocialMediaType::getKeyValuePairs() as $label => $value) {
                                    if ($value == $media) {
                                        $media_text = $label;
                                        break;
                                    }
                                }
                            @endphp
                            <div class="col-3">
                                <a href="{{ $social_media['link'] ? $social_media['link'] : 'javascript:void(0)' }}"
                                    target="{{ $social_media['link'] ? '_blank' : '_self' }}">
                                    {{ $media_text }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="col-lg-4 col-md-6">

                @if ($subscribe_text)
                    <h2 class="subscribe-title">{{ $subscribe_text }}</h2>
                @endif

                <form class="subscribe-form">
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </span>
                        <input type="email" class="form-control" placeholder="Enter your e-mail..." required>
                        <button class="btn btn-subscribe" type="button">SUBSCRIBE NOW</button>
                    </div>
                </form>
            </div>
        </div>

        @php
            $footerMenuFirst = CategoryHelper::getModel()
                ->where(['id' => 146, 'type' => 'nav_menu'])
                ->first();
        @endphp


        @if (!empty($footerMenuFirst))
            <div class="footer-divider"></div>
            <div class="footer-nav">

                @include('frontend.layouts.footer-menu', [
                    'footerMenu' => $footerMenuFirst,
                ])

            </div>
        @endif


        <div
            class="footer-bottom-divider d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <p class="footer-meta-text">Copyright © {{ date('Y') }} {{ $websiteName }}. All rights reserved.</p>

            <div class="footer-contact-info footer-meta-text">
                <span><a href="mailto:{{ $first_email }}">{{ $first_email }}</a>
                    @if ($second_email)
                        ,
                        <a href="mailto:{{ $second_email }}">{{ $second_email }}</a>
                    @endif
                </span>
                <span><a href="tel:{{ $first_phone }}">{{ $first_phone }}</a>
                    @if ($second_phone)
                        , <a href="tel:{{ $second_phone }}">{{ $second_phone }}</a>
                    @endif
                </span>
            </div>
        </div>

    </div>
</footer>
