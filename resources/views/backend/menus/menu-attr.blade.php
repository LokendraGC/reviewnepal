{{--
    menu_item_object_id : this id was associated with real data
    menu_item_type : check type of the menu item like post_type or category or custom
    menu_item_object : check type status of menu item like page, post, category, custom or other
    menu_item_classes : class name for CSS
    menu_item_target : target for anchor tag
    menu_item_attr_title : extra title for anchor tag ( optional )
    menu_item_parent_id : parent id for menu item
    menu_item_url : used for only on custom links
    menu_item_route : web route
    menu_item_custom_title : custom title for menu item
--}}

<div class="dd3-content">
    <div class="d-flex justify-content-between">
        <div class="menu_item_main_title" id="menu_item_main_title_{{ $item->id }}">
            {{ $item_meta['menu_item_custom_title'] ?? $item->post_title }}
        </div>
        <div class="menu_item_options">
            {{ ucfirst($item_meta['menu_item_type_name']) }}
            <span>
                <a class="" data-bs-toggle="collapse" href="#multiCollapseExample{{ $item->id }}" role="button"
                    aria-expanded="false" aria-controls="multiCollapseExample{{ $item->id }}"><i
                        class="ri-arrow-down-line"></i></a>
            </span>
        </div>
    </div>
</div>
<div class="collapse multi-collapse" id="multiCollapseExample{{ $item->id }}">
    <div class="card card-body mb-0 p-2">
        <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
        <input type="hidden" name="menu_item_attr_title" value="">
        <input type="hidden" name="menu_item_object" value="{{ $item_meta['menu_item_object'] }}">
        <input type="hidden" name="menu_item_object_id" value="{{ $item_meta['menu_item_object_id'] }}">
        @if ($item_meta['menu_item_object'] == 'custom')
            <div class="mb-1">
                <label for="menu_item_url" class="form-label mb-0 fw-500">URL</label>
                <input type="text" class="form-control p-1" id="menu_item_url" name="menu_item_url"
                    value="{{ $item_meta['menu_item_url'] }}" />
            </div>
        @else
            <input type="hidden" name="menu_item_url" value="">
        @endif
        <div class="mb-1">
            <label for="navigation_label_{{ $item->id }}" class="form-label mb-0 fw-500">Navigation
                Level</label>
            <input type="text" class="form-control p-1" id="navigation_label_{{ $item->id }}"
                name="menu_item_main_title" value="{{ $item->post_title }}" />
        </div>
        <div class="mb-1">
            <label for="menu_item_title_ne_{{ $item->id }}" class="form-label mb-0 fw-500">
                Menu Title in Nepali</label>
            <input type="text" class="form-control p-1" id="menu_item_title_ne_{{ $item->id }}"
                name="menu_item_title_ne" value="{{ $item_meta['menu_item_title_ne'] ?? '' }}" />
        </div>
        <div class="mb-1">
            <label for="menu_item_classes" class="form-label mb-0 fw-500">CSS Classes
                (optional)
            </label>
            <input type="text" class="form-control p-1" id="menu_item_classes" name="menu_item_classes"
                value="{{ $item_meta['menu_item_classes'] }}" />
        </div>
        <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input new_tab" @if ($item_meta['menu_item_target']) checked @endif
                id="customCheck{{ $item->id }}" value="_blank">
            <label class="form-check-label" for="customCheck{{ $item->id }}">Open link in
                a new tab</label>
        </div>
        <p>
            <a href="javascript:void(0)"
                class="link-danger text-decoration-underline link-underline-danger remove-menu-item">Remove</a>
            |
            <a href="javascript:void(0)"
                class="text-decoration-underline link-underline-primary update-menu-item">Update</a>
        </p>
    </div>
</div>
