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



    <ul class="overlay-nav-column">
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
                            @endphp

                            <li class="{{ $hasChildren ? 'mobile-dropdown' : '' }}">
                                <a href="{{ $menuItem['link'] }}"
                                    class="{{ $menuItem['css'] }} {{ $hasChildren ? 'mobile-dropdown-toggle' : '' }}"
                                    target="{{ $menuItem['target'] }}">
                                    {{ $language === 'ne' && ! empty($menuItemMeta['menu_item_title_ne']) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
                                    @if ($hasChildren)
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    @endif
                                </a>

                                @if ($hasChildren)
                                    <ul class="mobile-dropdown-menu">
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
                                                <li class="{{ $hasChildren_1 ? 'mobile-dropdown' : '' }}">
                                                    <a href="{{ $menuItem['link'] }}"
                                                        class="{{ $menuItem['css'] }} {{ $hasChildren_1 ? 'mobile-dropdown-toggle' : '' }}"
                                                        target="{{ $menuItem['target'] }}">
                                                        {{ $language === 'ne' && ! empty($menuItemMeta['menu_item_title_ne']) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
                                                        @if ($hasChildren_1)
                                                            <svg width="12" height="12" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>
                                                        @endif
                                                    </a>

                                                    @if ($hasChildren_1)
                                                        <ul class="mobile-dropdown-menu">
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
                                                                    <li
                                                                        class="{{ $hasChildren_2 ? 'mobile-dropdown' : '' }}">
                                                                        <a href="{{ $menuItem['link'] }}"
                                                                            class="{{ $menuItem['css'] }} {{ $hasChildren_2 ? 'mobile-dropdown-toggle' : '' }}"
                                                                            target="{{ $menuItem['target'] }}">
                                                                            {{ $language === 'ne' && ! empty($menuItemMeta['menu_item_title_ne']) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
                                                                            @if ($hasChildren_2)
                                                                                <svg width="12" height="12"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor"
                                                                                    stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                    <polyline points="6 9 12 15 18 9">
                                                                                    </polyline>
                                                                                </svg>
                                                                            @endif
                                                                        </a>

                                                                        @if ($hasChildren_2)
                                                                            <ul class="mobile-dropdown-menu">
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
                                                                                                {{ $language === 'ne' && ! empty($menuItemMeta['menu_item_title_ne']) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
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
                            <li class="{{ $hasChildren_0 ? 'mobile-dropdown' : '' }}">
                                <a href="{{ $menuItem['link'] }}"
                                    class="{{ $menuItem['css'] }} {{ $hasChildren_0 ? 'mobile-dropdown-toggle' : '' }}"
                                    target="{{ $menuItem['target'] }}">{{ $language === 'ne' && ! empty($menuItemMeta['menu_item_title_ne']) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
                                    @if ($hasChildren_0)
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    @endif
                                </a>

                                @if ($hasChildren_0)
                                @endif

                                @if ($hasChildren_0)
                                    <ul class="mobile-dropdown-menu">
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
                                                    $hasChildren_1 = $frontMenuRepository->menuItemHasChildren(
                                                        $depth_1,
                                                    );

                                                @endphp

                                                <li class="{{ $hasChildren_1 ? 'mobile-dropdown' : '' }}">
                                                    <a href="{{ $menuItem['link'] }}"
                                                        class="{{ $menuItem['css'] }} {{ $hasChildren_1 ? 'mobile-dropdown-toggle' : '' }}"
                                                        target="{{ $menuItem['target'] }}">{{ $language === 'ne' && ! empty($menuItemMeta['menu_item_title_ne']) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}
                                                        @if ($hasChildren_1)
                                                            <svg width="12" height="12" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                            </svg>
                                                        @endif
                                                    </a>

                                                    @if ($hasChildren_1)
                                                    @endif

                                                    @if ($hasChildren_1)
                                                        <ul class="mobile-dropdown-menu">
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
                                                                            target="{{ $menuItem['target'] }}">{{ $language === 'ne' && ! empty($menuItemMeta['menu_item_title_ne']) ? $menuItemMeta['menu_item_title_ne'] : $menuItem['title'] }}</a>
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