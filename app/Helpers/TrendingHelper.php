<?php

namespace App\Helpers;

use App\Models\Post;

class TrendingHelper
{
    public static function getTrendingPosts($postType, $limit = 5, $excludePostId = null)
    {
        $days = SettingHelper::get_field('trending_news_time') ?? 7;

        $query = Post::where('post_type', $postType)
            ->where('post_status', 'publish')
            ->where('created_at', '>=', now()->subDays($days));

        if ($excludePostId) {
            $query->where('posts.id', '!=', $excludePostId);
        }

        return $query
            ->orderByDesc('posts.trending_count')
            ->take($limit)
            ->get(['posts.*']);
    }
}