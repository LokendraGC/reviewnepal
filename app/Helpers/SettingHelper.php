<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{

    private static $cache = [];
    private static $loaded = false;

    private static function loadAll(): void
    {
        if (static::$loaded) {
            return;
        }

        static::$cache = Cache::rememberForever('settings_all', function () {
            return Setting::pluck('setting_value', 'setting_name')->toArray();
        });

        static::$loaded = true;
    }

    public static function getModel()
    {
        return new Setting();
    }

    public static function get_field($selector)
    {
        static::loadAll();
        return static::$cache[trim($selector)] ?? null;
    }

    public static function get_home_id()
    {
        static::loadAll();
        return static::$cache['page_on_front'] ?? null;
    }

    public static function get_select_key_value($selector)
    {
        static::loadAll();
        $fieldName = trim($selector);

        $data = static::$cache[$fieldName] ?? null;

        if (!$data) { return []; }

        $key_value_pairs = [];
        $lines = preg_split('/\r\n|\r|\n/', $data);

        foreach ($lines as $line) {
            [$key, $value] = array_map('trim', explode(':', $line, 2));
            $key_value_pairs[$key] = $value;
        }

        return $key_value_pairs;
    }
}
