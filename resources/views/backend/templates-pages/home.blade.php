<div class="mb-3">
    <div class="card">
        <div class="card-body">

            <div class="mb-2 d-flex align-content-center border-1 border-bottom">
                <h4 class="header-title">Home Page Builder</h4>
            </div>

            <!-- Tabs -->
            <div class="tab-heading">
                <ul class="nav nav-tabs mb-3">

                    <!-- Info Tab -->
                    <!--<li class="nav-item">-->
                    <!--    <a href="#info-section" data-bs-toggle="tab"-->
                    <!--        class="nav-link {{ request()->query('tab', 'info-section') === 'info-section' ? 'active' : '' }}">-->
                    <!--        Latest News-->
                    <!--    </a>-->
                    <!--</li>-->

                    <!-- Second Tab -->
                       <li class="nav-item">
                        <a href="#info-section" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab', 'info-section') === 'info-section' ? 'active' : '' }}">
                            News/Feature
                        </a>
                    </li>
                    
                    <!--<li class="nav-item">-->
                    <!--    <a href="#second-tab-news" data-bs-toggle="tab"-->
                    <!--        class="nav-link {{ request()->query('tab') === 'second-tab-news' ? 'active' : '' }}">-->
                    <!--        News/Feature-->
                    <!--    </a>-->
                    <!--</li>-->

                    <!-- Sports Tab -->
                    <li class="nav-item">
                        <a href="#fourth-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'fourth-tab-news' ? 'active' : '' }}">
                            Sports
                        </a>
                    </li>

                    <!--  VIEWS/OPINION Tab -->
                    <li class="nav-item">
                        <a href="#third-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'third-tab-news' ? 'active' : '' }}">
                            Views/Opinion
                        </a>
                    </li>

                    <!-- LIFESTYLE, ART and SCIENCE Tab -->
                    <li class="nav-item">
                        <a href="#fifth-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'fifth-tab-news' ? 'active' : '' }}">
                            Lifestyle, Art and Science
                        </a>
                    </li>

                    <!-- BIZ/BRANDS Tab -->
                    <li class="nav-item">
                        <a href="#sixth-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'sixth-tab-news' ? 'active' : '' }}">
                            Business/Brands
                        </a>
                    </li>


                     <!-- TENDER AND NOTICES Tab -->
                    <li class="nav-item">
                        <a href="#tender-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'tender-tab-news' ? 'active' : '' }}">
                            Tenders and Notices
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">

                <!-- INFO SECTION -->
                <!--<div class="tab-pane fade {{ request()->query('tab', 'info-section') === 'info-section' ? 'show active' : '' }}"-->
                <!--    id="info-section" role="tabpanel">-->

                <!--    <div class="row mb-3">-->
                <!--        {{-- <div class="col-md-12">-->
                <!--            <label for="number_of_news_to_show_in_banner" class="form-label">-->
                <!--                Number of News to Show in Banner-->
                <!--            </label>-->

                <!--            <input type="number" class="form-control" id="number_of_news_to_show_in_banner"-->
                <!--                min="1" max="20" name="number_of_news_to_show_in_banner"-->
                <!--                value="{{ $metaDatas['number_of_news_to_show_in_banner'] ?? '' }}" />-->
                <!--        </div> --}}-->


                <!--    </div>-->

                <!--</div>-->
                <!-- END INFO -->


                <!-- NEWS AND FEATURES NEWS -->
                <div class="tab-pane fade {{ request()->query('tab', 'info-section') === 'info-section' ? 'show active' : '' }}"
                    id="info-section" role="tabpanel">

                    <div class="row mb-3">

                        <!-- LEFT CATEGORY -->
                        <div class="col-md-12">
                            <label class="form-label">Choose News Category (Left Side)</label>

                            <select name="news_n_feature_cat" class="form-control">
                                <option value="">Select Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['news_n_feature_cat']) && $metaDatas['news_n_feature_cat'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                </div>
                <!-- END NEWS AND FEATURES -->


                <!-- SPORTS TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'fourth-tab-news' ? 'show active' : '' }}"
                    id="fourth-tab-news" role="tabpanel">

                    <div class="row mb-3">

                        <div class="col-md-12">

                            <label class="form-label">Choose News Category</label>
                            <select name="sports_cat" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['sports_cat']) && $metaDatas['sports_cat'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>
                <!-- END SPORTS TAB NEWS -->



                <!-- VIEWS/OPINION TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'third-tab-news' ? 'show active' : '' }}"
                    id="third-tab-news" role="tabpanel">



                    {{-- <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Main Title</label>

                            <input type="text" name="main_title_third" class="form-control"
                                value="{{ $metaDatas['main_title_third'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Main Title in Nepali</label>

                            <input type="text" name="main_title_nepali_third" class="form-control"
                                value="{{ $metaDatas['main_title_nepali_third'] ?? '' }}">
                        </div>
                    </div> --}}


                    <div class="row mb-3">

                        <!-- LEFT CATEGORY -->
                        <div class="col-md-12">



                            <label class="form-label">Choose News Category</label>

                            <select name="views_n_opinion_cat" class="form-control">
                                <option value="">Select Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['views_n_opinion_cat']) && $metaDatas['views_n_opinion_cat'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                    </div>
                </div>
                <!-- END VIEWS/OPINION TAB NEWS -->



                <!-- FIFTH TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'fifth-tab-news' ? 'show active' : '' }}"
                    id="fifth-tab-news" role="tabpanel">
                    <div class="row mb-3">

                        <!-- LIFESTYLE/ENT CATEGORY -->
                        <div class="col-md-4">
                            <label class="form-label">Choose News Category (Left Side)</label>

                            <select name="lifestyle_ent_cat" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['lifestyle_ent_cat']) && $metaDatas['lifestyle_ent_cat'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- ART/CULT./LIT. Category -->
                        <div class="col-md-4">
                            <label class="form-label">Choose News Category (Middle Side)</label>

                            <select name="art_cult_lit_cat" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['art_cult_lit_cat']) && $metaDatas['art_cult_lit_cat'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Sci./Tech. Category -->
                        <div class="col-md-4">
                            <label class="form-label">Choose News Category (Right Side)</label>

                            <select name="sci_tech_cat" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['sci_tech_cat']) && $metaDatas['sci_tech_cat'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>
                <!-- END FIFTH TAB NEWS -->

                <!-- BUSINESS/BRANDS TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'sixth-tab-news' ? 'show active' : '' }}"
                    id="sixth-tab-news" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Choose News Category</label>

                            <select name="business_brands_cat" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['business_brands_cat']) && $metaDatas['business_brands_cat'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>
                <!-- BUSINESS/BRANDS TAB NEWS -->

            <!-- TENDER AND NOTICES TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'tender-tab-news' ? 'show active' : '' }}"
                    id="tender-tab-news" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Choose News Category</label>

                            <select name="tender_notices_cat" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['tender_notices_cat']) && $metaDatas['tender_notices_cat'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>
                <!-- TENDER AND NOTICES TAB NEWS -->


            </div>
            <!-- END TAB CONTENT -->

        </div>
    </div>
</div>


@include('backend.templates-pages.home.latest-news-repeater')
@include('backend.templates-pages.home.latest-news-nepali-repeater')
