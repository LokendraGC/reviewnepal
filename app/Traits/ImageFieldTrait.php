<?php

namespace App\Traits;

use App\Models\Media;

trait ImageFieldTrait
{
    public function setImage($request)
    {
        if ( $request ) {
            return $request->store('', 'public');
        }
        else {
            return NULL;
        }
    }

    public function getImage($id)
    {
        $idArray = explode(',', $id);

        $media = Media::whereIn('id', $idArray)->get();

        if ( $media->isNotEmpty() ) {

            return serialize($media->toArray());

        } else {
            return NULL;
        }
    }

}
