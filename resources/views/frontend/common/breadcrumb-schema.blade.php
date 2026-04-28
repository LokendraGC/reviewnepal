@push('schema')
    @php
        $position = 0;
        $convertedBreadcrumbsEntries = [];
        foreach ($breadcrumbs as $title => $url) {
            $position = $position + 1;
            $convertedBreadcrumbEntry = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $title,
                'item' => $url,
            ];
            $convertedBreadcrumbsEntries[] = $convertedBreadcrumbEntry;
        }

        $jsonFormat = json_encode($convertedBreadcrumbsEntries, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    @endphp
    @include('frontend.schema.breadcrumb', ['breadcrumbs' => $jsonFormat])
@endpush('schema')
