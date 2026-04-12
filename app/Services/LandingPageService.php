<?php

namespace App\Services;

use App\Models\AboutSection;
use App\Models\Advantage;
use App\Models\ContactSetting;
use App\Models\FaqItem;
use App\Models\GalleryItem;
use App\Models\HeroSection;
use App\Models\QuizQuestion;
use App\Models\Review;
use App\Models\SectionSetting;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\WorkStep;
use App\Support\SectionKey;
use Illuminate\Support\Collection;

class LandingPageService
{
    public function payload(): array
    {
        $sections = $this->orderedSections();

        return [
            'sections' => $sections,
            'sectionSettingsByKey' => SectionSetting::query()->orderBy('sort_order')->get()->keyBy('section_key'),
            'site' => SiteSetting::current(),
            'contact' => ContactSetting::current(),
            'hero' => HeroSection::current(),
            'services' => Service::query()->where('is_published', true)->orderBy('sort_order')->get(),
            'advantages' => Advantage::query()->where('is_published', true)->orderBy('sort_order')->get(),
            'workSteps' => WorkStep::query()->where('is_published', true)->orderBy('sort_order')->get(),
            'gallery' => GalleryItem::query()->where('is_published', true)->orderBy('sort_order')->get(),
            'reviews' => Review::query()->where('is_published', true)->orderBy('sort_order')->get(),
            'faq' => FaqItem::query()->where('is_published', true)->orderBy('sort_order')->get(),
            'about' => AboutSection::current(),
            'socialLinks' => SocialLink::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'quiz' => $this->quizPayload(),
        ];
    }

    /**
     * @return list<string> enabled section keys in display order
     */
    public function orderedSections(): array
    {
        $rows = SectionSetting::query()->orderBy('sort_order')->get()->keyBy('section_key');
        $ordered = [];

        foreach (SectionKey::ordered() as $key) {
            $row = $rows->get($key);
            if ($row && ! $row->is_enabled) {
                continue;
            }
            $ordered[] = $key;
        }

        return $ordered;
    }

    public function sectionEnabled(string $key): bool
    {
        $row = SectionSetting::query()->where('section_key', $key)->first();

        return $row === null || $row->is_enabled;
    }

    private function quizPayload(): array
    {
        $questions = QuizQuestion::query()
            ->where('is_published', true)
            ->with(['options' => fn ($q) => $q->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        $results = \App\Models\QuizResult::query()
            ->where('is_published', true)
            ->with('recommendedService:id,name,slug')
            ->orderBy('sort_order')
            ->get(['id', 'title', 'description', 'min_score', 'max_score', 'recommended_service_id']);

        return [
            'questions' => $questions,
            'results' => $results,
        ];
    }

    /**
     * @return array{questions: mixed, results: mixed}
     */
    public function quizForClient(): array
    {
        $quiz = $this->quizPayload();

        return [
            'questions' => $quiz['questions']->map(fn ($q) => [
                'id' => $q->id,
                'question' => $q->question,
                'options' => $q->options->map(fn ($o) => [
                    'id' => $o->id,
                    'label' => $o->label,
                    'weight' => $o->weight,
                ])->values(),
            ])->values(),
            'results' => $quiz['results']->map(fn ($r) => [
                'min_score' => $r->min_score,
                'max_score' => $r->max_score,
                'title' => $r->title,
                'description' => $r->description,
                'service' => $r->recommendedService?->only(['id', 'name', 'slug']),
            ])->values(),
        ];
    }

    /**
     * @return Collection<int, Service>
     */
    public function publishedServices(): Collection
    {
        return Service::query()->where('is_published', true)->orderBy('sort_order')->get();
    }
}
