<?php

namespace App\Repositories;

class HomeRepository
{
    // insert or update meta data
    public function processMetaData($payload, $request)
    {
        $data = [];
        $data['number_of_news_to_show_in_banner'] = isset($request->number_of_news_to_show_in_banner) ? $request->number_of_news_to_show_in_banner : NULL;
        $data['news_n_feature_cat'] = isset($request->news_n_feature_cat) ? $request->news_n_feature_cat : NULL;
        $data['sports_cat'] = isset($request->sports_cat) ? $request->sports_cat : NULL;
        $data['views_n_opinion_cat'] = isset($request->views_n_opinion_cat) ? $request->views_n_opinion_cat : NULL;
        $data['lifestyle_ent_cat'] = isset($request->lifestyle_ent_cat) ? $request->lifestyle_ent_cat : NULL;
        $data['art_cult_lit_cat'] = isset($request->art_cult_lit_cat) ? $request->art_cult_lit_cat : NULL;
        $data['sci_tech_cat'] = isset($request->sci_tech_cat) ? $request->sci_tech_cat : NULL;
        $data['business_brands_cat'] = isset($request->business_brands_cat) ? $request->business_brands_cat : NULL;
        $data['tender_notices_cat'] = isset($request->tender_notices_cat) ? $request->tender_notices_cat : NULL;

        // latest news repeater
        $data['latest_news_details'] = isset($request->latest_news_details) ? serialize($request->latest_news_details) : NULL;
        $data['latest_news_details_ne'] = isset($request->latest_news_details_ne) ? serialize($request->latest_news_details_ne) : NULL;

        $data['main_title_third'] = isset($request->main_title_third) ? $request->main_title_third : NULL;
        $data['main_title_nepali_third'] = isset($request->main_title_nepali_third) ? $request->main_title_nepali_third : NULL;

        $data['main_title_fourth'] = isset($request->main_title_fourth) ? $request->main_title_fourth : NULL;
        $data['main_title_nepali_fourth'] = isset($request->main_title_nepali_fourth) ? $request->main_title_nepali_fourth : NULL;


        return $data;
    }
}
