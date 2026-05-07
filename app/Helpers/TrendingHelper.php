<?php

namespace App\Helpers;

use App\Models\Post;

class TrendingHelper
{
    public static function getTrendingPosts($post_type, $excludePostId = null)
    {
        // TRENDING POSTS
        $buildTrendingQuery = function () use ($post_type, $excludePostId) {
            $query = Post::where('post_type', $post_type)
                ->join('post_metas', 'posts.id', '=', 'post_metas.post_id')
                ->where('post_metas.meta_key', 'trending_count')
                ->whereNotNull('post_metas.meta_value')
                ->where('post_metas.meta_value', '!=', '')
                ->select([
                    'posts.id',
                    'posts.user_id',
                    'posts.post_title',
                    'posts.slug',
                    'posts.created_at',
                    'posts.post_type',
                    'posts.post_status',
                ])
                // Ensure numeric ordering for values stored in meta table.
                ->orderByRaw('CAST(post_metas.meta_value AS UNSIGNED) DESC');

            if ($excludePostId) {
                $query->where('posts.id', '!=', $excludePostId);
            }

            return $query;
        };

        $trendingPostQuery = $buildTrendingQuery();
        if ($time = SettingHelper::get_field('trending_news_time')) {
            $trendingPostQuery->where('posts.created_at', '>=', now()->subDays($time));
        }
        $trendingPosts = $trendingPostQuery->take(5)->get();
        $trendingPosts->load('user:id,name');

        if ($trendingPosts->isEmpty()) {
            // Fallback: use same query, but without time restriction.
            $trendingPosts = $buildTrendingQuery()->take(5)->get();
            $trendingPosts->load('user:id,name');
        }

        return $trendingPosts;
    }
}