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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->longText('content');
            $table->boolean('approved')->default(0); // Approval status (0 or 1)
            $table->string('type', 20)->default('comment');
            $table->bigInteger('comment_parent')->default(0);
            $table->string('comment_agent', 255)->nullable()->default(null); // User agent of the comment author
            $table->ipAddress('comment_ip')->nullable();
            $table->timestamps();

            $table->index(['post_id', 'comment_parent']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
