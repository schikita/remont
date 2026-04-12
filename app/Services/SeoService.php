<?php

namespace App\Services;

use App\Models\ContactSetting;
use App\Models\SeoPage;
use App\Models\SeoSetting;
use App\Models\SiteSetting;
use App\Support\MediaUrl;

class SeoService
{
    public function forHome(): array
    {
        $seo = SeoSetting::current();
        $site = SiteSetting::current();
        $contact = ContactSetting::current();

        $title = $seo->meta_title ?: $site->site_name;
        $description = $seo->meta_description ?? '';

        $canonical = $seo->canonical_url ?: url('/');

        $ogTitle = $seo->og_title ?: $title;
        $ogDescription = $seo->og_description ?: $description;
        $ogImage = MediaUrl::public($seo->og_image_path);

        $twitterTitle = $seo->twitter_title ?: $ogTitle;
        $twitterDescription = $seo->twitter_description ?: $ogDescription;
        $twitterImage = MediaUrl::public($seo->twitter_image_path ?: $seo->og_image_path);

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'robots' => $seo->robots ?: 'index,follow',
            'og' => [
                'title' => $ogTitle,
                'description' => $ogDescription,
                'image' => $ogImage,
                'type' => $seo->og_type ?: 'website',
                'url' => $canonical,
                'site_name' => $site->site_name,
            ],
            'twitter' => [
                'card' => $seo->twitter_card ?: 'summary_large_image',
                'title' => $twitterTitle,
                'description' => $twitterDescription,
                'image' => $twitterImage,
            ],
            'contact_phone' => $contact->phone,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function forSeoPage(SeoPage $page): array
    {
        $site = SiteSetting::current();
        $contact = ContactSetting::current();
        $canonical = route('seo.page', ['slug' => $page->slug], true);

        $title = $page->meta_title ?: $page->h1;
        $description = $page->meta_description ?? '';

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'robots' => 'index,follow',
            'og' => [
                'title' => $title,
                'description' => $description,
                'image' => null,
                'type' => 'article',
                'url' => $canonical,
                'site_name' => $site->site_name,
            ],
            'twitter' => [
                'card' => 'summary_large_image',
                'title' => $title,
                'description' => $description,
                'image' => null,
            ],
            'contact_phone' => $contact->phone,
        ];
    }
}
