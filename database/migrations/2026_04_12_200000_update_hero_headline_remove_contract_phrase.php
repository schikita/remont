<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const string OLD = 'Сантехника без сюрпризов: срок, цена и чистота — в договоре';

    private const string NEW = 'Сантехника без сюрпризов: срок, цена и чистота';

    public function up(): void
    {
        DB::table('hero_sections')
            ->where('headline', self::OLD)
            ->update(['headline' => self::NEW, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('hero_sections')
            ->where('headline', self::NEW)
            ->update(['headline' => self::OLD, 'updated_at' => now()]);
    }
};
