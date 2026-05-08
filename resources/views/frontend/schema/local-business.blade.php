@php
  $phone = SettingHelper::get_field('first_phone') ?: '';

  if ($headerLogo) {
    $media = MediaHelper::getImageById($headerLogo);
    $logo = $media && isset($media->file_name)
      ? asset('storage/' . $media->file_name)
      : asset('assets/images/review_nepal_logo.webp');
  } else {
    $logo = asset('assets/images/review_nepal_logo.webp');
  }

  $hotelSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'NewsMediaOrganization',
    'name' => $websiteName,
    'image' => $logo,
    '@id' => $logo,
    'url' => url('/'),
    'telephone' => $phone,
    'address' => [
      '@type' => 'PostalAddress',
      'streetAddress' => 'Shankhamul Brg, Kathmandu 44600',
      'addressLocality' => 'Kathmandu',
      'postalCode' => '44600',
      'addressCountry' => 'NP'
    ],
    'geo' => [
      '@type' => 'GeoCoordinates',
      'latitude' => 27.680442,
      'longitude' => 85.3305714
    ],
    'sameAs' => url('/')
  ];
@endphp

<script type="application/ld+json">
{!! json_encode($hotelSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>