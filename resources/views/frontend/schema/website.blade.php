{{-- <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "WebSite",
      "name": "{{ $websiteName }}",
      "url": "{{ url('/') }}",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ url('/') }}/search{search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script> --}}
<script type="application/ld+json">{"@context":"https://schema.org/","@type":"WebSite","name":"{{ $websiteName }}","url":"{{ url('/') }}","potentialAction":{"@type":"SearchAction","target":"{{ url('/') }}/search{search_term_string}","query-input":"required name=search_term_string"}}</script>
