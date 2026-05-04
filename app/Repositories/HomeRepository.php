<?php

namespace App\Repositories;

class HomeRepository
{
    // insert or update meta data
    public function processMetaData($payload, $request)
    {
        $data = [];
        $data['number_of_news_to_show_in_banner'] = isset($request->number_of_news_to_show_in_banner) ? $request->number_of_news_to_show_in_banner : NULL;
        $data['category_id_left_second'] = isset($request->category_id_left_second) ? $request->category_id_left_second : NULL;
        $data['category_id_right_second'] = isset($request->category_id_right_second) ? $request->category_id_right_second : NULL;
        $data['category_id_third'] = isset($request->category_id_third) ? $request->category_id_third : NULL;
        $data['category_id_fourth'] = isset($request->category_id_fourth) ? $request->category_id_fourth : NULL;
        $data['category_id_fifth'] = isset($request->category_id_fifth) ? $request->category_id_fifth : NULL;
        $data['category_id_left_fifth'] = isset($request->category_id_left_fifth) ? $request->category_id_left_fifth : NULL;
        $data['category_id_middle_fifth'] = isset($request->category_id_middle_fifth) ? $request->category_id_middle_fifth : NULL;
        $data['category_id_right_fifth'] = isset($request->category_id_right_fifth) ? $request->category_id_right_fifth : NULL;
        $data['category_id_sixth'] = isset($request->category_id_sixth) ? $request->category_id_sixth : NULL;
        $data['category_id_seventh'] = isset($request->category_id_seventh) ? $request->category_id_seventh : NULL;

        return $data;
    }
}
