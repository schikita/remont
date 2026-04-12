<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const NEW_SITE_NAME = 'АкваПро — ремонт санузлов под ключ · Минск';

    private const OLD_SITE_NAMES = [
        'АкваПро — сантехника',
        'АкваПро - сантехника',
        'АкваПро — ремонт санузлов и плитка',
        'АкваПро — ремонт санузлов под ключ',
    ];

    public function up(): void
    {
        DB::table('site_settings')
            ->whereIn('site_name', self::OLD_SITE_NAMES)
            ->update(['site_name' => self::NEW_SITE_NAME, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('site_settings')
            ->where('site_name', self::NEW_SITE_NAME)
            ->update(['site_name' => 'АкваПро — сантехника', 'updated_at' => now()]);
    }
};
