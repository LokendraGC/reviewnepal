{!! '<' . '?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toIso8601String() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    {{-- @if ($tours->isNotEmpty())
        @foreach ($tours as $tour)
            <url>
                <loc>{{ route('frontend.tour.index', $tour->slug) }}</loc>
                <lastmod>{{ $tour->updated_at->toIso8601String() }}</lastmod>
                <priority>0.8</priority>
            </url>
        @endforeach
    @endif --}}
    @if ($pages->isNotEmpty())
        @foreach ($pages as $page)
            <url>
                <loc>{{ route('frontend.post.index', $page->slug) }}</loc>
                <lastmod>{{ $page->updated_at->toIso8601String() }}</lastmod>
            </url>
        @endforeach
    @endif
    @if ($categories->isNotEmpty())
        @foreach ($categories as $cat)
            <url>
                <loc>{{ route('frontend.category.index', $cat->slug) }}</loc>
                <lastmod>{{ \Carbon\Carbon::parse($cat->updated_at)->toIso8601String() }}</lastmod>
                <priority>0.7</priority>
            </url>
        @endforeach
    @endif
</urlset>
