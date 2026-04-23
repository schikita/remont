<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const NEW_TITLE = 'Ремонт ванной и санузла под ключ — быстро, качественно недорого';

    private const OLD_TITLES = [
        'Ремонт ванной и санузла под ключ — без сюрпризов по цене',
    ];

    public function up(): void
    {
        DB::table('about_sections')
            ->whereIn('title', self::OLD_TITLES)
            ->update(['title' => self::NEW_TITLE, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('about_sections')
            ->where('title', self::NEW_TITLE)
            ->update(['title' => self::OLD_TITLES[0], 'updated_at' => now()]);
    }
};
