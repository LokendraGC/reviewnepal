<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\UserMeta;

class UserHelper
{
    public static function getModel()
    {
        return new User();
    }

    public static function get_field($selector, $payload)
    {
        $user = $payload;

        // Sanitize the input selector to prevent SQL injection
        $fieldName = trim( $selector );

        // Retrieve the setting payload from the database
        $payload = UserMeta::where('user_id', $user->id)->where('meta_key', $fieldName)->first();

        // Check if the payload is empty or not found
        if ( !$payload ) { return NULL; }

        // Retrieve the setting value from the payload
        $data = $payload->meta_value;

        // Return the setting value
        return $data;
    }
}
