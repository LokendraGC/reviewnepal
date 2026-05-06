<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Post;
use App\Enums\PostType;
use App\Models\Category;
use App\Models\PostMeta;
use App\Traits\ImageFieldTrait;
use App\Traits\SlugGenerateTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostRepository
{
    use SlugGenerateTrait, ImageFieldTrait;

    public function query()
    {
        return Post::query();
    }

    // check post type exists or not
    public function checkPostTypeExists($type)
    {
        if ( !in_array( $type, PostType::toArray() ) )
        {
            abort(403, 'Post Type Not Found');
        }

        return true;
    }

    // get all posts
    public function getAllPost($type)
    {
        return Post::with(['categories', 'postMeta'])->where('post_type', $type)->get();
    }

    // get draft posts
    public function getPostsByStatus($type, $status)
    {
        return Post::where('post_type', $type)->where('post_status', $status)->get();
    }

    // get all trashed posts
    public function getTrashedPosts($type)
    {
        return Post::onlyTrashed()->where('post_type', $type)->get();
    }

    // get posts by category
    public function getPostByCategory($type)
    {
        return Category::where('type', $type);
    }

    // create new post
    public function createPost($request, $type)
    {
        return DB::transaction( function () use ($request, $type) {

            $model = new Post();

            // Create the post
            $post = Post::create([
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_name,
                'slug' => $this->createSlug( $request->post_name, $request->slug, $model),
                'post_content' => $request->post_content ?? null,
                'post_excerpt' => $request->post_excerpt ?? null,
                'post_status' => in_array( $request->post_status, ['publish', 'draft'] ) ? $request->post_status : 'publish',
                'post_parent' => isset($request->post_parent) ?  $request->post_parent : 0,
                'post_type' => $type ?? 'post',
                'comment_status' => $request->comment_status ?? 'open',
                'menu_order' => $request->menu_order ?? 0,
                'post_password' => $request->post_password ?? null,
            ]);

            return $post;

        });
    }

    // insert or update meta data
    public function storeMetaData($payload, $request)
    {
        $metaDatas = [];
        $metaDatas['seo_title'] = isset( $request->seo_title ) ? $request->seo_title : NULL;
        $metaDatas['seo_description'] = isset( $request->seo_description ) ? $request->seo_description : NULL;
        $metaDatas['featured_image'] = isset( $request->featured_image ) ? $request->featured_image : NULL;
        $metaDatas['show_banner'] = isset( $request->show_banner ) ? $request->show_banner : 0;
        // add meta data as per form data

        // insert or update meta data
        foreach ($metaDatas as $key => $value) {
            $payload->postMeta()->updateOrInsert(
                ['post_id' => $payload->id, 'meta_key' => $key],
                ['meta_value' => $value]
            );
        }
        // $this->bulkInserOrUpdate($payload, $metaDatas);
    }

    // update or create post meta
    public function updateOrCreateMeta($post, $key, $value)
    {
        $post->postMeta()->updateOrInsert(
            ['post_id' => $post->id, 'meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    // update existing post
    public function updatePost($request, $payload, $type)
    {
        return DB::transaction( function () use ($request, $payload, $type) {

            $post = $payload;
            $postStatus = ['publish', 'draft', 'pending'];

            $status = $post->update([
                'user_id' => $post->user_id,
                'post_title' => $request->post_name,
                'slug' => $this->getSlug( $post, $request->post_name, $request->slug),
                'post_content' => isset($request->post_content) ? $request->post_content : NULL,
                'post_excerpt' => isset($request->post_excerpt) ?  $request->post_excerpt : NULL,
                'post_status' => isset($request->post_status) && in_array($request->post_status, $postStatus)  ? $request->post_status : 'draft',
                'post_parent' => isset($request->post_parent) ?  $request->post_parent : 0,
                'post_type' => $type ?? 'post',
                'comment_status' => $request->comment_status ?? 'open',
                'menu_order' => isset($request->menu_order) ?  $request->menu_order : 0,
                'post_password' => $request->post_password ?? null,
            ]);

            if ( $status ) {
                $post->created_at = isset($request->created_at) ?  Carbon::parse( $request->created_at ) : Carbon::parse( $post->created_at );
                $post->update();
            }

            $this->updateMenuItemTitle($post);
            
            return [ 'status' => $status, 'post' => $post];

        });

    }

    // check payload id in postmetas table whose meta key is menu_item_object_id and menu_item_custom_title is null
    public function updateMenuItemTitle($payload)
    {
        $postIds = DB::table('post_metas as pm1')
        ->leftJoin('post_metas as pm2', function ($join) {
            $join->on('pm1.post_id', '=', 'pm2.post_id')
                ->where('pm2.meta_key', 'menu_item_custom_title');
        })
        ->where('pm1.meta_key', 'menu_item_object_id')
        ->where('pm1.meta_value', $payload->id)
        ->where(function ($query) {
            $query->whereNull('pm2.meta_value')
                ->orWhereNull('pm2.post_id');  
        })
        ->pluck('pm1.post_id')
        ->toArray();
        
        if ( !empty($postIds) ) {
            Post::whereIn('id', $postIds)->update([
                'post_title' => $payload->post_title,
            ]);
        }

        return true;
    }

    // get post meta data
    public function getMetaDatas($payload)
    {
        return $payload->postMeta->pluck('meta_value', 'meta_key')->toArray();
    }

    // make posts trash
    public function makeTrash($payload)
    {
        $payload->delete();

        return true;
    }

    // show trash posts
    public function showTrashPosts($type)
    {
        $posts = Post::onlyTrashed()->where('post_type', $type)->get();

        return $posts;
    }

    // restore posts
    public function restorePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        if ( !empty( $post ) ) {
            $post->restore();
        }

        return true;
    }

    public function permanentDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        if ( !empty( $post ) ) {
            $post->forceDelete();
        }

        return true;
    }

    // make post type base64_encode
    public function encodeType($type)
    {
        return base64_encode($type);
    }

    // make post type base64_decode
    public function decodeType($type)
    {
        return base64_decode($type);
    }

    // get related posts
    public function getRelatedPosts($id, $postType = null)
    {
        $post = Post::with('categories')->where('post_status', 'publish')->find($id);

        if ( !$post ) { return collect(); }

            $categories = $post->categories;

            if ( !$categories ) { return collect(); }

            $relatedPosts = collect();

            foreach ($categories as $category) {
                $query = $category->posts()
                    ->where('posts.id', '!=', $id)
                    ->where('posts.post_status', 'publish');

                if ($postType) {
                    $query->where('posts.post_type', $postType);
                }

                $relatedPosts = $relatedPosts->merge($query->latest()->get());
            }

            $relatedPosts = $relatedPosts
                ->unique('id')
                ->values();

            // shuffle($relatedPosts);

            // return $relatedPosts;

            return $relatedPosts->take(8);
    }

    // Insert a new record if it doesn’t exist, or update it if it does — all in one query.
    public function bulkInserOrUpdate($payload, $metaDatas)
    {
        $bulkData = [];
        foreach ($metaDatas as $key => $value) {
            $bulkData[] = [
                'post_id' => $payload->id,
                'meta_key' => $key,
                'meta_value' => $value,
            ];
        }
        PostMeta::upsert($bulkData,['post_id', 'meta_key'], ['meta_value']);
    }

    // v2
    public function countAll($postType)
    {
        return Post::postType($postType)->count();
    }

    public function countByStatus($postType, $status)
    {
        return Post::postType($postType)->postStatus($status)->count();
    }

    public function countTrashedPosts($postType)
    {
        return Post::postType($postType)->onlyTrashed()->count();
    }
}
