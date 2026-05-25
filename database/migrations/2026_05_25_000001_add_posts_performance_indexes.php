<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['post_type', 'post_status', 'created_at'], 'posts_type_status_created_idx');
        });

        Schema::table('post_metas', function (Blueprint $table) {
            $table->index(['meta_key', 'meta_value'], 'post_metas_key_value_idx');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('posts_type_status_created_idx');
        });

        Schema::table('post_metas', function (Blueprint $table) {
            $table->dropIndex('post_metas_key_value_idx');
        });
    }
};
