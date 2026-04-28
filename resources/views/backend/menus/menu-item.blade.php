<li class="dd-item dd3-item" data-id="{{ $item->id }}">
    <div class="dd-handle dd3-handle"></div>
    @include('backend.menus.menu-attr', ['item' => $item, 'item_meta' => $item->GetAllMetaData()])

    @php
        $children = PostHelper::getModel()
            ->PostType('nav_menu_item')
            ->whereHas('postMeta', function ($query) use ($item) {
                $query->where('meta_key', 'menu_item_parent_id')->where('meta_value', $item->id);
            })
            ->orderBy('menu_order', 'ASC')
            ->get();
    @endphp

    @if ($children->isNotEmpty())
        <ol class="dd-list">
            @foreach ($children as $child)
                @include('backend.menus.menu-item', ['item' => $child])
            @endforeach
        </ol>
    @endif
</li>
