<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MenuRepository
{
    public function createMenuItem($menu, $postModel, $catModel, $type, $request)
    {
        if ( !isset($request->menu_item) ) { return false; }

        $filterMenuItems = array_filter($request->menu_item, function ($item) {
            return (isset($item['menu_item_object_id']) && !empty($item['menu_item_object_id'])) || (isset($item['menu_item_type']) && !empty($item['menu_item_type']) && $item['menu_item_type'] == 'custom');
        });

        if (!$filterMenuItems) {
            return false;
        }

        $menuItemCount = $menu->posts ? $menu->posts->count() : 0;

        foreach ($filterMenuItems as $key => $item) {
            if (isset($item['menu_item_type']) && $item['menu_item_type'] === 'custom') {
                $rules = [
                    'menu_item_title' => 'required|string|max:255',
                    'menu_item_type'  => 'required|string|in:custom,other_type',
                ];

                if (isset($item['menu_item_type']) && $item['menu_item_type'] === 'custom') {
                    $rules['menu_item_url'] = 'required|string';
                }

                $validator = Validator::make($item, $rules);
                if ($validator->fails()) {
                    $validator->validate();
                    return true;
                }
            }
        }


        $newMenuIds = [];
        foreach ( $filterMenuItems as $item ) {

            $menuItemCount = $menuItemCount + 1;

            $post = Post::create([
                'user_id' => Auth::user()->id,
                'post_title' => $item['menu_item_title'],
                'slug' => Str::random(6),
                'post_content' => NULL,
                'post_excerpt' => NULL,
                'post_status' => 'publish',
                'post_parent' => 0,
                'post_type' => $type.'_item',
                'menu_order' => $menuItemCount,
            ]);

            $this->processMetaData($post, $item);
            $this->assignItemToMenu($catModel, $menu, $post);
        }

        return true;
    }

    public function processMetaData($payload, $request)
    {
        $data = [];
        $data['menu_item_object_id'] = isset( $request['menu_item_object_id'] ) ? $request['menu_item_object_id'] : $payload->id;
        $data['menu_item_type'] = $request['menu_item_type'] ?? null;
        $data['menu_item_object'] = $request['menu_item_object'] ?? null;
        $data['menu_item_url'] = $request['menu_item_url'] ?? null;
        $data['menu_item_parent_id'] = 0;
        $data['menu_item_attr_title'] = $request['menu_item_attr_title'] ?? null;
        $data['menu_item_target'] = $request['menu_item_target'] ?? null;
        $data['menu_item_classes'] = $request['menu_item_classes'] ?? null;
        // $data['menu_item_route'] = isset( $request['menu_item_route'] ) ? $request['menu_item_route'] : NULL;
        $data['menu_item_type_name'] = $request['menu_item_type_name'] ?? null;
        $data['menu_item_custom_title'] = $request['menu_item_custom_title'] ?? null;

        // insert or update meta data
        foreach ($data as $key => $value) {
            $this->updateOrCreateMeta($payload, $key, $value);
        }
    }

    // update Or insert data
    public function updateOrCreateMeta($post, $key, $value)
    {
        $post->postMeta()->updateOrInsert(
            ['post_id' => $post->id, 'meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    public function assignItemToMenu($cat, $menu, $post)
    {
        $existingCategoryIds = $cat->whereIn('id', [$menu->id])->pluck('id')->toArray();
        $post->exists() ? $post->categories()->sync($existingCategoryIds) : $post->categories()->attach($existingCategoryIds);
        return true;
    }

    // for APIs
    public function getMenuTree($meta, $item)
    {
        $menuMethods = [
            'page'                  => 'pageBuildTree',
            'news'                  => 'newsBuildTree',
            'wiki-category'         => 'wikiCategoryBuildTree',
            'web-stories-category'  => 'webStoriesCategoryBuildTree',
            'category'              => 'categoryBuildTree',
            'custom'                => 'customBuildTree',
        ];

        $menuObject = $meta['menu_item_object'] ?? '';

        if ( array_key_exists( $menuObject, $menuMethods ) ) {
            $menuData = $this->{$menuMethods[$menuObject]}($item, $meta);
        } else {
            $menuData = [];
        }

        return $menuData;
    } 

    protected function pageBuildTree($item, $meta)
    {
        $page = Post::whereId($meta['menu_item_object_id'])->wherePostType($meta['menu_item_object'])->wherePostStatus('publish')->first();

        if ( !$page ) return [];

        return [
            'id'        => $item->id,
            'title'     => $item->post_title,
            'slug'      => $page->slug,
            'target'    => $meta['menu_item_target'] ?? '_self',
            'classes'   => $meta['menu_item_classes'] ?? null,
            'attr'      => $meta['menu_item_attr_title'] ?? null,
            'type'      => $meta['menu_item_object'] ?? null,
        ];

    }

    protected function newsBuildTree($item, $meta)
    {
        $news = Post::whereId($meta['menu_item_object_id'])->wherePostType($meta['menu_item_object'])->wherePostStatus('publish')->first();

        if ( !$news ) return [];

        return [
            'id'        => $item->id,
            'title'     => $item->post_title,
            'slug'      => '/'.$news->slug.'/',
            'target'    => $meta['menu_item_target'] ?? '_self',
            'classes'   => $meta['menu_item_classes'] ?? null,
            'attr'      => $meta['menu_item_attr_title'] ?? null,
            'type'      => $meta['menu_item_object'] ?? null,
        ];

    }

    protected function categoryBuildTree($item, $meta)
    {
        $cat = Category::whereId($meta['menu_item_object_id'])->first();

        if ( !$cat ) return [];
        
        return [
            'id'        => $item->id,
            'title'     => $item->post_title,
              'slug'    => '/'.$meta['menu_item_object'].'/'.$cat->slug.'/',
            'target'    => $meta['menu_item_target'] ?? '_self',
            'classes'   => $meta['menu_item_classes'] ?? null,
            'attr'      => $meta['menu_item_attr_title'] ?? null,
            'type'      => $meta['menu_item_object'] ?? null,
        ];

    }

    protected function wikiCategoryBuildTree($item, $meta)
    {
        $cat = Category::whereId($meta['menu_item_object_id'])->whereType($meta['menu_item_object'])->first();

        if ( !$cat ) return [];
        
        return [
            'id'        => $item->id,
            'title'     => $item->post_title,
            'slug'      => '/'.$meta['menu_item_object'].'/'.$cat->slug.'/',
            'target'    => $meta['menu_item_target'] ?? '_self',
            'classes'   => $meta['menu_item_classes'] ?? null,
            'attr'      => $meta['menu_item_attr_title'] ?? null,
            'type'      => $meta['menu_item_object'] ?? null,
        ];

    }

    protected function WebStoriesCategoryBuildTree($item, $meta)
    {
        $cat = Category::whereId($meta['menu_item_object_id'])->whereType($meta['menu_item_object'])->first();

        if ( !$cat ) return [];
        
        return [
            'id'        => $item->id,
            'title'     => $item->post_title,
            'slug'      => '/'.$meta['menu_item_object'].'/'.$cat->slug.'/',
            'target'    => $meta['menu_item_target'] ?? '_self',
            'classes'   => $meta['menu_item_classes'] ?? null,
            'attr'      => $meta['menu_item_attr_title'] ?? null,
            'type'      => $meta['menu_item_object'] ?? null,
        ];

    }

    protected function customBuildTree($item, $meta)
    {
        return [
            'id'        => $item->id,
            'title'     => $item->post_title,
            'slug'      => $meta['menu_item_url'] ?? '#',
            'target'    => $meta['menu_item_target'] ?? '_self',
            'classes'   => $meta['menu_item_classes'] ?? null,
            'attr'      => $meta['menu_item_attr_title'] ?? null,
            'type'      => $meta['menu_item_object'] ?? null,
        ];

    }
}
