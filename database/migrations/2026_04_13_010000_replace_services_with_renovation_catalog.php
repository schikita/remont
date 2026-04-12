<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $path = database_path('seeders/data/renovation_services.php');
        if (! is_file($path)) {
            return;
        }

        $services = require $path;

        DB::table('quiz_results')->update(['recommended_service_id' => null]);
        DB::table('services')->delete();

        $now = now();
        foreach ($services as $sort => $row) {
            $insert = [
                'name' => $row['name'],
                'slug' => $row['slug'],
                'short_description' => $row['short_description'],
                'price_from' => $row['price_from'],
                'icon' => $row['icon'],
                'image_path' => null,
                'cta_label' => $row['cta_label'],
                'sort_order' => $sort,
                'is_published' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            if (Schema::hasColumn('services', 'seo_page_slug')) {
                $insert['seo_page_slug'] = $row['seo_page_slug'];
            }
            DB::table('services')->insert($insert);
        }

        $serviceId = function (string $slug): mixed {
            return DB::table('services')->where('slug', $slug)->value('id');
        };

        $byTitle = [
            'Ремонт санузла под ключ' => 'remont-sanuzla-pod-klyuch',
            'Плиточные работы под ключ' => 'plitochnye-raboty',
            'Выезд плиточника и консультация' => 'srochnyj-vyezd',
        ];
        foreach ($byTitle as $title => $slug) {
            $sid = $serviceId($slug);
            if ($sid) {
                DB::table('quiz_results')->where('title', $title)->update([
                    'recommended_service_id' => $sid,
                    'updated_at' => $now,
                ]);
            }
        }

        $fallbackSlugs = ['remont-sanuzla-pod-klyuch', 'plitochnye-raboty', 'srochnyj-vyezd'];
        $nullRows = DB::table('quiz_results')
            ->whereNull('recommended_service_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        foreach ($nullRows as $idx => $qr) {
            if ($idx >= 3) {
                break;
            }
            $slug = $fallbackSlugs[$idx];
            $sid = $serviceId($slug);
            if ($sid) {
                DB::table('quiz_results')->where('id', $qr->id)->update([
                    'recommended_service_id' => $sid,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Старый каталог сантехника не восстанавливаем.
    }
};
