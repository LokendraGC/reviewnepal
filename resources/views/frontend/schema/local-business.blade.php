@php
    $phone = SettingHelper::get_field('phone') ? SettingHelper::get_field('phone') : '';
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
      "@type": "TravelAgency",
      "name": "{{ $websiteName }}",
      "image": "{{ $logo }}",
      "@id": "{{ $logo }}",
      "url": "{{ url('/') }}",
      "telephone": "{{ $phone }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Lazimpat",
        "addressLocality": "Kathmandu",
        "postalCode": "44600",
        "addressCountry": "NP"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 27.7236763,
        "longitude": 85.3210589
      } ,
      "sameAs": "{{ url('/') }}"
    }
    </script> --}}

<script type="application/ld+json">{"@context":"https://schema.org","@type":"TravelAgency","name":"{{ $websiteName }}","image":"{{ $logo }}","@id":"{{ $logo }}","url":"{{ url('/') }}","telephone":"{{ $phone }}","address":{"@type":"PostalAddress","streetAddress":"Lazimpat","addressLocality":"Kathmandu","postalCode":"44600","addressCountry":"NP"},"geo":{"@type":"GeoCoordinates","latitude":27.7236763,"longitude":85.3210589},"sameAs":"{{ url('/') }}"}</script>
