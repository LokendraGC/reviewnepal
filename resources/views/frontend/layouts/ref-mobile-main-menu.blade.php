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
                <div class="accordion-item">
                    @php
                        $hasChildren = $frontMenuRepository->menuItemHasChildren($depth_0);
                    @endphp
                    @if ($hasChildren)
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $depth_0->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $depth_0->id }}">
                            {{ $menuItem['title'] }}
                        </button>
                        <div id="collapse{{ $depth_0->id }}" class="accordion-collapse collapse"
                            data-bs-parent="#navbarAccordion">
                            <div class="accordion-body">
                                <div class="accordion" id="navbarAccordion7">
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
                                            <div class="accordion-item">
                                                <a href="{{ $menuItem['link'] }}"
                                                    class="{{ $menuItem['css'] }} accordion-link"
                                                    target="{{ $menuItem['target'] }}">{{ $menuItem['title'] }}</a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        @else
        @endif
    @endforeach
@endif
