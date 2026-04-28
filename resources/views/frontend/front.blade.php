@extends('frontend.layouts.app', ['payload' => $post, 'payloadMeta' => $postMeta, 'title' => $post->post_title])

@section('main-section')
<main>
    <section class="container my-5">
        <div class="news-header-section">
            <h1 class="main-headline">
                Artificial intelligence reshape healthcare
            </h1>

            <div class="news-meta">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/images/3.jpg') }}" alt="Logo" class="meta-logo me-2">
                    <span class="meta-author">Review Nepal</span>
                </div>
                <span><i class="fa-regular fa-calendar-days"></i>
                    Apr 19, 2026</span>
            </div>
        </div>

        <div class="featured-image-container">
            <img src="{{ asset('assets/images/3.jpg') }}" alt="Protest Image">
            <p class="image-caption">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ducimus laudantium consequuntur velit nisi ipsam,
                dicta sunt placeat repudiandae voluptate ab hic natus architecto. A amet officia incidunt ex recusandae
                perspiciatis.
            </p>
        </div>
    </section>

    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <div class="ad-wrapper">
                    <span class="ad-label">- Advertisement -</span>
                    <a href="#">
                        <img src="{{ asset('assets/images/OnlinePortal_1230X100-ezgif.com-video-to-gif-converter.gif') }}" alt="Full Width Ad"
                            class="ad-full-width">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="morning-hero-section">
        <div class="morning-container">

            <div class="hero-left-col">

                <div class="hero-primary-grid">

                    <div class="primary-content">
                        <span class="story-tag">WORLD NEWS</span>
                        <h2 class="primary-title">Global leaders unite to address climate crisis at COP26</h2>
                        <p class="primary-excerpt">Amid escalating tensions & humanitarian crises in various conflict hotspots
                            around the world leaders have convened to address the pressing need for peaceful resolutions.</p>
                        <div class="story-meta">
                            <span class="author">Albert Flores</span>
                            <span class="date">May 13, 2024</span>
                        </div>
                    </div>

                    <div class="primary-image-wrapper">
                        <img src="{{ asset('assets/images/1.jpg') }}" alt="Global Leaders Conference">
                        <div class="live-updates-badge">
                            <span class="pulse-dot"></span> Live Updates
                        </div>
                    </div>

                </div>

                <div class="hero-secondary-grid">

                    <article class="bottom-card">
                        <img src="{{ asset('assets/images/2.jpg') }}" alt="Cybersecurity Padlock">
                        <h3 class="card-title">Cybersecurity experts warn of increased threats</h3>
                        <div class="story-meta">
                            <span class="author">Esther Howard</span>
                            <span class="date">May 13, 2024</span>
                        </div>
                    </article>

                    <article class="bottom-card">
                        <img src="{{ asset('assets/images/3.jpg') }}" alt="Chemistry Beakers">
                        <h3 class="card-title">Chemical currents breaking news in chemistry and materials science</h3>
                        <div class="story-meta">
                            <span class="author">Esther Howard</span>
                            <span class="date">May 13, 2024</span>
                        </div>
                    </article>

                    <article class="bottom-card">
                        <img src="{{ asset('assets/images/4.jpg') }}" alt="Satellite Dish">
                        <h3 class="card-title">Updates on environmental science and space exploration</h3>
                        <div class="story-meta">
                            <span class="author">Jane Cooper</span>
                            <span class="date">May 13, 2024</span>
                        </div>
                    </article>

                </div>

            </div>

            <div class="hero-right-col">

                <article class="sidebar-featured">
                    <img src="{{ asset('assets/images/5.jpg') }}" alt="Football Player">
                    <span class="story-tag">SPORTS</span>
                    <h3 class="sidebar-featured-title">Athlete achieves historic win at world championships</h3>
                    <div class="story-meta">
                        <span class="author">Wade Warren</span>
                        <span class="date">May 13, 2024</span>
                    </div>
                </article>

                <div class="sidebar-list">

                    <article class="list-item">
                        <img src="{{ asset('assets/images/2.jpg')}}" alt="AI Chip">
                        <div class="list-content">
                            <span class="story-tag">TECHNOLOGY</span>
                            <h4 class="list-title">Artificial intelligence reshape healthcare diagnosis and</h4>
                        </div>
                    </article>

                    <article class="list-item">
                        <img src="{{ asset('assets/images/3.jpg')}}" alt="Martial Arts">
                        <div class="list-content">
                            <span class="story-tag">SPORTS</span>
                            <h4 class="list-title">Scandal rocks professional sports league</h4>
                        </div>
                    </article>


                    <article class="list-item">
                        <img src="{{ asset('assets/images/4.jpg')}}" alt="Charts">
                        <div class="list-content">
                            <span class="story-tag">BUSINESS</span>
                            <h4 class="list-title">Blockchain innovations revolutionize supply chain</h4>
                        </div>
                    </article>

                </div>

            </div>

        </div>
    </section>

    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <div class="ad-wrapper">
                    <span class="ad-label">- Advertisement -</span>
                    <a href="#">
                        <img src="{{ asset('assets/images/OnlinePortal_1230X100-ezgif.com-video-to-gif-converter.gif')}}')}}" alt="Full Width Ad"
                            class="ad-full-width">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">

        <div class="section-header d-flex justify-content-between">
            <h2 class="m-0">Views</h2>
            <a href="#" class="cat-link mt-auto">View All <span>&rarr;</span></a>
        </div>

        <div class="row justify-content-between">

            <div class="col-lg-7">

                <article class="d-flex flex-column flex-md-row gap-4 mb-5">
                    <img src="{{ asset('assets/images/5.jpg')}}" alt="Padlock Keyboard" class="news-img flex-shrink-0">
                    <div>
                        <a href="#" class="article-title d-block">Cybersecurity experts warn of increased threats</a>
                        <p class="article-excerpt">This warning serves as a stark reminder of the critical imperative to bolster
                            cybersecurity frameworks and stay vigilant against emerging digital vulnerabilities.</p>
                        <div class="meta-text">
                            <span class="meta-category">Technology</span> | <span class="ms-2">May 13, 2024</span>
                        </div>
                    </div>
                </article>

                <article class="d-flex flex-column flex-md-row gap-4 mb-5">
                    <img src="{{ asset('assets/images/1.jpg')}}" alt="American Football" class="news-img flex-shrink-0">
                    <div>
                        <a href="#" class="article-title d-block">Athlete achieves historic win at world championships</a>
                        <p class="article-excerpt">This landmark achievement not only signifies Warren's exceptional prowess and
                            dedication but also stands as a testament to the power of relentless training.</p>
                        <div class="meta-text">
                            <span class="meta-category">Sports</span> | <span class="ms-2">May 13, 2024</span>
                        </div>
                    </div>
                </article>

                <article class="d-flex flex-column flex-md-row gap-4 mb-5">
                    <img src="{{ asset('assets/images/3.jpg')}}" alt="Chemistry Beakers" class="news-img flex-shrink-0">
                    <div>
                        <a href="#" class="article-title d-block">Chemical currents breaking news in chemistry and materials
                            science</a>
                        <p class="article-excerpt">From unveiling novel compounds and catalysts to pioneering advances in
                            nanotechnology and biomaterials, the breaking news offers a glimpse into the molecular realm.</p>
                        <div class="meta-text">
                            <span class="meta-category">Health</span> | <span class="ms-2">May 13, 2024</span>
                        </div>
                    </div>
                </article>
                <article class="d-flex flex-column flex-md-row gap-4 mb-5">
                    <img src="{{ asset('assets/images/5.jpg')}}" alt="Padlock Keyboard" class="news-img flex-shrink-0">
                    <div>
                        <a href="#" class="article-title d-block">Cybersecurity experts warn of increased threats</a>
                        <p class="article-excerpt">This warning serves as a stark reminder of the critical imperative to bolster
                            cybersecurity frameworks and stay vigilant against emerging digital vulnerabilities.</p>
                        <div class="meta-text">
                            <span class="meta-category">Technology</span> | <span class="ms-2">May 13, 2024</span>
                        </div>
                    </div>
                </article>

                <article class="d-flex flex-column flex-md-row gap-4 mb-5">
                    <img src="{{ asset('assets/images/2.jpg')}}" alt="American Football" class="news-img flex-shrink-0">
                    <div>
                        <a href="#" class="article-title d-block">Athlete achieves historic win at world championships</a>
                        <p class="article-excerpt">This landmark achievement not only signifies Warren's exceptional prowess and
                            dedication but also stands as a testament to the power of relentless training.</p>
                        <div class="meta-text">
                            <span class="meta-category">Sports</span> | <span class="ms-2">May 13, 2024</span>
                        </div>
                    </div>
                </article>


            </div>

            <div class="col-lg-4">
                <div class="trending-card">
                    <h3 class="trending-header">Trending News</h3>

                    <div class="d-flex gap-3 mb-4 pb-2">
                        <div class="trending-number">1</div>
                        <div class="w-100">
                            <a href="#" class="trending-title d-block">Tech giants unveil plans for next generation AI
                                assistants</a>
                            <div class="meta-text d-flex justify-content-between mt-2">
                                <span>May 14, 2024</span>
                                <span>Marvin McKinney</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4 pb-2">
                        <div class="trending-number">2</div>
                        <div class="w-100">
                            <a href="#" class="trending-title d-block">Government faces backlash over proposed tax reform
                                legislation</a>
                            <div class="meta-text d-flex justify-content-between mt-2">
                                <span>May 14, 2024</span>
                                <span>Jane Cooper</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4 pb-2">
                        <div class="trending-number">3</div>
                        <div class="w-100">
                            <a href="#" class="trending-title d-block">Community health initiative launches campaign to combat
                                childhood obesity</a>
                            <div class="meta-text d-flex justify-content-between mt-2">
                                <span>May 14, 2024</span>
                                <span>Esther Howard</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4 pb-2">
                        <div class="trending-number">4</div>
                        <div class="w-100">
                            <a href="#" class="trending-title d-block">Candidates gear up for highly contested race</a>
                            <div class="meta-text d-flex justify-content-between mt-2">
                                <span>May 14, 2024</span>
                                <span>Wade Warren</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-2">
                        <div class="trending-number">5</div>
                        <div class="w-100">
                            <a href="#" class="trending-title d-block">Entertainment industry mourns loss of iconic actor</a>
                            <div class="meta-text d-flex justify-content-between mt-2">
                                <span>May 14, 2024</span>
                                <span>Wade Warren</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="ad-wrapper py-3">
                    <span class="ad-label">- Advertisement -</span>
                    <a href="#">
                        <img src="{{ asset('assets/images/WhatsApp-Image-2026-02-02-at-09.46.17.jpeg')}}" alt="Sidebar Ad" class="ad-one-third">
                    </a>
                </div>
                <div class="ad-wrapper py-3">
                    <span class="ad-label">- Advertisement -</span>
                    <a href="#">
                        <img src="{{ asset('assets/images/300x218.gif')}}" alt="Sidebar Ad" class="ad-one-third">
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <div class="ad-wrapper">
                    <span class="ad-label">- Advertisement -</span>
                    <a href="#">
                        <img src="{{ asset('assets/images/WhatsApp-GIF-2026-03-10-at-10.52.51.gif')}}" alt="Full Width Ad" class="ad-full-width">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">

        <div class="section-header-featured d-flex justify-content-between">
            <h2>Nepal Insights</h2>
            <a href="#" class="cat-link mt-auto">View All Nepal Insights <span>&rarr;</span></a>
        </div>

        <div class="row gy-5">

            <div class="col-md-6">
                <a href="#" class="featured-article">
                    <div class="featured-content">
                        <h3 class="featured-title">Global summit convenes world leaders to address climate emergency</h3>
                        <div class="featured-meta">
                            <span class="meta-category">World News</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/1.jpg')}}" alt="Capitol Building" class="featured-img">
                </a>
            </div>

            <div class="col-md-6">
                <a href="#" class="featured-article">
                    <div class="featured-content">
                        <h3 class="featured-title">5G rollout accelerates how connectivity next-gen will transform industries</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Technology</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/2.jpg')}}" alt="Business Meeting" class="featured-img">
                </a>
            </div>

            <div class="col-md-6">
                <a href="#" class="featured-article">
                    <div class="featured-content">
                        <h3 class="featured-title">Groundbreaking study reveals potential breakthrough in alzheimer's treatment
                        </h3>
                        <div class="featured-meta">
                            <span class="meta-category">World News</span>
                            <span class="meta-divider">|</span>
                            <span>May 11, 2024</span>
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/3.jpg')}}" alt="Counting coins" class="featured-img">
                </a>
            </div>

            <div class="col-md-6">
                <a href="#" class="featured-article">
                    <div class="featured-content">
                        <h3 class="featured-title">Virtual reality headsets take gaming to the next level</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Technology</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/4.jpg')}}" alt="Game Controller" class="featured-img">
                </a>
            </div>

            <div class="col-md-6">
                <a href="#" class="featured-article">
                    <div class="featured-content">
                        <h3 class="featured-title">Report breaking down the latest scientific discoveries</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Technology</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/5.jpg')}}" alt="Space Rocket" class="featured-img">
                </a>
            </div>

            <div class="col-md-6">
                <a href="#" class="featured-article">
                    <div class="featured-content">
                        <h3 class="featured-title">Local community rallies to support homeless</h3>
                        <div class="featured-meta">
                            <span class="meta-category">World News</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/1.jpg')}}" alt="Chamber seating" class="featured-img">
                </a>
            </div>

            <div class="col-md-6">
                <a href="#" class="featured-article">
                    <div class="featured-content">
                        <h3 class="featured-title">Unraveling the marvels of life sciences, genetics, evolution, and ecological
                        </h3>
                        <div class="featured-meta">
                            <span class="meta-category">Health</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/3.jpg')}}" alt="Scientist pouring liquid" class="featured-img">
                </a>
            </div>

            <div class="col-md-6">
                <a href="#" class="featured-article">
                    <div class="featured-content">
                        <h3 class="featured-title">Athlete achieves historic win at world championships</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Sports</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/4.jpg')}}" alt="American Football" class="featured-img">
                </a>
            </div>

        </div>
    </div>
    <hr style="border-color: #c7c7c7; margin: 0;">
    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <div class="ad-wrapper">
                    <span class="ad-label">- Advertisement -</span>
                    <a href="#">
                        <img
                            src="https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&h=250&q=80"
                            alt="Full Width Ad" class="ad-full-width">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <hr style="border-color: #c7c7c7; margin: 0;">

    <div class="container py-5">
        <div class="row gy-5">

            <div class="col-lg-4 col-md-6 col-spacing d-flex flex-column">
                <h2 class="section-title">Social/Cultural</h2>

                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/1.jpg')}}" alt="Leaders" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Global leaders unite to address climate crisis at COP26</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Sports</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>

                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/2.jpg')}}" alt="Doctor" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">New study reveals alarming rise in childhood</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Sports</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>

                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/3.jpg')}}" alt="Meeting" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Tech giants clash over data privacy regulations</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Sports</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>

                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/4.jpg')}}" alt="Chamber" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Local community rallies to support homeless</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Sports</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>

                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/5.jpg')}}" alt="Podium" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Democratic backsliding challenges to democracy and</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Sports</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>

                <a href="#" class="cat-link mt-auto">Go to Social/Cultural <span>&rarr;</span></a>
            </div>

            <div class="col-lg-4 col-md-6 col-spacing d-flex flex-column">
                <h2 class="section-title">Economics</h2>

                <a href="#" class="featured-item">
                    <img src="{{ asset('assets/images/4.jpg')}}" alt="Space Rocket" class="large-thumb">
                    <h3 class="news-title">Report breaking down the latest scientific discoveries</h3>
                    <div class="featured-meta">
                        <span class="meta-category">Economics</span>
                        <span class="meta-divider">|</span>
                        <span>May 13, 2024</span>
                    </div>
                </a>

                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/1.jpg')}}" alt="Padlock" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Cybersecurity experts warn of increased threats</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Economics</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>

                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/2.jpg')}}" alt="Satellite" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Updates on environmental science and space exploration</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Economics</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>

                <a href="#" class="cat-link mt-auto">Go to Economics <span>&rarr;</span></a>
            </div>

            <div class="col-lg-4 col-md-12 d-flex flex-column mt-5">
                <h2 class="section-title">Politics</h2>

                <div class="row">
                    <div class="col-md-6 col-lg-12">
                        <a href="#" class="news-item">
                            <img src="{{ asset('assets/images/5.jpg')}}" alt="Football" class="small-thumb">
                            <div class="news-content">
                                <h3 class="news-title">Athlete achieves historic win at world championships</h3>
                                <div class="featured-meta">
                                    <span class="meta-category">Politics</span>
                                    <span class="meta-divider">|</span>
                                    <span>May 13, 2024</span>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="news-item">
                            <img src="{{ asset('assets/images/1.jpg')}}" alt="Volleyball" class="small-thumb">
                            <div class="news-content">
                                <h3 class="news-title">Rival teams clash in intense playoff showdown</h3>
                                <div class="featured-meta">
                                    <span class="meta-category">Politics</span>
                                    <span class="meta-divider">|</span>
                                    <span>May 13, 2024</span>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="news-item">
                            <img src="{{ asset('assets/images/2.jpg')}}" alt="Martial Arts" class="small-thumb">
                            <div class="news-content">
                                <h3 class="news-title">Scandal rocks professional sports league</h3>
                                <div class="featured-meta">
                                    <span class="meta-category">Politics</span>
                                    <span class="meta-divider">|</span>
                                    <span>May 13, 2024</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-12">
                        <a href="#" class="news-item">
                            <img src="{{ asset('assets/images/3.jpg')}}" alt="Rugby" class="small-thumb">
                            <div class="news-content">
                                <h3 class="news-title">Trailblazers of sport athletes paving the way</h3>
                                <div class="featured-meta">
                                    <span class="meta-category">Politics</span>
                                    <span class="meta-divider">|</span>
                                    <span>May 13, 2024</span>
                                </div>
                            </div>
                        </a>

                        <a href="#" class="news-item">
                            <img src="{{ asset('assets/images/4.jpg')}}" alt="Skiing" class="small-thumb">
                            <div class="news-content">
                                <h3 class="news-title">Highlighting importance of well-being</h3>
                                <div class="featured-meta">
                                    <span class="meta-category">Politics</span>
                                    <span class="meta-divider">|</span>
                                    <span>May 13, 2024</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <a href="#" class="cat-link mt-auto">Go to Politics <span>&rarr;</span></a>
            </div>

        </div>
    </div>
    <hr style="border-color: #c7c7c7; margin: 0;">
    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <div class="ad-wrapper">
                    <span class="ad-label">- Advertisement -</span>
                    <a href="#">
                        <img src="{{ asset('assets/images/OnlinePortal_1230X100-ezgif.com-video-to-gif-converter.gif')}}" alt="Full Width Ad"
                            class="ad-full-width">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="section-header-featured d-flex justify-content-between">
            <h2>Brands</h2>
            <a href="#" class="cat-link mt-auto">View All Brands <span>&rarr;</span></a>
        </div>
        <div class="row g-4">

            <div class="col-lg-8 full-height-col">
                <div class="row g-4 h-100">

                    <div class="col-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0 h-100">
                                <div class="col-md-5">
                                    <img src="{{ asset('assets/images/1.jpg')}}" class="img-fluid h-100 object-fit-cover" alt="Storytelling">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body d-flex flex-column h-100 p-4">
                                        <p class="small-text mb-2">Dec 16, 2024</p>
                                        <h2 class=" h4 mb-3">The power of storytelling connecting generations through shared narratives
                                        </h2>
                                        <p class="small-text">By passing down experiences and wisdom, storytelling preserves traditions,
                                            fosters understanding & strengthens bonds.</p>
                                        <p class="author-text mb-0">by. <span class=" text-dark">Leslie Alexander</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card overflow-hidden">
                            <div class="row g-0 h-100">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/2.jpg')}}" class="img-fluid h-100 object-fit-cover" alt="Art">
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3">
                                        <p class="small-text mb-1">Dec 16, 2024</p>
                                        <h3 class=" mb-2" style="font-size: 0.9rem;">How art, music, and literature shape the identity of
                                            societies</h3>
                                        <p class="author-text mb-0">Theresa Webb</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card overflow-hidden">
                            <div class="row g-0 h-100">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/3.jpg')}}" class="img-fluid h-100 object-fit-cover" alt="Global Influence">
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3">
                                        <p class="small-text mb-1">Dec 14, 2024</p>
                                        <h3 class=" mb-2" style="font-size: 0.9rem;">How countries use art and culture for global
                                            influence
                                        </h3>
                                        <p class="author-text mb-0">Theresa Webb</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card overflow-hidden">
                            <div class="row g-0 h-100">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/4.jpg')}}" class="img-fluid h-100 object-fit-cover" alt="Art">
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3">
                                        <p class="small-text mb-1">Dec 16, 2024</p>
                                        <h3 class=" mb-2" style="font-size: 0.9rem;">How art, music, and literature shape the identity of
                                            societies</h3>
                                        <p class="author-text mb-0">Theresa Webb</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card overflow-hidden">
                            <div class="row g-0 h-100">
                                <div class="col-4">
                                    <img src="{{ asset('assets/images/5.jpg')}}" class="img-fluid h-100 object-fit-cover" alt="Global Influence">
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3">
                                        <p class="small-text mb-1">Dec 14, 2024</p>
                                        <h3 class=" mb-2" style="font-size: 0.9rem;">How countries use art and culture for global
                                            influence
                                        </h3>
                                        <p class="author-text mb-0">Theresa Webb</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="ad-wrapper py-3">
                    <span class="ad-label">- Advertisement -</span>
                    <a href="#">
                        <img src="{{ asset('assets/images/WhatsApp-Image-2026-02-02-at-09.46.17.jpeg')}}" alt="Sidebar Ad" class="ad-one-third">
                    </a>
                </div>
                <div class="ad-wrapper py-3">
                    <span class="ad-label">- Advertisement -</span>
                    <a href="#">
                        <img src="{{ asset('assets/images/300x218.gif')}}" alt="Sidebar Ad" class="ad-one-third">
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="container py-3">
        <div class="row">
            <div class="col-12">
                <div class="ad-wrapper">
                    <span class="ad-label">- Advertisement -</span>
                    <a href="#">
                        <img
                            src="https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&h=250&q=80"
                            alt="Full Width Ad" class="ad-full-width">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <hr style="border-color: #c7c7c7; margin: 0;">

    <div class="container py-5">

        <div class="section-header-featured d-flex justify-content-between">
            <h2>Notice</h2>
            <a href="#" class="cat-link mt-auto">View all Notice <span>&rarr;</span></a>
        </div>
        <div class="row gy-5 mt-4">

            <div class="col-lg-4 col-md-6 mt-0">

                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/1.jpg')}}" alt="Leaders" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Global leaders unite to address climate crisis at COP26</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Sports</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-0 ">
                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/2.jpg')}}" alt="Doctor" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">New study reveals alarming rise in childhood</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Health</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-0 ">
                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/3.jpg')}}" alt="Meeting" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Tech giants clash over data privacy regulations</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Technology</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-0 ">
                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/4.jpg')}}" alt="Chamber" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Local community rallies to support homeless</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Community</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-0 ">
                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/5.jpg')}}" alt="Podium" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Democratic backsliding challenges to democracy and</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Politics</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>

            </div>

            <div class="col-lg-4 col-md-6 mt-0 ">

                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/1.jpg')}}" alt="Leaders" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Global leaders unite to address climate crisis at COP26</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Sports</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-0 ">
                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/2.jpg')}}" alt="Doctor" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">New study reveals alarming rise in childhood</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Health</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-0 ">
                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/3.jpg')}}" alt="Meeting" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Tech giants clash over data privacy regulations</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Technology</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-0 ">
                <a href="#" class="news-item">
                    <img src="{{ asset('assets/images/4.jpg')}}" alt="Chamber" class="small-thumb">
                    <div class="news-content">
                        <h3 class="news-title">Local community rallies to support homeless</h3>
                        <div class="featured-meta">
                            <span class="meta-category">Community</span>
                            <span class="meta-divider">|</span>
                            <span>May 13, 2024</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>

@endsection