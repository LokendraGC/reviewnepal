<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $websiteName = $settings['site_title'] ?? null;
        $headerLogo = $settings['header_logo'] ?? null;
    @endphp
    @include('frontend.partials.meta', [
        'payload' => $payload,
        'payloadMeta' => $payloadMeta,
        'title' => $title,
        'websiteName' => $websiteName,
        'headerLogo' => $headerLogo,
    ])
    @include('frontend.partials.css')

    {{-- schema --}}
    {{-- @include('frontend.schema.organization', ['websiteName' => $websiteName, 'headerLogo' => $headerLogo])
    @include('frontend.schema.website', ['websiteName' => $websiteName])
    @include('frontend.schema.local-business', [
        'websiteName' => $websiteName,
        'headerLogo' => $headerLogo,
    ])
    @stack('schema')
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=6652e88ffef97000199a5d0f&product=sop' async='async'></script> --}}

    @if ($additionalCSS = $settings['additional_CSS'] ?? null)
        <style>
            {{ $additionalCSS }}
        </style>
    @endif
</head>

<body>

    @include('frontend.layouts.header')

    @yield('main-section')

    @include('frontend.layouts.footer', ['websiteName' => $websiteName])

    @include('frontend.partials.js')

</body>

</html>
