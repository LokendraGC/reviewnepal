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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('slug', 150)->unique();
            $table->string('type', 30);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent')->default(0);
            $table->unsignedBigInteger('parent_id_backup')->nullable();
            $table->unsignedBigInteger('menu_order')->default(0);
            $table->foreignId('last_updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // Indexing
            $table->index('name'); 
            $table->index('slug'); 
            $table->index('type'); 
            $table->index('parent');
            $table->index('menu_order');

            $table->index(['type', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['categories_name_index']);
            $table->dropIndex(['categories_slug_unique']);
            $table->dropIndex(['categories_type_index']);
            $table->dropIndex(['categories_parent_index']);
            $table->dropIndex(['categories_type_slug_index']);
        });

        Schema::dropIfExists('categories');
    }
};
