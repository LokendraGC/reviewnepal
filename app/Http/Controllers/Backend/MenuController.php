<?php

namespace App\Http\Controllers\Backend;

use App\Models\Post;
use App\Models\Category;
use App\Models\PostMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use App\Repositories\CategoryRepository;

class MenuController extends Controller
{
    private $categoryRepository;
    private $categoryType;
    private $postModel;
    private $catModel;
    private $menuRepository;

    public function __construct(Post $postModel, Category $catModel, CategoryRepository $categoryRepository, MenuRepository $menuRepository)
    {
        $this->middleware('permission:create_menu', ['only' => ['create','store']] );
        $this->middleware('permission:read_menu', ['only' => ['index']] );
        $this->middleware('permission:update_menu', ['only' => ['update','edit', 'addEditMenuItems', 'updateEditMenuItems']] );
        $this->middleware('permission:delete_menu', ['only' => 'destroy']);

        $this->categoryType = 'nav_menu';
        $this->postModel = $postModel;
        $this->catModel = $catModel;
        $this->categoryRepository = $categoryRepository;
        $this->menuRepository = $menuRepository;
    }

    public function index()
    {
        $categories = $this->catModel
        ->where('type', $this->categoryType)
        ->where('parent', 0)
        ->orderBy('name', 'ASC')
        ->get();

        return view('backend.menus.index-menu', compact('categories'));
    }

    public function create()
    {
        $type = $this->categoryRepository->encodeType($this->categoryType);
        return view('backend.menus.create-menu', compact('type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        $type = isset( $request->type ) ? $this->categoryRepository->decodeType($request->type) : 'NOT FOUND';

        // check category type exists or not
        $this->categoryRepository->checkCategoryTypeExists($type);

        try {

            // create new category
            $category = $this->categoryRepository->createCategory($request, $this->categoryType);

            session()->flash('success', 'Menu Created.');

            return redirect()->route('backend.menu');

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Creating: ' . $e->getMessage());
            Log::error($e);
            return redirect()->back();
        }
    }

    public function edit(Category $id)
    {
        if ( $id->type != 'nav_menu') abort(404);

        return view('backend.menus.edit-menu', [
            'type' => 'nav_menu',
            'menu' => $id,
        ]);
    }

    public function update(Category $id, Request $request)
    {
        if ( $id->type != 'nav_menu') abort(404);
        
        $request->validate([
            'name' => 'required',
            'menu_order' => 'numeric|min:0|max:3'
        ], [
            'menu_order.min' => 'The depth field must be at least 1.',
            'menu_order.max' => 'The depth field must not be greater than 3.',
        ]);

        try {
            $request->merge(['slug' => $id->slug]);
            $category = $this->categoryRepository->updateCategory($request, $id, $this->categoryType);
            session()->flash('success', 'Menu Updated.');

        } catch (\Exception $e) {
            session()->flash('error', 'Error While Updating: ' . $e->getMessage());
            Log::error($e);
        }

        return redirect()->back();

    }

    public function addEditMenuItems(Category $id)
    {
        $cat = $menu = $id;

        if ( $cat->type != $this->categoryType ) { abort(404); }

        // sidebar lists for menu
        $pages = $this->postModel->where([ 'post_type' => 'page', 'post_status' => 'publish'])->orderBy('post_title', 'ASC')->get();
        // $posts = $this->postModel->where([ 'post_type' => 'post', 'post_status' => 'publish'])->orderBy('post_title', 'ASC')->get();
        $categories = $this->catModel->where([ 'type' => 'category'])->orderBy('name', 'ASC')->get();
        $wikiCats = $this->catModel->where([ 'type' => 'wiki-category'])->orderBy('name', 'ASC')->get();
        $webstoriesCats = $this->catModel->where([ 'type' => 'web-stories-category'])->orderBy('name', 'ASC')->get();

        $posts = [];

        $allMenuItems = $menu->posts;
        // $parentMenuItems = $allMenuItems->filter(function ($item) {
        //     // Assuming postmetas relationship is defined on the post model
        //     dd($item->postMeta);
        //     return $item->postMeta->menu_item_parent_id === 0;
        // });

        $allMenuItems = $parentMenuItems = $allMenuItems->filter(function ($item) {
            // Check if the item has a postmeta entry with meta_key 'menu_item_parent_id' and meta_value '0'
            return $item->postMeta->contains(function ($meta) {
                return $meta->meta_key === 'menu_item_parent_id' && $meta->meta_value === '0';
            });
        })->sortBy('menu_order');


        // return $parentMenuItems;

        // return view('backend.menus.add-edit-menu-item', compact('menu', 'pages', 'posts', 'categories', 'allMenuItems') );
        return view('backend.menus.add-edit-menu-item', [
            'menu' => $menu,
            'depth' => $menu->menu_order,
            'pages' => $pages,
            'posts' => [],
            'categories' => $categories,
            'wikiCats' => $wikiCats,
            'webstoriesCats' => $webstoriesCats,
            'allMenuItems' => $allMenuItems,
        ]);

    }

    public function updateEditMenuItems(Category $id, Request $request)
    {
        $menu = $id;
        // dd( $request->all() );
        try {

            // create new category
            // $category = $this->categoryRepository->createCategory($request, $this->categoryType);

            $status = $this->menuRepository->createMenuItem($menu, $this->postModel, $this->catModel, $this->categoryType, $request);

            session()->flash($status ? 'success' : 'warning', $status ? 'Item has been added.' : 'Please select items before add.');

        } catch (\Exception $e) {

            session()->flash('error', 'Error While Creating: ' . $e->getMessage());
            Log::error($e);
        }

        return redirect()->back();
    }

    public function sortMenu(Request $request, $id)
    {
        $list = $request->list;

        if (isset($list)) {
            $this->updateMenuOrder($list);
        }

        return response()->json(['message' => 'Menu sorted successfully']);
    }

    private function updateMenuOrder(array $items, $parentId = 0, &$order = 1)
    {
        foreach ($items as $item) {
            $post = Post::find($item['id']);
            
            if ($post) {
                $post->menu_order = $order++;
                $post->update();

                $post->postMeta()->updateOrInsert(
                    ['post_id' => $post->id, 'meta_key' => 'menu_item_parent_id'],
                    ['meta_value' => $parentId]
                );
                if (!empty($item['children'])) {
                    $this->updateMenuOrder($item['children'], $post->id, $order);
                }
            }
        }
    }

    public function menuItemDelete(Request $request, $menu_id, $id)
    {
        $menu = Post::where(['id' => $id, 'post_type' => 'nav_menu_item'])->first();

        if ( $menu ) {
            $deleteIds = [$menu->id];
            $menuMeta = PostMeta::where(['meta_key' => 'menu_item_parent_id', 'meta_value' => $menu->id])->get();
            $postIds = $menuMeta->pluck('post_id')->toArray();
            $ids = array_merge($deleteIds, $postIds);
            Post::whereIn('id', $ids)->forceDelete();
            return true;
        }

        return false;
    }

    public function menuItemUpdate(Request $request)
    {
        if (!$request->menu_item_id) {
            return ['status' => false];
        }

        $menuItem = Post::select('id', 'post_title')->find($request->menu_item_id);

        if (!$menuItem) {
            return ['status' => false];
        }

        // Determine title
        if ($request->filled('menu_item_main_title')) {
            $title = $request->menu_item_main_title;
        } else {
            $originalPost = Post::select('post_title')->find($request->menu_item_object_id);
            $title = $originalPost->post_title ?? $menuItem->post_title;
        }

        // Update only once
        $menuItem->update([
            'post_title' => $title
        ]);

        // Meta fields
        $meta = [
            'menu_item_custom_title' => $request->menu_item_main_title ?? null,
            'menu_item_classes'      => $request->menu_item_classes ?? null,
            'menu_item_attr_title'   => $request->menu_item_attr_title ?? null,
            'menu_item_url'          => $request->menu_item_url ?? null,
            'menu_item_target'       => $request->menu_item_target ?? null,
        ];

        foreach ($meta as $key => $value) {
            $this->menuRepository->updateOrCreateMeta($menuItem, $key, $value);
        }

        return [
            'status' => true,
            'menu_item_id' => $menuItem->id,
            'menu_item_main_title_' => $title,
        ];
    }
}
