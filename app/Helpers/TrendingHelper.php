<?php

namespace App\Helpers;

use App\Models\Post;

class TrendingHelper
{
    public static function getTrendingPosts($post_type, $excludePostId = null)
    {
         // TRENDING POSTS
         $trendingPostQuery = Post::where('post_type', $post_type)
         ->join('post_metas', 'posts.id', '=', 'post_metas.post_id')
         ->where('post_metas.meta_key', 'trending_count')
         ->whereNotNull('post_metas.meta_value')
         ->select(['posts.id', 'posts.user_id', 'posts.post_title', 'posts.slug', 'posts.created_at','posts.post_type','posts.post_status'])
         ->orderByDesc('post_metas.meta_value');
         if ($excludePostId) {
            $trendingPostQuery->where('posts.id', '!=', $excludePostId);
        }
     if ( $time = SettingHelper::get_field('trending_news_time') )
     {
         $trendingPostQuery->where('posts.created_at', '>=', now()->subDays($time));
     }
     $trendingPosts = $trendingPostQuery->take(5)->get();
     $trendingPosts->load('user:id,name');

     if ( $trendingPosts->isEmpty()  ) {
         $trendingPostQuery = Post::where('post_type', $post_type)
         ->join('post_metas', 'posts.id', '=', 'post_metas.post_id')
         ->where('post_metas.meta_key', 'trending_count')
         ->whereNotNull('post_metas.meta_value')
         ->select(['posts.id', 'posts.user_id', 'posts.post_title', 'posts.slug', 'posts.created_at','posts.post_type','posts.post_status'])
         ->orderByDesc('post_metas.meta_value');
         $trendingPosts = $trendingPostQuery->take(5)->get();
         $trendingPosts->load('user:id,name');
     }
     return $trendingPosts;
    }
}