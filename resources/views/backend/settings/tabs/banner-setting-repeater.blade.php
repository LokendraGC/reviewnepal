<div class="tab-pane fade {{ !request()->has('tab') || request()->query('tab') == 'banner' ? 'active show' : '' }}"
    id="banner" role="tabpanel" aria-labelledby="banner-tab">
    <div class="mb-1">
        <div class="row">
            <div class="col-md-12">

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

                                    $latestNewsDetails = [];
                                    if (!empty($settings['latest_news_details'])) {
                                        $latestNewsDetails = @unserialize($settings['latest_news_details']);
                                        if (!is_array($latestNewsDetails)) {
                                            $latestNewsDetails = [];
                                        }
                                    }


                                @endphp
                                @forelse ($latestNewsDetails as $index => $item)
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
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 ln-move-up"
                                                title="Move Up">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 ln-move-down"
                                                title="Move Down">
                                                <i class="bi bi-arrow-down-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="custom-table-no">1</td>
                                        <td>
                                            <select class="form-control"
                                                name="latest_news_details[0][post_id]"
                                                id="latest_news_details_0_post_id">
                                                <option value="">Choose News</option>
                                                @foreach ($all_posts_en as $post)
                                                    <option value="{{ $post->id }}">{{ $post->post_title }}</option>
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
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 ln-move-up"
                                                title="Move Up">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="text-primary fs-16 px-1 ln-move-down"
                                                title="Move Down">
                                                <i class="bi bi-arrow-down-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
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
                                    $latestNewsDetails = [];
                                    if (!empty($settings['latest_news_details_ne'])) {
                                        $latestNewsDetails = @unserialize($settings['latest_news_details_ne']);
                                        if (!is_array($latestNewsDetails)) {
                                            $latestNewsDetails = [];
                                        }
                                    }
                                @endphp
                                @forelse ($latestNewsDetails as $index => $item)
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
                                                class="text-primary fs-16 px-1 ln-move-up-nepali" title="Move Up">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="text-primary fs-16 px-1 ln-move-down-nepali" title="Move Down">
                                                <i class="bi bi-arrow-down-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="custom-table-no">1</td>
                                        <td>
                                            <select class="form-control"
                                                name="latest_news_details_ne[0][post_id]"
                                                id="latest_news_details_ne_0_post_id">
                                                <option value="">Choose News</option>
                                                @foreach ($all_posts_ne as $post)
                                                    <option value="{{ $post->id }}">{{ $post->post_title }}</option>
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
                                                class="text-primary fs-16 px-1 ln-move-up-nepali" title="Move Up">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                class="text-primary fs-16 px-1 ln-move-down-nepali" title="Move Down">
                                                <i class="bi bi-arrow-down-circle"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
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
    </div>
</div>
