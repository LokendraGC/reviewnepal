<?php

namespace App\Repositories;

use App\Models\Category;

class AboutRepository
{
    // insert or update meta data
    public function processMetaData($payload, $request)
    {

        $data = [];
        // $data['about_title'] = isset($request->about_title) ? $request->about_title : NULL;

        return $data;
    }
}
