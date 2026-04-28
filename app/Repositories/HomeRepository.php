<?php

namespace App\Repositories;

use App\Models\Category;

class HomeRepository
{
    // insert or update meta data
    public function processMetaData($payload, $request)
    {
        // dd( $request->all() );
        $data = [];
        // $data['breaking_news_title'] = $request->breaking_news_title ?? null;
        // // $data['breaking_news_counter'] = $request->breaking_news_counter ?? 1;
        // $data['breaking_news_counter'] = max($request->breaking_news_counter ?? 1, 1);

        // $data['banner_news_counter'] = max($request->banner_news_counter ?? 1, 1);

        // $data['main_news_title'] = $request->main_news_title ?? null;
        // $data['poll_title'] = $request->poll_title ?? null;
        // $data['choose_poll'] = $request->choose_poll ?? null;

        // $data['choose_event'] = $request->choose_event ?? null;

        // $data['business_title'] = $request->business_title ?? null;
        // $data['choose_business'] = $request->choose_business ?? null;

        // $data['video_title'] = $request->video_title ?? null;

        // // two column with ads
        // $data['two_col_first_title'] = $request->two_col_first_title ?? null;
        // $data['two_col_first_category'] = $request->two_col_first_category ?? null;
        // $data['two_col_second_title'] = $request->two_col_second_title ?? null;
        // $data['two_col_second_category'] = $request->two_col_second_category ?? null;
        
        // // pradesh
        // $data['pradesh_title'] = $request->pradesh_title ?? null;

        // // three column
        // $data['three_col_first_title'] = $request->three_col_first_title ?? null;
        // $data['three_col_first_choose_category'] = $request->three_col_first_choose_category ?? null;

        // $data['three_col_second_title'] = $request->three_col_second_title ?? null;
        // $data['three_col_second_choose_category'] = $request->three_col_second_choose_category ?? null;

        // $data['three_col_third_title'] = $request->three_col_third_title ?? null;
        // $data['three_col_third_choose_category'] = $request->three_col_third_choose_category ?? null;
        
        // // entertainment
        // if (isset($request->entertainment_cats)) {
        //     $filteredSidebarContent = array_filter($request->entertainment_cats, function ($item) {
        //         return !(is_null($item['category']));
        //         // return !(is_null($item['title']) && is_null($item['category']));
        //     });
        //     $data['entertainment_cats'] = serialize($filteredSidebarContent);
        // } else {
        //     $data['entertainment_cats'] = null;
        // }        

        // add more meta data
        return $data;
    }
}
