<?php

namespace App\Repositories;

use App\Traits\ImageFieldTrait;

class AdsRepository
{
    use ImageFieldTrait;

    public function processMetaData($payload, $request)
    {
        $metaDatas = [];
        $metaDatas['header_ads'] = $request->header_ads ?? null;
        $metaDatas['banner_ads'] = $request->banner_ads ?? null;
        $metaDatas['below_recent_news'] = $request->below_recent_news ?? null;
        $metaDatas['above_nepal_insights_ad'] = $request->above_nepal_insights_ad ?? null;
        $metaDatas['below_nepal_insights_ad'] = $request->below_nepal_insights_ad ?? null;
        $metaDatas['below_trending_news_first_ad'] = $request->below_trending_news_first_ad ?? null;
        $metaDatas['below_trending_news_second_ad'] = $request->below_trending_news_second_ad ?? null;
        $metaDatas['above_brands_ad'] = $request->above_brands_ad ?? null;
        $metaDatas['second_last_homepage_ads'] = $request->second_last_homepage_ads ?? null;
        $metaDatas['homepage_below_trending_news_first_ad'] = $request->homepage_below_trending_news_first_ad ?? null;
        $metaDatas['homepage_below_trending_news_second_ad'] = $request->homepage_below_trending_news_second_ad ?? null;
        $metaDatas['single_news_below_trending_news_first_ad'] = $request->single_news_below_trending_news_first_ad ?? null;
        $metaDatas['single_news_below_trending_news_second_ad'] = $request->single_news_below_trending_news_second_ad ?? null;
        $metaDatas['above_article_second'] = $request->above_article_second ?? null;
        $metaDatas['above_articles_second_col_sec_row'] = $request->above_articles_second_col_sec_row ?? null;
        $metaDatas['above_articles_ad'] = $request->above_articles_ad ?? null;
        $metaDatas['single_above_title'] = $request->single_above_title ?? null;
        $metaDatas['single_below_title'] = $request->single_below_title ?? null;
        $metaDatas['single_below_content'] = $request->single_below_content ?? null;
        $metaDatas['below_featured_image_ad'] = $request->below_featured_image_ad ?? null;

        // insert or update meta data
        foreach ($metaDatas as $key => $value) {
            $this->updateOrCreateMeta($payload, $key, $value);
        }
    }

    // update Or insert data
    private function updateOrCreateMeta($setting, $key, $value)
    {
        $setting->updateOrInsert(['setting_name' => $key], ['setting_value' => $value]);
    }

    public function index($payload)
    {
        $data = $payload->pluck('setting_value', 'setting_name')->toArray();

        return $data;
    }
}