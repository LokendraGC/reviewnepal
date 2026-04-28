<?php

namespace App\Helpers;

use App\Helpers\SettingHelper;

class SeoHelper
{
    public static function seo_title($content = NULL)
    {
        if (empty($content)) return;

        // site name
        if (false !== strpos($content, '%sitename%')) {
            $site_name = SettingHelper::get_field('site_title');
            $content = str_replace('%sitename%', $site_name, $content);
        }

        // year
        if (false !== strpos($content, '%year%')) {
            $content = str_replace('%year%', date('Y'), $content);
        }

        // next year
        if (false !== strpos($content, '%nextyear%')) {
            $content = str_replace('%nextyear%', date('Y') + 1, $content);
        }

        return $content;
    }
}
