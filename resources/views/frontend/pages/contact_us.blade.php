@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $metaData, 'title' => $post->post_title])

@section('main-section')
<div class="container py-5">
    <h1 class="contact-title">Contact Us</h1>

    <div class="row g-5">
        <div class="col-lg-6">
            <div class="row">
                <p class="contact-desc">
                    Tell us about your needs! Send us a quick message using the form
                    below, and our dedicated support team will get back to you
                    promptly.
                </p>

                <div class="d-flex flex-column justify-content-center mt-4 mt-sm-0">
                    <span class="info-label">Contact Us</span>
                    <a href="mailto:hello@example.com" class="info-detail">hello@example.com</a>
                    <a href="tel:+14065550120" class="info-detail">+1 (406) 555-0120</a>

                    <hr />

                    <span class="info-label">Follow Us</span>
                    <div class="d-flex">
                        <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <img src="{{asset('assets/images/675ad1eb807fade3fa7b4a5a_contact-image-p-500.jpg')}}" alt="Contact person"
                class="info-img" />
        </div>
    </div>
</div>
@endsection