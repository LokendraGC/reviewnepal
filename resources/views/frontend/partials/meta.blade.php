@php
    // Header logo and site name
    $headerLogo = SettingHelper::get_field('header_logo');
    $websiteName = SettingHelper::get_field('site_title');

    // Default content
    $content = '';
    if (isset($payload->post_content)) {
        $content = strip_tags($payload->post_content);
    } elseif (isset($payloadMeta['main_description'])) {
        $content = strip_tags($payloadMeta['main_description'] ?? '');
    }

    // SEO variables with safe fallbacks
    $seoTitle = $payloadMeta['seo_title'] ?? $title ?? $websiteName;
    $seoDescription = $payloadMeta['seo_description'] ?? substr(implode(' ', explode(' ', $content)), 0, 164);
    $seoKeywords = $payloadMeta['seo_keyword'] ?? ($title ?? $websiteName);

    // Open Graph image defaults
    $image = asset('assets/img/capital-sansar.svg');
    $alt = $websiteName;
    $type = 'image/svg+xml';

    if (!empty($payload)) {
        $dateString = $payload->updated_at ?? now();
        $carbonDate = \Carbon\Carbon::parse($dateString);
        $iso8601String = $carbonDate->toIso8601String();
    } else {
        $iso8601String = now()->toIso8601String();
    }

    // OG image from featured image or header logo
    if (!empty($payloadMeta['featured_image'])) {
        $media = MediaHelper::getModel()->find($payloadMeta['featured_image']);
        if ($media) {
            $image = asset('storage/' . $media->file_name);
            $alt = $media->alt ?? $seoTitle;
            $type = $media->type ?? 'image/jpeg';
        }
    } elseif ($headerLogo) {
        $media = MediaHelper::getModel()->find($headerLogo);
        if ($media) {
            $image = asset('storage/' . $media->file_name);
            $alt = $media->alt ?? $seoTitle;
            $type = $media->type ?? 'image/jpeg';
        }
    }

    // Favicon with fallback
    $faviconId = $settings['site_favicon'] ?? null;
    $favicon = $faviconId ? MediaHelper::getModel()->find($faviconId) : null;
    $faviconUrl = $favicon ? asset('storage/' . $favicon->file_name) : asset('favicon-1.png');
    $faviconType = $favicon->type ?? 'image/x-icon';
@endphp

<!-- Basic Meta -->
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>{{ SeoHelper::seo_title($seoTitle) }}</title>
<meta name="description" content="{{ SeoHelper::seo_title($seoDescription) }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<link rel="canonical" href="{{ url()->current() }}" />

<!-- Open Graph -->
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ SeoHelper::seo_title($seoTitle) }}" />
<meta property="og:description" content="{{ SeoHelper::seo_title($seoDescription) }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ $websiteName }}" />
<meta property="og:updated_time" content="{{ $iso8601String }}" />
<meta property="og:image" content="{{ $image }}" />
<meta property="og:image:secure_url" content="{{ $image }}" />
<meta property="og:image:alt" content="{{ $alt }}" />
<meta property="og:image:type" content="{{ $type }}" />

<!-- Favicon -->
<link rel="icon" href="{{ $faviconUrl }}" type="{{ $faviconType }}">
<link rel="shortcut icon" href="{{ $faviconUrl }}" type="{{ $faviconType }}">
<link rel="apple-touch-icon" href="{{ $faviconUrl }}">
<link rel="apple-touch-icon-precomposed" href="{{ $faviconUrl }}">