<?php

namespace App\Http\Controllers;

use App\Models\PolicyPage;
use App\Models\SeoPage;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([
            url('/'),
        ]);

        $policies = PolicyPage::query()->where('is_published', true)->pluck('slug');
        foreach ($policies as $slug) {
            $urls->push(route('policy.show', ['slug' => $slug]));
        }

        $seoSlugs = SeoPage::query()->published()->orderBy('sort_order')->pluck('slug');
        foreach ($seoSlugs as $slug) {
            $urls->push(route('seo.page', ['slug' => $slug]));
        }

        $xml = view('sitemap-xml', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
