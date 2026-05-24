<?php

namespace App\Helpers;

use App\Models\Media;

class MediaHelper
{
    private static $cache = [];

    public static function getModel()
    {
        return new Media();
    }

    public static function getDescriptionById($id)
    {
        if (!$id) return null;
        $media = static::getImageById($id);
        return $media->description ?? null;
    }

    public static function getKBorMB($size)
    {
        $fileSize = $size;
        $formattedSize = NULL;

        if ( $size < 1048576 ) {
            $formattedSize = number_format($fileSize / 1024, 1) . ' KB';
        }
        else {
            $formattedSize = number_format($fileSize / 1048576, 1) . ' MB';
        }

        return $formattedSize;
    }

    public static function getImageById($id)
    {
        if (!$id) return null;
        if (!array_key_exists($id, static::$cache)) {
            static::$cache[$id] = Media::where('id', $id)->first();
        }
        return static::$cache[$id];
    }
}
