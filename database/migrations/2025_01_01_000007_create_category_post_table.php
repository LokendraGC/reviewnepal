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
        Schema::create('category_post', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('category_id');

            // Foreign key constraints
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            // Unique combination of post_id and category_id
            $table->unique(['post_id', 'category_id']);

            $table->index('post_id');  
            $table->index('category_id');

            $table->timestamps = false;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_post', function (Blueprint $table) {
            $table->dropIndex(['category_post_post_id_index']);
            $table->dropIndex(['category_post_category_id_index']);
            $table->dropUnique(['category_post_post_id_category_id_unique']);
        });
        
        Schema::dropIfExists('category_post');
    }
};
