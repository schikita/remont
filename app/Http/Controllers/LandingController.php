<?php

namespace App\Http\Controllers;

use App\Services\JsonLdService;
use App\Services\LandingPageService;
use App\Services\ScriptSettingsRenderer;
use App\Services\SeoService;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __construct(
        private readonly LandingPageService $landing,
        private readonly SeoService $seo,
        private readonly JsonLdService $jsonLd,
        private readonly ScriptSettingsRenderer $scripts,
    ) {}

    public function index(): View
    {
        $payload = $this->landing->payload();
        $seo = $this->seo->forHome();

        $jsonLd = $this->jsonLd->toScriptString(
            $payload['services'],
            $payload['faq'],
            $payload['reviews'],
        );

        return view('landing', [
            'seo' => $seo,
            'jsonLd' => $jsonLd,
            'scripts' => $this->scripts,
            'quizClient' => $this->landing->quizForClient(),
            ...$payload,
        ]);
    }
}
