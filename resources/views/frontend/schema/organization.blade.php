@php
    if ($headerLogo) {
        $logo = unserialize($headerLogo);
        $logo = asset('storage/' . $logo[0]['file_name']);
    } else {
        $logo = asset('front/img/general/logo-1.svg');
    }
@endphp

{{-- <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "{{ $websiteName }}",
      "alternateName": "{{ $websiteName }}",
      "url": "{{ url('/') }}",
      "logo": "{{ $logo }}",
      "sameAs": "{{ url('/') }}"
    }
    </script> --}}
<script type="application/ld+json">{"@context":"https://schema.org","@type":"Organization","name":"{{ $websiteName }}","alternateName":"{{ $websiteName }}","url":"{{ url('/') }}","logo":"{{ $logo }}","sameAs":"{{ url('/') }}"}</script>
