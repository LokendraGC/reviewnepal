@if ($headerLogo)
    @php
        $media = MediaHelper::getImageById($headerLogo);
        $logo = $media && isset($media->file_name)
            ? asset('storage/' . $media->file_name)
            : asset('assets/img/logo/neev-logo.png');
    @endphp
@else
    @php
        $logo = asset('assets/img/logo/neev-logo.png');
    @endphp
@endif

@php
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $websiteName,
        'alternateName' => $websiteName,
        'url' => url('/'),
        'logo' => $logo,
        'sameAs' => [url('/')],
    ];
@endphp

<script type="application/ld+json">
    {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>