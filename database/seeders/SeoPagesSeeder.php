<?php

namespace Database\Seeders;

use App\Models\SeoPage;
use Illuminate\Database\Seeder;

class SeoPagesSeeder extends Seeder
{
    public function run(): void
    {
        $path = __DIR__.'/seo_pages_data.php';
        if (! is_file($path)) {
            return;
        }

        $rows = require $path;
        foreach ($rows as $row) {
            SeoPage::query()->updateOrCreate(
                ['slug' => $row['slug']],
                $row,
            );
        }
    }
}
