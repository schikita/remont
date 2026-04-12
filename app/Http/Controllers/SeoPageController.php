<?php

namespace App\Http\Controllers;

use App\Models\ContactSetting;
use App\Models\SeoPage;
use App\Models\SiteSetting;
use App\Services\JsonLdService;
use App\Services\ScriptSettingsRenderer;
use App\Services\SeoService;
use Illuminate\View\View;

class SeoPageController extends Controller
{
    public function __construct(
        private readonly SeoService $seo,
        private readonly JsonLdService $jsonLd,
        private readonly ScriptSettingsRenderer $scripts,
    ) {}

    public function show(string $slug): View
    {
        $page = SeoPage::query()->published()->where('slug', $slug)->firstOrFail();

        return view('seo.page', [
            'page' => $page,
            'seo' => $this->seo->forSeoPage($page),
            'jsonLd' => $this->jsonLd->toScriptStringForSeoPage($page),
            'scripts' => $this->scripts,
            'site' => SiteSetting::current(),
            'contact' => ContactSetting::current(),
        ]);
    }
}
