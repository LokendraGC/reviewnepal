<?php

namespace App\Repositories;

use App\Models\Category;

class ContactUsRepository
{
    // insert or update meta data
    public function processMetaData($payload, $request)
    {

        $data = [];
        // $data['contact_title'] = isset($request->contact_title) ? $request->contact_title : NULL;

        return $data;
    }
}
