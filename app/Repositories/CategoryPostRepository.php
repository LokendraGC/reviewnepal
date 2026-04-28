<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Category;


class CategoryPostRepository
{
    public function assignCategory($payload, $ids)
    {
        if (!$payload instanceof Post) {
            throw new \InvalidArgumentException('$payload must be an instance of Post');
        }

        $existingCategoryIds = Category::whereIn('id', $ids)->pluck('id')->toArray();

        if ( $payload->exists() ) {

            $payload->categories()->sync($existingCategoryIds);
        }
        else {

            $payload->categories()->attach($existingCategoryIds);
        }

        return true;
    }

    public function createCustomCategory($type, array $cats): array
    {
        $ids = [];

        foreach ($cats as $cat) {

            if ( is_numeric($cat) ) {

                $ids[] = (int) $cat;

            } else {

                $existing = Category::where('name', $cat)->where('type', $type)->first();

                if ($existing) {

                    $ids[] = $existing->id;

                } else {

                    $new = Category::create([
                        'name' => ucfirst(trim($cat)),
                        'slug' => \Str::slug($cat),
                        'type' => $type,
                    ]);

                    $ids[] = $new->id;
                }
            }
        }
        return $ids;
    }
}
