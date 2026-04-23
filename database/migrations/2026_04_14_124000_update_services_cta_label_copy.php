<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('services')
            ->where('cta_label', 'О услуге')
            ->update(['cta_label' => 'Подробнее', 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('services')
            ->where('cta_label', 'Подробнее')
            ->update(['cta_label' => 'О услуге', 'updated_at' => now()]);
    }
};
