@inject('frontMenuRepository', 'App\Repositories\FrontMenuRepository')

@php
    $language = LanguageHelper::getUserLanguage();
@endphp
@if ($footerMenu)
    @php
        $allMenuItems = $footerMenu->posts;
        $parentMenuItems = $allMenuItems
            ->filter(function ($item) {
                return $item->postMeta->contains(function ($meta) {
                    return $meta->meta_key === 'menu_item_parent_id' && $meta->meta_value === '0';
                });
            })
            ->sortBy('menu_order');

    @endphp
    @if ($parentMenuItems)
    
            @foreach ($parentMenuItems as $menu)
                @php
                    $menuItemMeta = $menu->GetAllMetaData();
                    $menuItem = $frontMenuRepository->checkTypeOfMenuItem(
                        $menuItemMeta['menu_item_object'],
                        $menu,
                        $menuItemMeta,
                    );
                    $menuDisplayTitle = '';
                    if ($menuItem) {
                        $menuDisplayTitle = $menuItem['title'] ?? '';
                        if ($language === 'ne' && ! empty($menuItemMeta['menu_item_title_ne'])) {
                            $menuDisplayTitle = $menuItemMeta['menu_item_title_ne'];
                        }
                    }
                @endphp
                @if ($menuItem)
               
                        <a href="{{ $menuItem['link'] }}" class="{{ $menuItem['css'] }}"
                            target="{{ $menuItem['target'] }}">{{ $menuDisplayTitle }}</a>
                 
                @endif
            @endforeach
   
    @endif
@endif