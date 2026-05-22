<footer class="ok-dark-bar">
    <div class="container">
        <div class="row align-items-center g-0">

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

            $director_name = SettingHelper::get_field('director_name');
            $editor_name = SettingHelper::get_field('editor_name');
            $registration_number = SettingHelper::get_field('registration_number');
            $director_name_nepali = SettingHelper::get_field('director_name_nepali');
            $editor_name_nepali = SettingHelper::get_field('editor_name_nepali');
            $registration_number_nepali = SettingHelper::get_field('registration_number_nepali');

            $language = LanguageHelper::getUserLanguage();

            $popup_ads_data = SettingHelper::get_field('popup_ads');

            $popup_ads = !empty($popup_ads_data) ? unserialize($popup_ads_data) : null;

            $show_popup_on_homepage_only = SettingHelper::get_field('show_popup_on_homepage');
            $show_popup = SettingHelper::get_field('show_popup');

            // Check if current page is homepage
            $isHomepage = request()->is('/');

            // Decide whether popup should display
            $shouldShowPopup = !$show_popup_on_homepage_only || $isHomepage;


        @endphp


         @if ($show_popup)
                @if ($shouldShowPopup)

                    <div class="popup-ads">
                        @php
                            $popups = [];
                            if (is_array($popup_ads)) {
                                foreach ($popup_ads as $item) {
                                    if (!empty($item['image'])) {
                                        $media = \App\Models\Media::find($item['image']);

                                        if ($media && !empty($media->file_name)) {
                                            $popups[] = [
                                                'image_url' => asset('storage/' . $media->file_name),
                                                'ad_link' => $item['ad_link'] ?? '',
                                            ];
                                        }
                                    }
                                }
                            }
                        @endphp

                        @if (!empty($popups))
                            <div id="popup-ad-overlay" class="popup-ad-overlay">
                                @foreach ($popups as $index => $popup)
                                    <div class="popup-ad-container" id="popup-ad-{{ $index }}"
                                        style="display: {{ $index === 0 ? 'block' : 'none' }};">

                                        <div class="popup-ad-card">

                                            <div class="popup-ad-header">
                                                <span class="popup-ad-tag">Advertisement</span>

                                                <button class="popup-ad-close"
                                                    onclick="closePopupAd({{ $index }})" aria-label="Close Ad">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                        height="18" fill="currentColor" viewBox="0 0 16 16">

                                                        <path
                                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                    </svg>

                                                </button>
                                            </div>

                                            <div class="popup-ad-body">
                                                @if (!empty($popup['ad_link']))
                                                    <a href="{{ $popup['ad_link'] }}" target="_blank"
                                                        class="popup-ad-link">

                                                        <img src="{{ $popup['image_url'] }}" alt="Advertisement">

                                                    </a>
                                                @else
                                                    <div class="popup-ad-link">
                                                        <img src="{{ $popup['image_url'] }}" alt="Advertisement">
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                @endif
            @endif

            <div class="col-xl-2 col-lg-12 ok-col text-center">
                <div class="ok-brand-wrap">
                    <a href="{{ url('/') }}">
                        <img src="{{ $image_url }}" alt="{{ $websiteName }}" class="ok-logo" style="width: 180px;">
                    </a>
                </div>
            </div>

            @if (!empty($director_name) && !empty($director_name_nepali))
                <div class="col-xl-2 col-md-4 ok-col ok-v-border">
                    <div class="ok-info">
                        <span class="ok-lbl">{{ $language == 'en' ? 'Managing Director' : 'प्रबन्ध निर्देशक' }}</span>
                        <span class="ok-val">{{ $language == 'en' ? $director_name : $director_name_nepali }}</span>
                    </div>
                </div>
            @endif


            @if (!empty($editor_name) && !empty($editor_name_nepali))
                <div class="col-xl-2 col-md-4 ok-col ok-v-border">
                    <div class="ok-info">
                        <span class="ok-lbl">{{ $language == 'en' ? 'Editor' : 'सम्पादक' }}</span>
                        <span class="ok-val">{{ $language == 'en' ? $editor_name : $editor_name_nepali }}</span>
                    </div>
                </div>
            @endif

            @if (!empty($registration_number) && !empty($registration_number_nepali))
                <div class="col-xl-1 col-md-4 ok-col ok-v-border">
                    <div class="ok-info">
                        <span class="ok-lbl">{{ $language == 'en' ? 'Reg No.' : 'दर्ता नं.' }}</span>
                        <span
                            class="ok-val">{{ $language == 'en' ? $registration_number : $registration_number_nepali }}</span>
                    </div>
                </div>
            @endif

            @if (!empty($first_phone) || !empty($second_phone) || !empty($first_email) || !empty($second_email))
                <div class="col-xl-3 col-md-6 ok-col ok-v-border">
                    <div class="ok-info">
                        @if (!empty($first_phone) || !empty($second_phone))
                            <span class="ok-val">
                                @if (!empty($first_phone))
                                    <a href="tel:{{ $first_phone }}">{{ $first_phone }}</a>
                                @endif
                                @if (!empty($second_phone))
                                    ,
                                    <a href="tel:{{ $second_phone }}">{{ $second_phone }}
                                    </a>
                                @endif
                            </span>
                        @endif
                        @if (!empty($first_email) || !empty($second_email))
                            @if (!empty($first_email))
                                <a href="mailto:{{ $first_email }}" class="ok-link">{{ $first_email }}
                                </a>
                            @endif
                            @if (!empty($second_email))
                                ,
                                <a href="mailto:{{ $second_email }}" class="ok-link">{{ $second_email }}
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            @endif

            @php
            $medias = SettingHelper::get_field('social_media');
            $social_medias = unserialize($medias);
            @endphp

            @if (!empty($social_medias))
            <div class="col-xl-2 col-md-6 ok-col ok-v-border">
                <div class="ok-social-box">
                  <span class="ok-lbl">Follow Us:</span>
                    <div class="ok-icons">

                        @foreach ($social_medias as $social_media)
                            
                        <a href="{{ $social_media['link'] ? $social_media['link'] : 'javascript:void(0)' }}" target="{{ $social_media['link'] ? '_blank' : '_self' }}" class="ok-icon-link">
                            <i class="fab {{ $social_media['media'] }}"></i></a>
                            @endforeach

                    </div>
                    
                </div>
            </div>
            @endif

            <div class="col-xl-12 col-md-6 border-top-new mt-4 pt-3 text-center">
                <p class="ok-copy">© 2014 - {{ date('Y') }} {{ $websiteName }}. All Rights Reserved Developed By <a href="https://webtechnepal.com/" target="_blank">Webtech Nepal</a>
                </p>
            </div>


        </div>
    </div>
</footer>


@push('frontend-js')
    <script>
        (function() {
            const totalPopups = {{ is_array($popups ?? null) ? count($popups) : 0 }};
            window.closePopupAd = function(index) {
                const currentPopup = document.getElementById('popup-ad-' + index);
                if (currentPopup) {
                    currentPopup.style.display = 'none';
                }

                const nextIndex = index + 1;
                const nextPopup = document.getElementById('popup-ad-' + nextIndex);
                if (nextIndex < totalPopups && nextPopup) {
                    nextPopup.style.display = 'block';
                } else {
                    const overlay = document.getElementById('popup-ad-overlay');
                    if (overlay) {
                        overlay.style.display = 'none';
                    }
                }
            };
        })();
    </script>
@endpush
