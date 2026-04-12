<?php

namespace App\Http\Controllers;

use App\Models\PolicyPage;
use App\Models\SiteSetting;
use App\Services\SeoService;
use App\Services\ScriptSettingsRenderer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PolicyPageController extends Controller
{
    public function __construct(
        private readonly SeoService $seo,
        private readonly ScriptSettingsRenderer $scripts,
    ) {}

    public function show(Request $request, string $slug): View
    {
        $page = PolicyPage::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $baseSeo = $this->seo->forHome();

        $seo = [
            ...$baseSeo,
            'title' => $page->title.' — '.$baseSeo['title'],
            'description' => str($page->content)->stripTags()->limit(160)->toString(),
            'canonical' => url()->current(),
            'robots' => 'index,follow',
        ];

        return view('policy', [
            'page' => $page,
            'seo' => $seo,
            'scripts' => $this->scripts,
            'site' => SiteSetting::current(),
            'jsonLd' => '{}',
        ]);
    }
}
