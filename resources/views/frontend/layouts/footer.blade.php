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

                $medias = SettingHelper::get_field('social_media');
                $social_medias = unserialize($medias);

            @endphp

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
                <div class="col-xl-2 col-md-4 ok-col ok-v-border">
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


            @if (!empty($social_medias))
                <div class="col-xl-1 col-md-6 ok-col ok-v-border">
                    <div class="ok-social-box">
                        <span class="ok-lbl">Follow Us:</span>
                        <div class="ok-icons">
                            @foreach ($social_medias as $social_media)
                                <a href="{{ $social_media['link'] ? $social_media['link'] : 'javascript:void(0)' }}"
                                    target="{{ $social_media['link'] ? '_blank' : '_self' }}" class="social-btn">
                                    <i class="fa-brands {{ $social_media['media'] }}"></i>
                                </a>
                            @endforeach
                        </div>

                    </div>
                </div>
            @endif


            <div class="col-xl-12 col-md-6 border-top-new mt-4">
                <p class="ok-copy">© 2006-2026 reviewnepal.com All Rights Reserved Developed By <a>Webtech Nepal</a>
                </p>
            </div>
        </div>
    </div>
</footer>
