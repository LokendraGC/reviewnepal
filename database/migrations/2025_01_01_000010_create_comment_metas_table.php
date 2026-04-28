<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comment_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id')->constrained('comments')->onDelete('cascade');
            $table->string('meta_key', 50);
            $table->text('meta_value')->nullable();
            $table->timestamps = false;

            $table->unique(['comment_id', 'meta_key']);
            $table->index(['comment_id', 'meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comment_metas', function (Blueprint $table) {
            $table->dropIndex(['comment_metas_comment_id_meta_key_index']);
            $table->dropUnique(['comment_metas_comment_id_meta_key_unique']);
        });
        
        Schema::dropIfExists('comment_metas');
    }
};
