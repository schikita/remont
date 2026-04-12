<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->string('background_image_path')->nullable()->after('show_lead_form');
            $table->string('gradient_preset')->nullable()->after('background_image_path');
        });

        Schema::table('section_settings', function (Blueprint $table) {
            $table->string('gradient_preset')->nullable()->after('sort_order');
        });

        DB::table('section_settings')->where('section_key', 'gallery')->whereNull('gradient_preset')->update([
            'gradient_preset' => 'brand_soft',
            'updated_at' => now(),
        ]);
        DB::table('section_settings')->where('section_key', 'quiz')->whereNull('gradient_preset')->update([
            'gradient_preset' => 'quiz_panel',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->dropColumn(['background_image_path', 'gradient_preset']);
        });

        Schema::table('section_settings', function (Blueprint $table) {
            $table->dropColumn('gradient_preset');
        });
    }
};
