<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>{{ isset($payloadMeta['seo_title']) ? SeoHelper::seo_title($payloadMeta['seo_title']) : $title . ' - ' . $websiteName }}</title>
<meta name="description" content="{{ isset($payloadMeta['seo_description']) ? SeoHelper::seo_title($payloadMeta['seo_description']) : '' }}" />
<link rel="canonical" href="{{ url()->current() }}" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ isset($payloadMeta['seo_title']) ? SeoHelper::seo_title($payloadMeta['seo_title']) : $title . ' - ' . $websiteName }}" />
<meta property="og:description" content="{{ isset($payloadMeta['seo_description']) ? SeoHelper::seo_title($payloadMeta['seo_description']) : '' }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ $websiteName }}" />
@php
    $dateString = $payload->updated_at;
    $carbonDate = \Carbon\Carbon::parse($dateString);
    $iso8601String = $carbonDate->toIso8601String();
    if (isset($payloadMeta['featured_image']) && url()->current() !== url('/') && ($media = MediaHelper::getModel()->where('id', $payloadMeta['featured_image'])->first())) {
        $image = asset('storage/' . $media->file_name);
        $alt = $media->alt ? $media->alt : (isset($payloadMeta['seo_title']) ? SeoHelper::seo_title($payloadMeta['seo_title']) : SettingHelper::get_field('site_title'));
        $type = $media->type;
    } else {
        if ($headerLogo && ($media = MediaHelper::getModel()->where('id', $headerLogo)->first())) {
            $image = asset('storage/' . $media->file_name);
            $alt = $media->alt ? $media->alt : (isset($payloadMeta['seo_title']) ? SeoHelper::seo_title($payloadMeta['seo_title']) : SettingHelper::get_field('site_title'));
            $type = $media->type;
        } else {
            $image = asset('assets/img/capital-sansar.svg');
            $alt= SettingHelper::get_field('site_title');
            $type = 'image/svg+xml';
        }
    }
@endphp
<meta property="og:updated_time" content="{{ $iso8601String }}" />
<meta property="og:image" content="{{ $image }}" />
<meta property="og:image:secure_url" content="{{ $image }}" />
<meta property="og:image:alt" content="{{ $alt }}" />
<meta property="og:image:type" content="{{ $type }}" />
@if ( ( $favicon = SettingHelper::get_field('site_favicon') ) && ( $siteFavicon = MediaHelper::getModel()->where('id', $favicon)->first() ) )
<link rel="icon" href="{{ asset('storage/'. $siteFavicon->file_name ) }}" type="{{ $siteFavicon->type }}">
<link rel="apple-touch-icon" href="{{ asset('storage/'. $siteFavicon->file_name ) }}">
<link rel="apple-touch-icon-precomposed" href="{{ asset('storage/'. $siteFavicon->file_name ) }}">
<link rel="shortcut icon" href="{{ asset('storage/'. $siteFavicon->file_name ) }}" type="{{ $siteFavicon->type }}">
@endif
