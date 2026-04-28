<?php

namespace App\Helpers;

use App\Models\Post;
use App\Models\PostMeta;

class PostHelper
{
    public static function getModel()
    {
        return new Post();
    }

    public static function get_field($selector, $payload)
    {
        $post = $payload;

        // Sanitize the input selector to prevent SQL injection
        $fieldName = trim( $selector );

        // Retrieve the setting payload from the database
        $payload = PostMeta::where('post_id', $post->id)->where('meta_key', $fieldName)->first();

        // Check if the payload is empty or not found
        if ( !$payload ) { return NULL; }

        // Retrieve the setting value from the payload
        $data = $payload->meta_value;

        // Return the setting value
        return $data;
    }

    public static function setTrendingPosts($post)
    {
        $prevCount = self::get_field('trending_count', $post);

        $newCount = $prevCount !== null ? $prevCount + 1 : 1;

        $post->postMeta()->updateOrInsert(
            ['post_id' => $post->id, 'meta_key' => 'trending_count'],
            ['meta_value' => $newCount]
        );
    }

    public static function updatePostShareCount($post)
    {
        $prevCount = self::get_field('share_count', $post);

        $newCount = $prevCount !== null ? $prevCount + 1 : 1;

        $post->postMeta()->updateOrInsert(
            ['post_id' => $post->id, 'meta_key' => 'share_count'],
            ['meta_value' => $newCount]
        );
    }
}
