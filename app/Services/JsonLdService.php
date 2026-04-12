<?php

namespace App\Services;

use App\Models\ContactSetting;
use App\Models\SeoPage;
use App\Models\FaqItem;
use App\Models\Review;
use App\Models\SeoSetting;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Support\MediaUrl;

class JsonLdService
{
    /**
     * @return list<array<string, mixed>>
     */
    public function graphForHome(
        iterable $services,
        iterable $faqItems,
        iterable $reviews,
    ): array {
        $site = SiteSetting::current();
        $contact = ContactSetting::current();
        $seo = SeoSetting::current();

        $url = $seo->canonical_url ?: url('/');
        $logo = MediaUrl::public($site->logo_path);

        $organization = [
            '@type' => 'Organization',
            '@id' => $url.'#organization',
            'name' => $site->site_name,
            'url' => $url,
        ];

        if ($logo) {
            $organization['logo'] = $logo;
        }

        $localBusiness = [
            '@type' => 'GeneralContractor',
            '@id' => $url.'#business',
            'name' => $site->site_name,
            'url' => $url,
            'description' => strip_tags((string) $seo->meta_description),
            'image' => $logo ? [$logo] : [],
            'priceRange' => '$$',
            'areaServed' => [
                ['@type' => 'AdministrativeArea', 'name' => 'Минск'],
                ['@type' => 'AdministrativeArea', 'name' => 'Минский район'],
                ['@type' => 'AdministrativeArea', 'name' => 'Минская область'],
            ],
        ];

        if ($contact->phone) {
            $localBusiness['telephone'] = $contact->phone;
        }

        if ($contact->email) {
            $localBusiness['email'] = $contact->email;
        }

        if ($contact->address) {
            $localBusiness['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $contact->address,
            ];
        }

        $localBusiness['makesOffer'] = [];

        foreach ($services as $service) {
            if (! $service instanceof Service) {
                continue;
            }

            $offer = [
                '@type' => 'Offer',
                'name' => $service->name,
                'description' => $service->short_description,
            ];

            $numericPrice = $this->numericPrice($service->price_from);
            if ($numericPrice !== null) {
                $offer['priceSpecification'] = [
                    '@type' => 'PriceSpecification',
                    'priceCurrency' => 'BYN',
                    'price' => $numericPrice,
                ];
            }

            $localBusiness['makesOffer'][] = $offer;
        }

        $graph = [
            $organization,
            $localBusiness,
        ];

        $faqEntities = [];
        foreach ($faqItems as $item) {
            if (! $item instanceof FaqItem) {
                continue;
            }
            $faqEntities[] = [
                '@type' => 'Question',
                'name' => $item->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($item->answer),
                ],
            ];
        }

        if ($faqEntities !== []) {
            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $url.'#faq',
                'mainEntity' => $faqEntities,
            ];
        }

        $reviewNodes = [];
        $sum = 0;
        $count = 0;

        foreach ($reviews as $review) {
            if (! $review instanceof Review) {
                continue;
            }
            if ($review->rating < 1 || $review->rating > 5) {
                continue;
            }

            $reviewNodes[] = [
                '@type' => 'Review',
                'author' => [
                    '@type' => 'Person',
                    'name' => $review->author,
                ],
                'reviewBody' => $review->body,
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => $review->rating,
                    'bestRating' => 5,
                ],
                'itemReviewed' => ['@id' => $url.'#business'],
            ];

            $sum += $review->rating;
            $count++;
        }

        if ($reviewNodes !== []) {
            $graph = array_merge($graph, $reviewNodes);
        }

        if ($count >= 2) {
            $avg = round($sum / $count, 2);
            foreach ($graph as $idx => $node) {
                if (($node['@type'] ?? null) === 'GeneralContractor') {
                    $graph[$idx]['aggregateRating'] = [
                        '@type' => 'AggregateRating',
                        'ratingValue' => $avg,
                        'reviewCount' => $count,
                        'bestRating' => 5,
                        'worstRating' => 1,
                    ];
                    break;
                }
            }
        }

        return $graph;
    }

    private function numericPrice(?string $priceFrom): ?float
    {
        if ($priceFrom === null || $priceFrom === '') {
            return null;
        }

        $normalized = str_replace(',', '.', preg_replace('/[^\d.,]/', '', $priceFrom) ?? '');

        return is_numeric($normalized) ? (float) $normalized : null;
    }

    public function toScriptString(iterable $services, iterable $faqItems, iterable $reviews): string
    {
        $payload = [
            '@context' => 'https://schema.org',
            '@graph' => $this->graphForHome($services, $faqItems, $reviews),
        ];

        return json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
    }

    public function toScriptStringForSeoPage(SeoPage $page): string
    {
        $pageUrl = route('seo.page', ['slug' => $page->slug], true);
        $home = \App\Models\SeoSetting::current()->canonical_url ?: url('/');

        $graph = [
            [
                '@type' => 'WebSite',
                '@id' => $home.'#website',
                'url' => $home,
                'name' => \App\Models\SiteSetting::current()->site_name,
            ],
            [
                '@type' => 'WebPage',
                '@id' => $pageUrl.'#webpage',
                'url' => $pageUrl,
                'name' => $page->h1,
                'description' => strip_tags((string) $page->meta_description),
                'isPartOf' => ['@id' => $home.'#website'],
            ],
        ];

        $payload = [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];

        return json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
    }
}
