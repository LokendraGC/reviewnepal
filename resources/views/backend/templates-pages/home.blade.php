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
                            Second Section News
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
                        <div class="col-md-12">
                            <label for="number_of_news_to_show_in_banner" class="form-label">
                                Number of News to Show in Banner
                            </label>

                            <input type="number" class="form-control" id="number_of_news_to_show_in_banner"
                                min="1" max="20" name="number_of_news_to_show_in_banner"
                                value="{{ $metaDatas['number_of_news_to_show_in_banner'] ?? '' }}" />
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
