<?php

namespace App\Filament\Resources\HeroSectionResource\Pages;

use App\Filament\Resources\HeroSectionResource;
use App\Models\HeroSection;
use Filament\Resources\Pages\ListRecords;

class ManageHeroSections extends ListRecords
{
    protected static string $resource = HeroSectionResource::class;

    public function mount(): void
    {
        $record = HeroSection::query()->firstOrFail();
        $this->redirect(HeroSectionResource::getUrl('edit', ['record' => $record]));
    }
}
