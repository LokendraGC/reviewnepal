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
        Schema::create('user_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('meta_key', 50);
            $table->text('meta_value')->nullable();
            $table->timestamps = false;

            $table->index('user_id');
            $table->index('meta_key');

            // Add unique constraint on user_id + meta_key
            $table->unique(['user_id', 'meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_metas', function (Blueprint $table) {
            $table->dropIndex(['user_metas_user_id_index']);
            $table->dropIndex(['user_metas_meta_key_index']);
        });
        
        Schema::dropIfExists('user_metas');
    }
};
