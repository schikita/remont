<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Проставляет seo_page_slug и cta_label по каталогу renovation_services.php.
 * Запуск: php artisan db:seed --class=SyncServiceSeoSlugsSeeder
 */
class SyncServiceSeoSlugsSeeder extends Seeder
{
    public function run(): void
    {
        $path = __DIR__.'/data/renovation_services.php';
        if (! is_file($path)) {
            return;
        }

        $rows = require $path;
        foreach ($rows as $row) {
            Service::query()->where('slug', $row['slug'])->update([
                'seo_page_slug' => $row['seo_page_slug'],
                'cta_label' => $row['cta_label'],
            ]);
        }
    }
}
