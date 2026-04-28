<?php

namespace App\Helpers;

use App\Models\Media;

class MediaHelper
{
    public static function getModel()
    {
        return new Media();
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
        $image = Media::where('id', $id)->first();
        return $image ?? null;
    }
}
