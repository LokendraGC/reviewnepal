<div class="tab-pane fade {{ request()->query('tab') == 'trending' ? 'active show' : '' }}" id="trending"
    role="tabpanel" aria-labelledby="trending-tab">

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="trending_news_time" class="form-label">Trending News Time</label>
                <input type="number" class="form-control" id="trending_news_time" name="trending_news_time"
                    value="{{ $settings['trending_news_time'] ?? 7 }}" />
            </div>
        </div>
    </div>
</div>