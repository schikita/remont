<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const OLD_HEADLINES = [
        'Сантехника без сюрпризов: срок, цена и чистота',
        'Сантехника без сюрпризов: срок, цена и чистота — в договоре',
    ];

    private const string NEW_HEADLINE = 'Ремонт санузла под ключ в Минске — ванная, туалет, плитка';

    public function up(): void
    {
        DB::table('hero_sections')
            ->whereIn('headline', self::OLD_HEADLINES)
            ->update(['headline' => self::NEW_HEADLINE, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('hero_sections')
            ->where('headline', self::NEW_HEADLINE)
            ->update(['headline' => self::OLD_HEADLINES[0], 'updated_at' => now()]);
    }
};
