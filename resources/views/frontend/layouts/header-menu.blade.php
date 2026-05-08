@inject('frontMenuRepository', 'App\Repositories\FrontMenuRepository')
@php
    $segment = request()->segment(1);
    $language = LanguageHelper::getUserLanguage();
@endphp


@if ($menu)
    @php
        $allMenuItems = $menu->posts;

        $allMenuItems = $parentMenuItems = $allMenuItems
            ->filter(function ($item) {
                return $item->postMeta->contains(function ($meta) {
                    return $meta->meta_key === 'menu_item_parent_id' && $meta->meta_value === '0';
                });
            })
            ->sortBy('menu_order');
    @endphp



    <ul class="nav-list">
        @if ($allMenuItems)
            @foreach ($allMenuItems as $depth_0)
                @php
                    $menuItemMeta = $depth_0->GetAllMetaData();
                @endphp
                @if ($menuItemMeta['menu_item_object'] != 'custom')
                    @php
                        $menuItem = $frontMenuRepository->checkTypeOfMenuItem(
                            $menuItemMeta['menu_item_object'],
                            $depth_0,
                            $menuItemMeta,
                        );
                    @endphp

                    @if ($menuItem)
                        @php
                            $hasChildren = $frontMenuRepository->menuItemHasChildren($depth_0);
                            $menuTitleNe = trim((string) ($menuItemMeta['menu_item_title_ne'] ?? ''));
                            $menuDisplayTitle =
                                $language === 'ne' && $menuTitleNe !== '' ? $menuTitleNe : $menuItem['title'];
                        @endphp

                        <li class="{{ $hasChildren ? '' : '' }} nav-item-dropdown">
                            <a href="{{ $menuItem['link'] }}" class="{{ $menuItem['css'] }}"
                                target="{{ $menuItem['target'] }}">
                                {{ $menuDisplayTitle }}
                                @if ($hasChildren)
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                @endif
                            </a>

                            @if ($hasChildren)
                                <div class="dropdown-toggler"><i class="bi bi-caret-down-fill"></i></div>

                                <ul class="nav-dropdown-menu">
                                    @foreach ($hasChildren as $depth_1)
                                        @php
                                            $menuItemMeta = $depth_1->GetAllMetaData();
                                            $menuItem = $frontMenuRepository->checkTypeOfMenuItem(
                                                $menuItemMeta['menu_item_object'],
                                                $depth_1,
                                                $menuItemMeta,
                                            );
                                            $hasChildren_1 = $menuItem
                                                ? $frontMenuRepository->menuItemHasChildren($depth_1)
                                                : false;
                                        @endphp

                                        @if ($menuItem)
                                            <li class="{{ $hasChildren_1 ? '' : '' }}">
                                                <a href="{{ $menuItem['link'] }}" class="{{ $menuItem['css'] }}"
                                                    target="{{ $menuItem['target'] }}">
                                                    {{ $language === 'ne' && !empty(trim((string) ($menuItemMeta['menu_item_title_ne'] ?? ''))) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
                                                    @if ($hasChildren_1)
                                                        <svg width="10" height="10" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    @endif
                                                </a>

                                                @if ($hasChildren_1)
                                                    <div class="dropdown-toggler"><i class="bi bi-caret-down-fill"></i>
                                                    </div>

                                                    <ul class="nav-dropdown-menu">
                                                        @foreach ($hasChildren_1 as $depth_2)
                                                            @php
                                                                $menuItemMeta = $depth_2->GetAllMetaData();
                                                                $menuItem = $frontMenuRepository->checkTypeOfMenuItem(
                                                                    $menuItemMeta['menu_item_object'],
                                                                    $depth_2,
                                                                    $menuItemMeta,
                                                                );
                                                                $hasChildren_2 = $menuItem
                                                                    ? $frontMenuRepository->menuItemHasChildren(
                                                                        $depth_2,
                                                                    )
                                                                    : false;
                                                            @endphp

                                                            @if ($menuItem)
                                                                <li class="{{ $hasChildren_2 ? '' : '' }}">
                                                                    <a href="{{ $menuItem['link'] }}"
                                                                        class="{{ $menuItem['css'] }}"
                                                                        target="{{ $menuItem['target'] }}">
                                                                        {{ $language === 'ne' && !empty(trim((string) ($menuItemMeta['menu_item_title_ne'] ?? ''))) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
                                                                        @if ($hasChildren_2)
                                                                            <svg width="10" height="10"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <polyline points="6 9 12 15 18 9">
                                                                                </polyline>
                                                                            </svg>
                                                                        @endif
                                                                    </a>

                                                                    @if ($hasChildren_2)
                                                                        <div class="dropdown-toggler"><i
                                                                                class="bi bi-caret-down-fill"></i>
                                                                        </div>

                                                                        <ul class="nav-dropdown-menu">
                                                                            @foreach ($hasChildren_2 as $depth_3)
                                                                                @php
                                                                                    $menuItemMeta = $depth_3->GetAllMetaData();
                                                                                    $menuItem = $frontMenuRepository->checkTypeOfMenuItem(
                                                                                        $menuItemMeta[
                                                                                            'menu_item_object'
                                                                                        ],
                                                                                        $depth_3,
                                                                                        $menuItemMeta,
                                                                                    );
                                                                                @endphp

                                                                                @if ($menuItem)
                                                                                    <li>
                                                                                        <a href="{{ $menuItem['link'] }}"
                                                                                            class="{{ $menuItem['css'] }}"
                                                                                            target="{{ $menuItem['target'] }}">
                                                                                            {{ $language === 'ne' && !empty(trim((string) ($menuItemMeta['menu_item_title_ne'] ?? ''))) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
                                                                                        </a>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @else
                    {{-- custom --}}
                    @php
                        $menuItem = $frontMenuRepository->checkTypeOfMenuItem(
                            $menuItemMeta['menu_item_object'],
                            $depth_0,
                            $menuItemMeta,
                        );
                    @endphp
                    @if ($menuItem)
                        @php
                            $hasChildren_0 = $frontMenuRepository->menuItemHasChildren($depth_0);
                        @endphp
                        <li class="{{ $hasChildren_0 ? '' : '' }} nav-item-dropdown">
                            <a href="{{ $menuItem['link'] }}" class="{{ $menuItem['css'] }}"
                                target="{{ $menuItem['target'] }}">{{ $language === 'ne' && !empty($menuItemMeta['menu_item_title_ne']) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
                                @if ($hasChildren_0)
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                @endif
                            </a>

                            @if ($hasChildren_0)
                                <div class="dropdown-toggler"><i class="bi bi-caret-down-fill"></i></div>
                            @endif

                            @if ($hasChildren_0)
                                <ul class="nav-dropdown-menu">
                                    @foreach ($hasChildren_0 as $depth_1)
                                        @php
                                            $menuItemMeta = $depth_1->GetAllMetaData();
                                            $menuItem = $frontMenuRepository->checkTypeOfMenuItem(
                                                $menuItemMeta['menu_item_object'],
                                                $depth_1,
                                                $menuItemMeta,
                                            );
                                        @endphp

                                        @if ($menuItem)
                                            @php
                                                $hasChildren_1 = $frontMenuRepository->menuItemHasChildren($depth_1);

                                            @endphp

                                            <li class="{{ $hasChildren_1 ? '' : '' }} nav-item-dropdown">
                                                <a href="{{ $menuItem['link'] }}" class="{{ $menuItem['css'] }}"
                                                    target="{{ $menuItem['target'] }}">{{ $language === 'ne' && !empty($menuItemMeta['menu_item_title_ne']) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
                                                    @if ($hasChildren_1)
                                                        <svg width="10" height="10" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    @endif
                                                </a>

                                                @if ($hasChildren_1)
                                                    <div class="dropdown-toggler"><i class="bi bi-caret-down-fill"></i>
                                                    </div>
                                                @endif


                                                @if ($hasChildren_1)
                                                    <ul class="nav-dropdown-menu">
                                                        @foreach ($hasChildren_1 as $depth_2)
                                                            @php
                                                                $menuItemMeta = $depth_2->GetAllMetaData();
                                                                $menuItem = $frontMenuRepository->checkTypeOfMenuItem(
                                                                    $menuItemMeta['menu_item_object'],
                                                                    $depth_2,
                                                                    $menuItemMeta,
                                                                );
                                                            @endphp
                                                            @if ($menuItem)
                                                                <li>
                                                                    <a href="{{ $menuItem['link'] }}"
                                                                        class="{{ $menuItem['css'] }}"
                                                                        target="{{ $menuItem['target'] }}">{{ $language === 'ne' && !empty($menuItemMeta['menu_item_title_ne']) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endif
            @endforeach
        @endif
    </ul>

@endif
