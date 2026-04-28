<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\CategoryMeta;

class CategoryHelper
{
    public static function getModel()
    {
        return new Category();
    }

    public static function get_field($selector, $payload)
    {
        $category = $payload;

        // Sanitize the input selector to prevent SQL injection
        $fieldName = trim( $selector );

        // Retrieve the setting payload from the database
        $payload = CategoryMeta::where('category_id', $category->id)->where('meta_key', $fieldName)->first();

        // Check if the payload is empty or not found
        if ( !$payload ) { return NULL; }

        // Retrieve the setting value from the payload
        $data = $payload->meta_value;

        // Return the setting value
        return $data;
    }
}
