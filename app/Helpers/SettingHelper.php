<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingHelper
{
    public static function getModel()
    {
        return new Setting();
    }

    public static function get_field($selector)
    {
        // Sanitize the input selector to prevent SQL injection
        $fieldName = trim( $selector );

        // Retrieve the setting payload from the database
        $payload = Setting::where('setting_name', $fieldName)->first();

        // Check if the payload is empty or not found
        if ( !$payload ) { return NULL; }

        // Retrieve the setting value from the payload
        $data = $payload->setting_value;

        // Return the setting value
        return $data;
    }

    public static function get_home_id()
    {
        $pageId = Setting::where('setting_name', 'page_on_front')->value('setting_value');

        return $pageId;
    }

    public static function get_select_key_value($selector)
    {
        $fieldName = trim( $selector );

        $payload = Setting::where('setting_name', $fieldName)->first();

        if ( !$payload ) { return []; }

        $data = $payload->setting_value;

        $key_value_pairs = [];
        $lines = preg_split('/\r\n|\r|\n/', $data);

        foreach ($lines as $line) {
            [$key, $value] = array_map('trim', explode(':', $line, 2));
            $key_value_pairs[$key] = $value;
        }

        return $key_value_pairs;
    }
}
