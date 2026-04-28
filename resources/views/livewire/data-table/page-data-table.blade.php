<div>
    @php
        $siteURL = SettingHelper::get_field('site_url');
        $homeId = SettingHelper::get_home_id();
    @endphp
    <div class="d-sm-flex justify-content-between align-items-center flex-warp">
        <div class="row-action mb-2 mb-sm-0 fs-6">
            <span class="all">
                <a href="{{ route('backend.page') }}">
                    <span class="@if ($status == 'all') text-black fw-700 @endif">
                        All
                    </span>
                    ({{ $all }})</a>
            </span>
            @if ($publishPosts > 0)
                <span class="publish">
                    |
                    <a href="{{ route('backend.page', ['status' => 'publish']) }}" class="">
                        <span class="@if ($status == 'publish') text-black fw-700 @endif">
                            Publish
                        </span> ({{ $publishPosts }})</a>
                </span>
            @endif
            @if ($draftPosts > 0)
                <span class="draft">
                    |
                    <a href="{{ route('backend.page', ['status' => 'draft']) }}" class="">
                        <span class="@if ($status == 'draft') text-black fw-700 @endif">Draft</span>
                        ({{ $draftPosts }})</a>
                </span>
            @endif

            @if ($trashPosts > 0)
                <span class="delete">
                    |
                    <a href="{{ route('backend.page', ['status' => 'trash']) }}" class="">
                        <span class="@if ($status == 'trash') text-black fw-700 @endif">Trashed</span>
                        ({{ $trashPosts }})</a>
                </span>
            @endif
        </div>
    </div>
    <div class="table-attrs my-2 d-flex justify-content-between flex-wrap gap-2">
        <div>
            <select class="form-select form-select-md" wire:model.live="perPage">
                <option value="15">15</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
            </select>
        </div>
        <div class="flex-grow-1">
            <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                placeholder="Search by Title or Slug">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped dt-responsive nowrap w-100 border">
            <thead class="">
                <tr>
                    <th class="text-nowrap">Title</th>
                    <th class="text-nowrap">Slug</th>
                    <th class="text-nowrap">User</th>
                    <th class="text-nowrap">CreatedAt</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $p)
                    <tr wire:key="page-{{ $p->id }}">
                        <td class="text-nowrap">
                            @php
                                $indent = $p->depth ? str_repeat('&mdash;&nbsp;', $p->depth) : '';
                            @endphp
                            <span class="fw-600">{!! $indent !!}{{ $p->post_title }}</span>
                            {{ $p->post_status != 'publish' ? ' — Draft' : '' }}
                            <br />
                            <div class="row-action fw-700">
                                @if ($status != 'trash')
                                    <span class="edit">
                                        <a href="{{ route('backend.page.edit', $p->id) }}"
                                            class="text-primary">Edit</a>
                                    </span>
                                    @if ($homeId != $p->id)
                                        <span class="delete">
                                            |
                                            <a wire:click="delete({{ $p->id }})"
                                                wire:confirm="Are you sure you want to delete this page?"
                                                href="javascript:void(0);" class="text-danger">Delete</a>
                                        </span>
                                    @endif
                                    @if ($p->post_status == 'publish' && $siteURL)
                                        <span class="view">
                                            |
                                            <a href="{{ $siteURL . '/' . $p->slug }}" target="_blank"
                                                class="text-primary">View</a>
                                        </span>
                                    @endif
                                @else
                                    <span class="restore">
                                        <a href="javascript:void(0);"
                                            wire:confirm="Are you sure you want to restore this page?"
                                            wire:click="restore({{ $p->id }})" class="text-primary">Restore</a>
                                    </span>
                                    @if ($homeId != $p->id)
                                        <span class="delete">
                                            |
                                            <a wire:confirm.prompt="Are you sure you want to permanently delete?\n\nType DELETE to confirm|DELETE"
                                                wire:click="permanentDelete({{ $p->id }})"
                                                href="javascript:void(0);" class="text-danger">Permanently Delete</a>
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td class="text-nowrap">{{ $p->slug }}</td>
                        <td class="text-nowrap">
                            <a target="_blank"
                                href="{{ route('backend.user.profile', $p->user->id) }}">{{ $p->user->name }}</a>
                            <p class="form-text text-muted my-0" style="font-size: 0.7rem;">
                                {{ $p->user->email }}</p>
                        </td>
                        <td class="text-nowrap">
                            Published
                            <br>
                            {{ \Carbon\Carbon::parse($p->created_at)->format('Y-m-d h:i a') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4">Not Found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $posts->links(data: ['scrollTo' => false]) }}
    </div>
</div>
