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
        $data['category_id_left_fifth'] = isset($request->category_id_left_fifth) ? $request->category_id_left_fifth : NULL;
        $data['category_id_middle_fifth'] = isset($request->category_id_middle_fifth) ? $request->category_id_middle_fifth : NULL;
        $data['category_id_right_fifth'] = isset($request->category_id_right_fifth) ? $request->category_id_right_fifth : NULL;
        $data['category_id_sixth'] = isset($request->category_id_sixth) ? $request->category_id_sixth : NULL;
        $data['category_id_seventh'] = isset($request->category_id_seventh) ? $request->category_id_seventh : NULL;

        $data['main_title_third'] = isset($request->main_title_third) ? $request->main_title_third : NULL;
        $data['main_title_nepali_third'] = isset($request->main_title_nepali_third) ? $request->main_title_nepali_third : NULL;

        $data['main_title_fourth'] = isset($request->main_title_fourth) ? $request->main_title_fourth : NULL;
        $data['main_title_nepali_fourth'] = isset($request->main_title_nepali_fourth) ? $request->main_title_nepali_fourth : NULL;

        return $data;
    }
}
