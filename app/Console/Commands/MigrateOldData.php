<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Signature('app:migrate-old-data')]
#[Description('Migrate old categories to new database')]
class MigrateOldData extends Command
{
    public function handle(): int
    {
        try {

            // Get first available user (owner)
            $userId = User::query()->orderBy('id')->value('id');

            if (!$userId) {
                $this->error('No users found. Please create a user first.');
                return self::FAILURE;
            }

            $this->info('Starting category migration...');

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
                                ['id' => $row->id], // keep old ID (optional but you asked similar behavior)
                                [
                                    'user_id' => $userId, // current system user
                                    'name' => Str::limit($row->category_title, 100),
                                    'slug' => Str::limit($slug, 150),
                                    'type' => 'category',
                                    'description' => $row->page_description,
                                ]
                            );

                        } catch (\Exception $e) {
                            $this->error("Failed category ID {$row->id}: " . $e->getMessage());
                        }
                    }
                });

            $this->info('Categories migrated successfully.');

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Migration failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}