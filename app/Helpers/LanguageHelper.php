<?php

namespace App\Helpers;

class LanguageHelper
{
    /**
     * Active UI language: session preference if valid, else site setting, else app locale.
     * Session is per visitor only; shared links do not copy session—recipients use the same fallbacks.
     */
    public static function getUserLanguage(): string
    {
        $fromSession = session('lang');
        if (in_array($fromSession, ['en', 'ne'], true)) {
            return $fromSession;
        }

        $fromSettings = SettingHelper::get_field('language');
        if (in_array($fromSettings, ['en', 'ne'], true)) {
            return $fromSettings;
        }

        return config('app.locale', 'en');
    }
}