<?php

namespace App\Filament\Resources\HeroSectionResource\Pages;

use App\Filament\Resources\HeroSectionResource;
use Filament\Resources\Pages\EditRecord;

class EditHeroSection extends EditRecord
{
    protected static string $resource = HeroSectionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $text = $data['trust_badges_text'] ?? '';
        unset($data['trust_badges_text']);
        $lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $text))));

        $data['trust_badges'] = $lines;

        return $data;
    }
}
