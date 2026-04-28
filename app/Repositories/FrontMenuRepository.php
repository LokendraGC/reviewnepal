<?php

namespace App\Repositories;

use App\Helpers\PostHelper;
use App\Helpers\CategoryHelper;

class FrontMenuRepository
{
    public function checkTypeOfMenuItem($type, $menu, $meta)
    {
        if ( $type == 'category') {

            $menuItem = CategoryHelper::getModel()
            ->where(['id' => $meta['menu_item_object_id'], 'type' => 'category'])
            ->first();
            $menuTitle = $menu->post_title;
            $menuLink = route($meta['menu_item_route'], $menuItem->slug);
            $menuCSS = isset($meta['menu_item_classes']) ? $meta['menu_item_classes'] : '';
            $menuTarget = isset($meta['menu_item_target']) ? $meta['menu_item_target'] : '_self';

            return [
                'title' => $menuTitle,
                'link' => $menuLink,
                'css' => $menuCSS,
                'target' => $menuTarget,
            ];
        }

        if ( $type == 'page' ) {

            $menuItem = PostHelper::getModel()
            ->where(['id' => $meta['menu_item_object_id'], 'post_type' => 'page'])
            ->first();
            $menuTitle = $menu->post_title;
            $menuLink = route($meta['menu_item_route'], $menuItem->slug);
            $menuCSS = isset($meta['menu_item_classes']) ? $meta['menu_item_classes'] : '';
            $menuTarget = isset($meta['menu_item_target']) ? $meta['menu_item_target'] : '_self';

            return [
                'title' => $menuTitle,
                'link' => $menuLink,
                'css' => $menuCSS,
                'target' => $menuTarget,
            ];
        }

        if ( $type == 'custom' ) {
            $menuItem = PostHelper::getModel()
            ->where(['id' => $meta['menu_item_object_id'], 'post_type' => 'nav_menu_item'])
            ->first();
            $menuTitle = $menuItem->post_title;
            $menuLink = isset($meta['menu_item_url']) ? $meta['menu_item_url'] : '#';
            $menuCSS = isset($meta['menu_item_classes']) ? $meta['menu_item_classes'] : '';
            $menuTarget = isset($meta['menu_item_target']) ? $meta['menu_item_target'] : '_self';

            return [
                'title' => $menuTitle,
                'link' => $menuLink,
                'css' => $menuCSS,
                'target' => $menuTarget,
            ];
        }
    }

    public function menuItemHasChildren($parent)
    {
        $children = PostHelper::getModel()->PostType('nav_menu_item')
        ->whereHas('postMeta', function ($query) use ($parent) {
            $query->where('meta_key', 'menu_item_parent_id')->where('meta_value', $parent->id);
        })
        ->orderBy('menu_order', 'ASC')
        ->get();

        if ( $children->isNotEmpty() ) {
            return $children;
        }

        return [];
    }
}
