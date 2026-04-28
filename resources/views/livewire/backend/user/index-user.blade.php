<div>
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
                placeholder="Search by Name or Email">
        </div>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped dt-responsive nowrap w-100">
            <thead class="">
                <tr>
                    <th class="text-nowrap">S.No</th>
                    <th class="text-nowrap">Name</th>
                    <th class="text-nowrap">Email Address</th>
                    @if ($status === 'all' || empty($status))
                        <th class="text-nowrap">Role</th>
                    @endif
                    {{-- @if ($status == 'User')
                        <th class="text-nowrap text-center">Suspended</th>
                        <th class="text-nowrap">Balance</th>
                        <th class="text-nowrap">Verified At</th>
                        <th class="text-nowrap">IP</th>
                    @endif --}}
                    <th class="text-nowrap">Registration Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr wire:key="{{ $user->id }}">
                        <td class="text-center" style="width: 75px;">
                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                        <td class="text-nowrap">
                            <span class="fw-600">{{ $user->name }}</span>
                            <br />
                            <div class="row-action fw-700">
                                <span class="edit">
                                    <a href="{{ route('backend.user.profile', $user->id) }}"
                                        class="text-primary">Edit</a>
                                </span>
                                @if ($user->id != auth()->user()->id)
                                    <span class="delete">
                                        |
                                        <a href="{{ route('backend.user.delete.view', $user->id) }}"
                                            class="text-danger">Delete</a>
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        </td>
                        @if ($status === 'all' || empty($status))
                            <td class="text-nowrap fw-bold">
                                @if ($user->getRoleNames())
                                    @foreach ($user->getRoleNames() as $roleName)
                                        {{ $roleName }}
                                    @endforeach
                                @endif
                            </td>
                        @endif
                        {{-- @if ($status == 'User')
                            <td class="text-nowrap text-center">
                                @if ($user->id != auth()->user()->id && $user->id != 1)
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check form-switch m-0">
                                            <input type="checkbox" class="form-check-input" style="cursor: pointer;"
                                                wire:click="toggleSuspended({{ $user->id }})"
                                                @if ($user->suspended_at) checked @endif>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        @endif --}}
                        {{-- @if ($status == 'User')
                            <td class="text-nowrap fw-bold">Rs. {{ number_format($user->balance, 2) }}</td>
                            <td class="text-nowrap">
                                {{ $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at)->format('Y-m-d h:i a') : 'Not Verified' }}
                            </td>
                            <td class="text-nowrap">{{ $user->ip_address ?? 'N/A' }}</td>
                        @endif --}}
                        <td class="text-nowrap" style="width: 80px;">
                            {{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d h:i a') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="10">Not Found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $users->links(data: ['scrollTo' => false]) }}
    </div>
</div>
