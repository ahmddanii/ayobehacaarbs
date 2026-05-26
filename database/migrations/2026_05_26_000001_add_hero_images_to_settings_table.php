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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('category_hero_image')->nullable()->after('site_name');
            $table->string('article_hero_image')->nullable()->after('category_hero_image');
            $table->string('about_hero_image')->nullable()->after('article_hero_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['category_hero_image', 'article_hero_image', 'about_hero_image']);
        });
    }
};
