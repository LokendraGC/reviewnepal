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
                <li class="nav-item">
                    @php
                        $hasChildren = $frontMenuRepository->menuItemHasChildren($depth_0);
                    @endphp
                    <a href="{{ $menuItem['link'] }}"
                        class="{{ $menuItem['css'] }} nav-link {{ $hasChildren ? 'dropdown-toggle' : '' }}"
                        target="{{ $menuItem['target'] }}">{{ $menuItem['title'] }}</a>
                    @if ($hasChildren)
                        <ul class="dropdown-menu">
                            @foreach ($hasChildren as $menu)
                                @php
                                    $menuItemMeta = $menu->GetAllMetaData();
                                    $menuItem = $frontMenuRepository->checkTypeOfMenuItem(
                                        $menuItemMeta['menu_item_object'],
                                        $menu,
                                        $menuItemMeta,
                                    );
                                @endphp
                                @if ($menuItem)
                                    <li class="nav-item">
                                        <a href="{{ $menuItem['link'] }}" class="{{ $menuItem['css'] }} nav-link"
                                            target="{{ $menuItem['target'] }}">{{ $menuItem['title'] }}</a>
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
                <li class="nav-item">
                    @php
                        $hasChildren = $frontMenuRepository->menuItemHasChildren($depth_0);
                    @endphp
                    <a href="{{ $menuItem['link'] }}"
                        class="{{ $menuItem['css'] }} nav-link {{ $hasChildren ? 'dropdown-toggle' : '' }}"
                        target="{{ $menuItem['target'] }}">{{ $menuItem['title'] }}</a>
                    @if ($hasChildren)
                        <ul class="dropdown-menu">
                            @foreach ($hasChildren as $menu)
                                @php
                                    $menuItemMeta = $menu->GetAllMetaData();
                                    $menuItem = $frontMenuRepository->checkTypeOfMenuItem(
                                        $menuItemMeta['menu_item_object'],
                                        $menu,
                                        $menuItemMeta,
                                    );
                                @endphp
                                @if ($menuItem)
                                    <li class="nav-item">
                                        <a href="{{ $menuItem['link'] }}" class="{{ $menuItem['css'] }} nav-link"
                                            target="{{ $menuItem['target'] }}">{{ $menuItem['title'] }}</a>
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
