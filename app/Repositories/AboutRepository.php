<?php

namespace App\Repositories;

use App\Models\Category;

class AboutRepository
{
    // insert or update meta data
    public function processMetaData($payload, $request)
    {

        $data = [];
        $data['established_title'] = isset($request->established_title) ? $request->established_title : NULL;
        $data['established_date'] = isset($request->established_date) ? $request->established_date : NULL;
        $data['about_first_image'] = isset($request->about_first_image) ? $request->about_first_image : NULL;
        $data['about_second_image'] = isset($request->about_second_image) ? $request->about_second_image : NULL;
        $data['mission_and_vision_details'] = isset($request->mission_and_vision_details) ? serialize($request->mission_and_vision_details) : NULL;
        $data['commitment_bg_image'] = isset($request->commitment_bg_image) ? $request->commitment_bg_image : NULL;
        $data['commitment_description'] = isset($request->commitment_description) ? $request->commitment_description : NULL;
        $data['team_title'] = isset($request->team_title) ? $request->team_title : NULL;
        $data['team_details'] = isset($request->team_details) ? serialize($request->team_details) : NULL;
        $data['faq_title'] = isset($request->faq_title) ? $request->faq_title : NULL;
        $data['faq_featured_image'] = isset($request->faq_featured_image) ? $request->faq_featured_image : NULL;
        $data['faq_details'] = isset($request->faq_details) ? serialize($request->faq_details) : NULL;


        return $data;
    }
}
