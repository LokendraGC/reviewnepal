@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $metaData, 'title' => $post->post_title])

@section('main-section')


<div class="container py-5">
    <h1>About us</h1>

    <div class="row g-2 hero-grid mb-4">
        <div class="col-md-7"><img src="https://images.unsplash.com/photo-1497366216548-37526070297c" alt="Office">
        </div>
        <div class="col-md-3 d-lg-block d-none"><img src="https://images.unsplash.com/photo-1560250097-0b93528c311a" alt="Executive">
        </div>
        <div class="col-md-2 d-lg-block d-none"><img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2" alt="Speaker">
        </div>
    </div>

    <div class="row border-bottom-gray">
        <div class="col-lg-9">
            <h3>The History of Morning News</h3>
            <p>Our journey began with a dedication to create a news channel that goes beyond the headlines,
                providing our audience with insightful, thought-provoking, and impactful news coverage that informs,
                educates, and empowers.</p>
        </div>
        <div class="col-lg-3 text-end align-self-end">
            <p class="mb-0 text-muted small">Established in Georgia, USA | <strong
                    class="fs-4 text-dark">2012</strong></p>
        </div>
    </div>

    <div class="row align-items-center py-5">
        <div class="col-md-6">
            <img src="{{ asset('assets/images/4.jpg')}}" class="img-fluid" alt="Mission">
        </div>
        <div class="col-md-6 ">
            <h3>Our Mission</h3>
            <p>We are dedicated to providing our audience with accurate, impartial, and insightful news coverage.
                Our mission is not just about reporting the news; it's about making the world more accessible,
                simplifying complex issues.</p>
            <p>We believe that journalism is a public trust, and we take our responsibility to our audience
                seriously, ensuring accuracy and fairness.</p>
        </div>
    </div>

    <div class="row align-items-center py-5 flex-md-row-reverse">
        <div class="col-md-6">
            <img src="{{ asset('assets/images/1.jpg')}}" class="img-fluid" alt="Vision">
        </div>
        <div class="col-md-6">
            <h3>Our Vision</h3>
            <p>We envision a future where every individual has access to accurate, reliable, and diverse news
                coverage that empowers them to make informed decisions and engage meaningfully with their
                communities.</p>
            <p>The vision starts with the belief that journalism has the power to inspire, educate, and unite people
                from all walks of life.</p>
        </div>
    </div>

    <div class="principles-section">
        <div class="row">
            <div class="col-lg-10">
                <img src="{{ asset('assets/images/3.jpg')}}" class="img-fluid w-100"
                    style="height: 450px; object-fit: cover;" alt="Team">
            </div>
        </div>
        <div class="principles-card">
            <span class="text-uppercase small fw-bold text-muted">Commitment & Principles</span>
            <p class="mt-2 small text-muted">With strong ethics, showing how our work provides a reference point for
                information, reflecting our commitment to excellence, innovation, and serving our audience.</p>
            <ul class="principles-list">
                <li>Passion and Perseverance</li>
                <li>Audience Growth</li>
                <li>Collaboration and Connection</li>
                <li>Integrity Always</li>
                <li>Community Engagement</li>
            </ul>
        </div>
    </div>

    <div class="">
        <div class="section-header-featured">
            <h2>Our Team</h2>
        </div>
        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6" class="author-img">
                <span class="author-label">Kevin Perron</span>
                <span class="author-sub">Author</span>
            </div>
            <div class="col-md-4 mb-4">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d" class="author-img">
                <span class="author-label">Martin McKensey</span>
                <span class="author-sub">Senior Reporter</span>
            </div>
            <div class="col-md-4 mb-4">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330" class="author-img">
                <span class="author-label">Maria Florez</span>
                <span class="author-sub">Author</span>
            </div>
        </div>
    </div>

    <div class="py-5">
        <div class="section-header-featured">
            <h2>Have Any Questions?</h2>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <img src="{{ asset('assets/images/sidebar-banner.jpg')}}" class="img-fluid mb-4"
                    alt="Interview">
            </div>
            <div class="col-md-8">
                <div class="faq-custom-wrapper" id="faqAccordion">

                    <div class="faq-item">
                        <button class="faq-trigger" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            <span class="index-number">1</span>
                            <span class="faq-question">How can I submit a news tip or story idea?</span>
                            <span class="toggle-icon"></span>
                        </button>
                        <div id="faq1" class="collapse show" data-bs-parent="#faqAccordion">
                            <div class="faq-body">
                                You can submit news tips or story ideas by contacting our editorial team through the designated form on our website or via email at <a href="mailto:info@morningnews.io">info@morningnews.io</a>.
                            </div>
                        </div>
                    </div>

                    <div class="faq-item">
                        <button class="faq-trigger collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            <span class="index-number">2</span>
                            <span class="faq-question">How can I watch your news channel?</span>
                            <span class="toggle-icon"></span>
                        </button>
                        <div id="faq2" class="collapse" data-bs-parent="#faqAccordion">
                            <div class="faq-body">
                                Details about channel frequency and streaming platforms go here.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-trigger collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            <span class="index-number">3</span>
                            <span class="faq-question">How can I watch your news channel?</span>
                            <span class="toggle-icon"></span>
                        </button>
                        <div id="faq3" class="collapse" data-bs-parent="#faqAccordion">
                            <div class="faq-body">
                                Details about channel frequency and streaming platforms go here.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection