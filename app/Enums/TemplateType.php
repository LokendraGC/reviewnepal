<?php

namespace App\Enums;

class TemplateType
{
    const DEFAULT = 'default';
    const HOME = 'home';
    const ABOUT = 'about';
    const CONTACT_US = 'contact_us';
    const THANK_YOU = 'thank_you';

    public static function toArray()
    {
        return [
            self::DEFAULT,
            self::HOME,
            self::ABOUT,
            self::CONTACT_US,
            self::THANK_YOU,
        ];
    }

    // for separate displaying text and value
    public static function getKeyValuePairs()
    {
        $keyValuePairs = [];

        $keyValuePairs['Default'] = self::DEFAULT;
        $keyValuePairs['Home'] = self::HOME;
        $keyValuePairs['About'] = self::ABOUT;
        $keyValuePairs['Contact Us'] = self::CONTACT_US;
        $keyValuePairs['Thank You'] = self::THANK_YOU;
        // Extract 'Default' and sort the remaining keys
        $defaultValue = ['Default' => $keyValuePairs['Default']];
        unset($keyValuePairs['Default']);

        ksort($keyValuePairs); // Sort remaining keys

        // Merge 'Default' at the beginning
        return $defaultValue + $keyValuePairs;
    }

    // if (!in_array($type, TemplateType::toArray())) {
    //     abort(404);
    // }
}
