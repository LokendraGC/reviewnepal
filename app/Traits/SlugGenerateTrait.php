<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Models\Post;

trait SlugGenerateTrait
{
    // create newly post
    public function createSlug($name, $slug, $model)
    {
        // Convert the form-provided slug to lowercase and replace white spaces with hyphens
        $slug = Str::slug(strtolower($slug));

        // Check if the form-provided slug exists in the database
        // if (empty($slug) && !$model->where('slug', $slug)->exists()) {
        if ( empty($slug) ) {

            $slug = Str::slug($name);

            while ($model->where('slug', $slug)->exists()) {
                $slug = $this->generateUniqueSlugCreate($slug, $model);
            }
        }
        else {
            while ($model->where('slug', $slug)->exists()) {
                $slug = $this->generateUniqueSlugCreate($slug, $model);
            }
        }

        return $slug;
    }

    private function generateUniqueSlugCreate($originalSlug, $model)
    {
        // Split the original slug and its number suffix
        preg_match('/^(.*?)(?:-(\d+))?$/', $originalSlug, $matches);

        $baseSlug = $matches[1] ?? ''; // Extract base slug
        $suffix = isset($matches[2]) ? (int)$matches[2] : 1; // Extract the numeric suffix

        // Find the next available suffix
        $nextSuffix = $this->findNextSuffixCreate($baseSlug, $suffix, $model);

        // Generate the new slug
        return $baseSlug . '-' . $nextSuffix;
    }

    private function findNextSuffixCreate($baseSlug, $currentSuffix, $model)
    {
        $nextSuffix = $currentSuffix + 1;

        // Check if the next suffix is already taken
        while ($model->where('slug', $baseSlug . '-' . $nextSuffix)->exists()) {
            $nextSuffix++;
        }

        return $nextSuffix;
    }


    // edit existing posts
    public function getSlug($payload, $name, $slug)
    {
        $slug = Str::slug(strtolower($slug));

        // check if empty
        if ( empty( $slug ) ) {
            $slug = Str::slug(strtolower($name));
        }

        // check if slug was same
        if ( $slug == $payload->slug ) {
            return $slug;
        }

        // Check if the form-provided slug exists in the database
        if ( $payload::where('slug', $slug)->exists() ) {
            $slug = $this->generateUniqueSlug($slug, $payload);
        }

        return $slug;
    }

    private function generateUniqueSlug($originalSlug, $payload)
    {
        // Split the original slug and its number suffix
        preg_match('/^(.*?)(?:-(\d+))?$/', $originalSlug, $matches);

        $baseSlug = $matches[1] ?? ''; // Extract base slug
        $suffix = isset($matches[2]) ? (int)$matches[2] : 1; // Extract the numeric suffix

        // Find the next available suffix
        $nextSuffix = $this->findNextSuffix($baseSlug, $suffix, $payload);

        // Generate the new slug
        return $baseSlug . '-' . $nextSuffix;
    }

    private function findNextSuffix($baseSlug, $currentSuffix, $payload)
    {
        $nextSuffix = $currentSuffix + 1;

        // Check if the next suffix is already taken
        while ($payload::where('slug', $baseSlug . '-' . $nextSuffix)->exists()) {
            $nextSuffix++;
        }

        return $nextSuffix;
    }

}
