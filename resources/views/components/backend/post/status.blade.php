<div class="card">
    @php
        $siteURL = SettingHelper::get_field('site_url');
    @endphp
    <div class="card-body">
        <div class="publish_status">
            @if ($post)
                <div>
                    <span class="form-text text-muted">
                        <small>Status: <u>{{ $post->post_status == 'publish' ? 'Publish' : 'Draft' }}</u></small>
                    </span>
                </div>
            @endif
            <div class="text-start mt-2">
                <div class="d-flex justify-content-between flex-wrap">
                    @php
                        $status = $post ? $post->post_status : null;
                        $draftBtnClass = $status == 'draft' ? 'primary' : 'outline-primary';
                        $publishBtnClass = $status == 'publish' ? 'primary' : 'outline-primary';
                        $pendingBtnClass = $status == 'pending' ? 'primary' : 'outline-primary';
                    @endphp
                    <p>
                        <button class="btn btn-sm btn-{{ $draftBtnClass }}" type="submit" name="action" value="draft">
                            Save as draft
                        </button>
                    </p>
                    @if ($status == 'pending')
                        <p>
                            <button class="btn btn-sm btn-{{ $pendingBtnClass }}" type="submit" name="action"
                                value="pending">
                                Pending
                            </button>
                        </p>
                    @endif
                    <p>
                        <button class="btn btn-sm btn-{{ $publishBtnClass }}" type="submit" name="action"
                            value="publish">
                            @if ($post && $post->post_status == 'draft')
                                Publish
                            @else
                                {{ $button ?? 'Publish' }}
                            @endif
                        </button>
                    </p>
                </div>
                @if ($post)
                    <div>
                        <label for="" class="form-label">Publish Date</label>
                        <input type="text" class="form-control datetime-datepicker" placeholder="Date and Time"
                            value="{{ \Carbon\Carbon::parse($post->created_at)->format('Y-m-d H:i a') }}"
                            name="created_at">
                        @if (auth()->user()->can('read_post_updated_date') && $post->lastUpdatedBy)
                            <hr>
                            <div class="mt-2">
                                <span class="form-text text-muted">
                                    <small>Last Updated By: <a
                                            href="{{ route('backend.user.profile', $post->lastUpdatedBy->id) }}">{{ $post->lastUpdatedBy->email }}</a></small>
                                    <br>
                                    <small>Updated On:
                                        <b>{{ \Carbon\Carbon::parse($post->updated_at)->format('Y-m-d H:i a') }}</b>
                                    </small>
                                </span>
                            </div>
                        @endif
                    </div>
                @endif

                @if ($status == 'publish' && $siteURL && $route)
                    <div class="d-grid mt-2">
                        <a target="_blank" href="{{ $siteURL . $route . $post->slug }}"
                            class="btn btn-sm btn-dark">View</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
    <input type="hidden" name="post_status" />
</div>
