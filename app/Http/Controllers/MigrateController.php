<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostMeta;
use App\Models\Media;

class MigrateController extends Controller
{
    public function migrateCategory()
    {
        $userId = User::query()->orderBy('id')->value('id');

        if (!$userId) {
            return redirect()->back()->with('error', 'No users found. Please create a user first.');
        }

        DB::connection('mysql_old')
            ->table('tblnews_category')
            ->select('id', 'category_title', 'category_nicename', 'page_description')
            ->orderBy('id')
            ->chunk(500, function ($rows) use ($userId) {
                foreach ($rows as $row) {
                    try {
                        $slug = !empty($row->category_nicename)
                            ? $row->category_nicename
                            : Str::slug($row->category_title);

                        Category::updateOrCreate(
                            ['id' => $row->id], // keep old category id
                            [
                                'user_id' => 2,
                                'name' => Str::limit($row->category_title, 100),
                                'slug' => Str::limit($slug, 150),
                                'type' => 'category',
                                'description' => $row->page_description,
                            ]
                        );
                    } catch (\Throwable) {
                        // skip broken row; continue migrating
                    }
                }
            });

        return redirect()->back()->with('success', 'Categories migrated successfully.');
    }

    public function migratePost()
    {
        $userId = User::query()->orderBy('id')->value('id');

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'No users found. Please create a user first.'], 422);
        }

        $migrated = 0;
        $skipped = 0;

   DB::connection('mysql_old')
            ->table('tblstories')
            ->select('id', 'title','author','date','description','news_category','short_description', 'imagename', 'page_title', 'page_description', 'page_keywords')
            ->orderBy('id')
            // ->limit(2) // test with 1 post
            // ->get();
            ->chunk(200, function ($rows) use ($userId, &$migrated, &$skipped) {
                foreach ($rows as $row) {
                    try {
                        DB::transaction(function () use ($row, $userId, &$migrated) {
                            $legacyDateRaw = trim((string) ($row->date ?? ''));
                            $postTimestamp = now();

                            if ($legacyDateRaw !== '' && $legacyDateRaw !== '0000-00-00 00:00:00' && $legacyDateRaw !== '0000-00-00') {
                                try {
                                    $postTimestamp = Carbon::parse($legacyDateRaw);
                                } catch (\Throwable) {
                                    // Fallback for common legacy formats when parse() fails
                                    foreach (['Y-m-d H:i:s', 'Y-m-d', 'd-m-Y H:i:s', 'd-m-Y', 'm/d/Y H:i:s', 'm/d/Y'] as $format) {
                                        try {
                                            $postTimestamp = Carbon::createFromFormat($format, $legacyDateRaw);
                                            break;
                                        } catch (\Throwable) {
                                        }
                                    }
                                }
                            }

                            $baseSlug = Str::slug((string) $row->title);
                            $slug = $baseSlug ?: ('post-' . $row->id);

                            // ensure uniqueness against existing posts
                            if (Post::query()->where('slug', $slug)->exists()) {
                                $slug = Str::limit($slug . '-' . $row->id, 200, '');
                            } else {
                                $slug = Str::limit($slug, 200, '');
                            }

                            $postContent = (string) ($row->description ?? '');
                            $postContent = preg_replace(
                                '/^(?:(?:\x{00A0}|&nbsp;|\s)+|<br\s*\/?>|<div>\s*(?:\x{00A0}|&nbsp;|\s|<br\s*\/?>)*<\/div>)+/iu',
                                '',
                                $postContent
                            ) ?? $postContent;

                            $post = new Post();
                            $post->user_id = 2;
                            $post->post_title = (string) $row->title;
                            $post->slug = $slug;
                            $post->post_content = $postContent;
                            $post->post_excerpt = $row->short_description;
                            $post->post_status = 'publish';
                            $post->post_parent = 0;
                            $post->post_type = 'post';
                            $post->comment_status = 'open';
                            $post->menu_order = 0;
                            $post->post_password = null;
                            $post->last_updated_by = $userId;
                            $post->created_at = $postTimestamp;
                            $post->updated_at = $postTimestamp;
                            $post->save();

                            $metas = [];

                            // featured image: old db stores filename (e.g. super_moon.jpg)
                            $imageName = trim((string) ($row->imagename ?? ''));
                            if ($imageName !== '') {
                                $media = Media::query()->firstOrCreate(
                                    ['file_name' => 'uploads/2026/05/' . $imageName],
                                    [
                                        'user_id' => $userId,
                                        'file_original_name' => $imageName,
                                        'file_size' => 0,
                                        'extension' => strtolower(pathinfo($imageName, PATHINFO_EXTENSION) ?: ''),
                                        'type' => 'image',
                                        'alt' => null,
                                        'caption' => null,
                                        'description' => null,
                                        'metadata' => null,
                                    ]
                                );

                                $metas['featured_image'] = (string) $media->id;
                            }

                            // SEO mapping requested:
                            // old: page_title, page_description, page_keywords
                            // new: seo_title, seo_description, and keywords in post_metas
                            if (!empty($row->page_title)) {
                                $metas['seo_title'] = (string) $row->page_title;
                            }
                            if (!empty($row->page_description)) {
                                $metas['seo_description'] = (string) $row->page_description;
                            }
                            if (!empty($row->page_keywords)) {
                                $metas['page_keywords'] = (string) $row->page_keywords;
                            }

                            if (!empty($metas)) {
                                $rowsToInsert = [];
                                foreach ($metas as $key => $value) {
                                    $rowsToInsert[] = [
                                        'post_id' => $post->id,
                                        'meta_key' => $key,
                                        'meta_value' => $value,
                                    ];
                                }
                                PostMeta::query()->insert($rowsToInsert);
                            }

                            // Map old news_category slug(s) to new category IDs and sync pivot table
                            $newsCategoryRaw = trim((string) ($row->news_category ?? ''));
                            if ($newsCategoryRaw !== '') {
                                // Support single or comma-separated slugs
                                $slugs = array_filter(array_map('trim', explode(',', $newsCategoryRaw)));

                                if (!empty($slugs)) {
                                    $categoryIds = Category::query()
                                        ->whereIn('slug', $slugs)
                                        ->pluck('id')
                                        ->all();

                                    if (!empty($categoryIds)) {
                                        $pivotRows = [];
                                        foreach ($categoryIds as $categoryId) {
                                            $pivotRows[] = [
                                                'post_id' => $post->id,
                                                'category_id' => $categoryId,
                                            ];
                                        }

                                        // Avoid duplicate pivot rows if migration is re-run
                                        DB::table('category_post')->insertOrIgnore($pivotRows);
                                    }
                                }
                            }

                            // Map old author(s) to author categories and sync pivot table
                            $authorRaw = trim((string) ($row->author ?? ''));
                            if ($authorRaw !== '') {
                                $authors = array_filter(array_map('trim', explode(',', $authorRaw)));

                                foreach ($authors as $authorName) {
                                    $baseSlug = Str::slug($authorName);
                                    $authorSlug = $baseSlug !== '' ? $baseSlug : ('author-' . $row->id);

                                    $authorCategory = Category::query()
                                        ->where('slug', $authorSlug)
                                        ->where('type', 'author')
                                        ->first();

                                    if (!$authorCategory) {
                                        $existingSlugCategory = Category::query()
                                            ->where('slug', $authorSlug)
                                            ->first();

                                        if ($existingSlugCategory && $existingSlugCategory->type !== 'author') {
                                            $authorSlug = Str::limit($authorSlug . '-author', 150, '');
                                        } else {
                                            $authorSlug = Str::limit($authorSlug, 150, '');
                                        }

                                        $authorCategory = Category::query()->firstOrCreate(
                                            ['slug' => $authorSlug],
                                            [
                                                'user_id' => $userId,
                                                'name' => Str::limit($authorName, 100),
                                                'type' => 'author',
                                                'description' => null,
                                            ]
                                        );
                                    }

                                    DB::table('category_post')->insertOrIgnore([
                                        'post_id' => $post->id,
                                        'category_id' => $authorCategory->id,
                                    ]);
                                }
                            }

                            $migrated++;
                        }, 3);
                    } catch (\Throwable) {
                        $skipped++;
                    }
                }
            });

        return response()->json([
            'success' => true,
            'message' => 'Posts migrated successfully.',
            'migrated' => $migrated,
            'skipped' => $skipped,
        ]);
    }

    public function migrateUser()
    {
        $users = DB::connection('mysql_old')->table('users')->get();
        return $users;
    }
}
