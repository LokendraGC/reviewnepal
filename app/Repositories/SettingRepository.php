<?php

namespace App\Repositories;

use App\Traits\ImageFieldTrait;

class SettingRepository
{
    use ImageFieldTrait;

    public function index($payload)
    {
        $data = $payload->pluck('setting_value', 'setting_name')->toArray();

        return $data;
    }

    public function storeOrUpdate($payload, $request)
    {
        $setting = $payload;

        $metaDatas = [];

        // header
        $metaDatas['header_logo'] = $request->header_logo ?? null;
        $metaDatas['header_logo_nepali'] = $request->header_logo_nepali ?? null;
        $metaDatas['map_url'] = $request->map_url ?? null;
        $metaDatas['office_timing'] = $request->office_timing ?? null;
        // Info Section
        $metaDatas['first_email'] = $request->first_email ?? null;
        $metaDatas['second_email'] = $request->second_email ?? null;
        $metaDatas['address'] = $request->address ?? null;
        $metaDatas['first_phone'] = $request->first_phone ?? null;
        $metaDatas['second_phone'] = $request->second_phone ?? null;

        // Footer
        $metaDatas['footer_logo'] = $request->footer_logo ?? null;
        $metaDatas['footer_logo_nepali'] = $request->footer_logo_nepali ?? null;
        $metaDatas['footer_text'] = $request->footer_text ?? null;
        $metaDatas['subscribe_text'] = $request->subscribe_text ?? null;
        $metaDatas['map_link'] = $request->map_link ?? null;
        // Social Medias
        $metaDatas['social_media'] = $request->social_media ? serialize($request->social_media) : null;

        // Banner Section
        $metaDatas['banner_background_image'] = $request->banner_background_image ?? null;
        $metaDatas['map_iframe_url'] = $request->map_iframe_url ?? null;


        // insert or update meta data
        foreach ($metaDatas as $key => $value) {
            $this->updateOrCreateMeta($setting, $key, $value);
        }
    }

    // update Or insert data
    private function updateOrCreateMeta($setting, $key, $value)
    {
        $setting->updateOrInsert(['setting_name' => $key], ['setting_value' => $value]);
    }
}