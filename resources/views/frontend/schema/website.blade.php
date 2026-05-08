@php
  $schemaWebsite = [
    '@context' => 'https://schema.org/',
    '@type' => 'WebSite',
    'name' => $websiteName,
    'url' => url('/'),
    'potentialAction' => [
      '@type' => 'SearchAction',
      'target' => url('/') . '/search{search_term_string}',
      'query-input' => 'required name=search_term_string'
    ]
  ];
@endphp

<script type="application/ld+json">
{!! json_encode($schemaWebsite, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>