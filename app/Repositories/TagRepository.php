<?php

namespace App\Repositories;

class TagRepository
{
    // insert or update meta data
    public function processMetaData($payload, $request)
    {
        $data = [];
        $data['seo_title'] = isset( $request->seo_title ) ? $request->seo_title : NULL;
        $data['seo_description'] = isset( $request->seo_description ) ? $request->seo_description : NULL;
        // $data['featured_image'] = isset( $request->featured_image ) ? $request->featured_image : NULL;

        return $data;
    }
}
