@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $postMeta, 'title' => $post->post_title])

@section('main-section')
<main>
    <section class="container py-5" style="min-height: 50vh;">
     <div class="news-header-section">
     <h1 class="text-center text-black">Thank You for Subscribing</h1>

     <p class="text-center text-muted">{{ $message }}</p>
    
    <div class="text-center">
     <a href="{{ url('/') }}" class="btn btn-subscribe">Back to Home</a>
    </div>
    </div>
 </section>

 </main>
@endsection