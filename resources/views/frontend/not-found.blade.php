@extends('frontend.layouts.app', ['title' => 'Page Not Found', 'payload' => null, 'payloadMeta' => null])

@section('main-section')
<main>
       <section class="container py-5" style="min-height: 50vh;">
        <div class="news-header-section">
        <h1 class="text-center text-black">Page Not Found</h1>

        <p class="text-center text-muted">The page you are looking for does not exist.</p>
       
       <div class="text-center">
        <a href="{{ url('/') }}" class="btn btn-subscribe">Back to Home</a>
       </div>
       </div>
    </section>

    </main>
@endsection