<?php

namespace App\Repositories;

use App\Models\Category;

class TeamRepository
{
    // insert or update meta data
    public function processMetaData($payload, $request)
    {
        $data = [];

        $data['featured_image'] = isset( $request->featured_image ) ? $request->featured_image : NULL;
        $data['designation'] = isset( $request->designation ) ? $request->designation : NULL;

        // add more meta data

        return $data;
    }
}
