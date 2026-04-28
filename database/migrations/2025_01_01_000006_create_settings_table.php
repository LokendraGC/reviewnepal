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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_name', 100)->unique()->index();
            $table->mediumText('setting_value')->nullable();
            // Disable timestamps
            $table->timestamps = false;
        });

        // for homepage
        DB::table('settings')->insert([
            [
                'setting_name' => 'page_on_front',
                'setting_value' => 1,
            ],
            [
                'setting_name' => 'site_url',
                'setting_value' => 'http://127.0.0.1',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
