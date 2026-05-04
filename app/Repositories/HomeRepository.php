<?php

namespace App\Repositories;

class HomeRepository
{
    // insert or update meta data
    public function processMetaData($payload, $request)
    {
        $data = [];
        $data['number_of_news_to_show_in_banner'] = isset($request->number_of_news_to_show_in_banner) ? $request->number_of_news_to_show_in_banner : NULL;
        $data['category_id_left'] = isset($request->category_id_left) ? $request->category_id_left : NULL;
        $data['category_id_right'] = isset($request->category_id_right) ? $request->category_id_right : NULL;
        $data['category_id_third'] = isset($request->category_id_third) ? $request->category_id_third : NULL;
        $data['category_id_fourth'] = isset($request->category_id_fourth) ? $request->category_id_fourth : NULL;
        
        return $data;
    }
}
