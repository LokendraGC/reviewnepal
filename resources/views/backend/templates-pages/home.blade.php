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
                    <li class="nav-item">
                        <a href="#info-section" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab', 'info-section') === 'info-section' ? 'active' : '' }}">
                            Latest News
                        </a>
                    </li>

                    <!-- Second Tab -->
                    <li class="nav-item">
                        <a href="#second-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'second-tab-news' ? 'active' : '' }}">
                            News/Feature
                        </a>
                    </li>

                    <!-- Third Tab -->
                    <li class="nav-item">
                        <a href="#third-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'third-tab-news' ? 'active' : '' }}">
                            View News
                        </a>
                    </li>

                    <!-- Fourth Tab -->
                    <li class="nav-item">
                        <a href="#fourth-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'fourth-tab-news' ? 'active' : '' }}">
                            Nepal Insights
                        </a>
                    </li>

                    <!-- Fifth Tab -->
                    <li class="nav-item">
                        <a href="#fifth-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'fifth-tab-news' ? 'active' : '' }}">
                            Below News Insights
                        </a>
                    </li>

                    <!-- Sixth Tab -->
                    <li class="nav-item">
                        <a href="#sixth-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'sixth-tab-news' ? 'active' : '' }}">
                            Brands
                        </a>
                    </li>

                    <!-- Seventh Tab -->
                    <li class="nav-item">
                        <a href="#seventh-tab-news" data-bs-toggle="tab"
                            class="nav-link {{ request()->query('tab') === 'seventh-tab-news' ? 'active' : '' }}">
                            Notices
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">

                <!-- INFO SECTION -->
                <div class="tab-pane fade {{ request()->query('tab', 'info-section') === 'info-section' ? 'show active' : '' }}"
                    id="info-section" role="tabpanel">

                    <div class="row mb-3">
                        {{-- <div class="col-md-12">
                            <label for="number_of_news_to_show_in_banner" class="form-label">
                                Number of News to Show in Banner
                            </label>

                            <input type="number" class="form-control" id="number_of_news_to_show_in_banner"
                                min="1" max="20" name="number_of_news_to_show_in_banner"
                                value="{{ $metaDatas['number_of_news_to_show_in_banner'] ?? '' }}" />
                        </div> --}}


                        {{-- repeater for latest news english --}}
                        <div class="mb-3">
                            <label class="form-label">Latest News for English</label>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="custom-table-sno" style="width:5%">S.No</th>
                                            <th style="width:30%">Choose News</th>
                                            <th style="width:10%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="addMoreLatestNews">
                                        @php
                                            $all_posts_en = PostHelper::getModel()
                                                ->where('post_status', 'publish')
                                                ->where('post_type', 'post')
                                                ->latest()
                                                ->limit(20)
                                                ->get();

                                        @endphp
                                        @isset($metaDatas['latest_news_details'])
                                            @php
                                                $latestNewsDetails = unserialize($metaDatas['latest_news_details']);
                                            @endphp

                                            @foreach ($latestNewsDetails as $index => $item)
                                                <tr>
                                                    <td class="custom-table-no">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <select class="form-control"
                                                            name="latest_news_details[{{ $index }}][post_id]"
                                                            id="latest_news_details_{{ $index }}_post_id">
                                                            <option value="">Choose News</option>
                                                            @foreach ($all_posts_en as $post)
                                                                <option value="{{ $post->id }}"
                                                                    {{ isset($item['post_id']) && $item['post_id'] == $post->id ? 'selected' : '' }}>
                                                                    {{ $post->post_title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0);"
                                                            class="text-success fs-16 px-1 add_more_latest_news">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="text-danger fs-16 px-1 remove_latest_news">
                                                            <i class="bi bi-x-circle"></i>
                                                        </a>
                                                        <hr>
                                                        <a href="javascript:void(0);"
                                                            class="text-primary fs-16 px-1 ln-move-up" title="Move Up">
                                                            <i class="bi bi-arrow-up-circle"></i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="text-primary fs-16 px-1 ln-move-down" title="Move Down">
                                                            <i class="bi bi-arrow-down-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                                <div class="text-end mt-2">
                                    <button type="button" class="btn btn-primary btn-sm add_latest_news">Add
                                        News</button>
                                </div>
                            </div>
                        </div>


                        {{-- repeater for latest news nepali --}}
                        <div class="mb-3">
                            <label class="form-label">Latest News for Nepali</label>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="custom-table-sno" style="width:5%">S.No</th>
                                            <th style="width:30%">Choose News</th>
                                            <th style="width:10%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="addMoreLatestNewsNepali">
                                        @php
                                            $all_posts_ne = PostHelper::getModel()
                                                ->where('post_status', 'publish')
                                                ->where('post_type', 'post_ne')
                                                ->latest()
                                                ->limit(20)
                                                ->get();

                                        @endphp
                                        @isset($metaDatas['latest_news_details_ne'])
                                            @php
                                                $latestNewsDetails = unserialize($metaDatas['latest_news_details_ne']);
                                            @endphp

                                            @foreach ($latestNewsDetails as $index => $item)
                                                <tr>
                                                    <td class="custom-table-no">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <select class="form-control"
                                                            name="latest_news_details_ne[{{ $index }}][post_id]"
                                                            id="latest_news_details_ne_{{ $index }}_post_id">
                                                            <option value="">Choose News</option>
                                                            @foreach ($all_posts_ne as $post)
                                                                <option value="{{ $post->id }}"
                                                                    {{ isset($item['post_id']) && $item['post_id'] == $post->id ? 'selected' : '' }}>
                                                                    {{ $post->post_title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0);"
                                                            class="text-success fs-16 px-1 add_more_latest_news_nepali">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="text-danger fs-16 px-1 remove_latest_news_nepali">
                                                            <i class="bi bi-x-circle"></i>
                                                        </a>
                                                        <hr>
                                                        <a href="javascript:void(0);"
                                                            class="text-primary fs-16 px-1 ln-move-up-nepali"
                                                            title="Move Up">
                                                            <i class="bi bi-arrow-up-circle"></i>
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="text-primary fs-16 px-1 ln-move-down-nepali"
                                                            title="Move Down">
                                                            <i class="bi bi-arrow-down-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                                <div class="text-end mt-2">
                                    <button type="button" class="btn btn-primary btn-sm add_latest_news_nepali">Add
                                        News</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- END INFO -->

                <!-- SECOND TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'second-tab-news' ? 'show active' : '' }}"
                    id="second-tab-news" role="tabpanel">

                    <div class="row mb-3">

                        <!-- LEFT CATEGORY -->
                        <div class="col-md-6">
                            <label class="form-label">Choose News Category (Left Side)</label>

                            <select name="category_id_left_second" class="form-control">
                                <option value="">Select Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['category_id_left_second']) && $metaDatas['category_id_left_second'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- RIGHT CATEGORY -->
                        <div class="col-md-6">
                            <label class="form-label">Choose News Category (Right Side)</label>

                            <select name="category_id_right_second" class="form-control">
                                <option value="">Select Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['category_id_right_second']) && $metaDatas['category_id_right_second'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                </div>
                <!-- END SECOND TAB -->

                <!-- THIRD TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'third-tab-news' ? 'show active' : '' }}"
                    id="third-tab-news" role="tabpanel">



                    <div class="row mb-3">
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
                    </div>


                    <div class="row mb-3">

                        <!-- LEFT CATEGORY -->
                        <div class="col-md-12">



                            <label class="form-label">Choose News Category</label>

                            <select name="category_id_third" class="form-control">
                                <option value="">Select Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['category_id_third']) && $metaDatas['category_id_third'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                    </div>
                </div>
                <!-- END THIRD TAB NEWS -->

                <!-- FOURTH TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'fourth-tab-news' ? 'show active' : '' }}"
                    id="fourth-tab-news" role="tabpanel">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Main Title</label>

                            <input type="text" name="main_title_fourth" class="form-control"
                                value="{{ $metaDatas['main_title_fourth'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Main Title in Nepali</label>

                            <input type="text" name="main_title_nepali_fourth" class="form-control"
                                value="{{ $metaDatas['main_title_nepali_fourth'] ?? '' }}">
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-12">

                            <label class="form-label">Choose News Category</label>
                            <select name="category_id_fourth" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['category_id_fourth']) && $metaDatas['category_id_fourth'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>
                <!-- END FOURTH TAB NEWS -->

                <!-- FIFTH TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'fifth-tab-news' ? 'show active' : '' }}"
                    id="fifth-tab-news" role="tabpanel">
                    <div class="row mb-3">

                        <!-- LEFT CATEGORY -->
                        <div class="col-md-4">
                            <label class="form-label">Choose News Category (Left Side)</label>

                            <select name="category_id_left_fifth" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['category_id_left_fifth']) && $metaDatas['category_id_left_fifth'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Middle Category -->
                        <div class="col-md-4">
                            <label class="form-label">Choose News Category (Middle Side)</label>

                            <select name="category_id_middle_fifth" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['category_id_middle_fifth']) && $metaDatas['category_id_middle_fifth'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Right Category -->
                        <div class="col-md-4">
                            <label class="form-label">Choose News Category (Right Side)</label>

                            <select name="category_id_right_fifth" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['category_id_right_fifth']) && $metaDatas['category_id_right_fifth'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>
                <!-- END FIFTH TAB NEWS -->

                <!-- SIXTH TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'sixth-tab-news' ? 'show active' : '' }}"
                    id="sixth-tab-news" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Choose News Category</label>

                            <select name="category_id_sixth" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($metaDatas['category_id_sixth']) && $metaDatas['category_id_sixth'] == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>
                <!-- END SIXTH TAB NEWS -->


                <!-- SEVENTH TAB NEWS -->
                <div class="tab-pane fade {{ request()->query('tab') === 'seventh-tab-news' ? 'show active' : '' }}"
                    id="seventh-tab-news" role="tabpanel">
                    <div class="row mb-3">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Choose News Category</label>

                                <select name="category_id_seventh" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ isset($metaDatas['category_id_seventh']) && $metaDatas['category_id_seventh'] == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
            <!-- END TAB CONTENT -->

        </div>
    </div>
</div>


@include('backend.templates-pages.home.latest-news-repeater')
@include('backend.templates-pages.home.latest-news-nepali-repeater')
