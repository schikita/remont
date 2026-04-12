<?php

namespace App\Filament\Resources\AboutSectionResource\Pages;

use App\Filament\Resources\AboutSectionResource;
use App\Models\AboutSection;
use Filament\Resources\Pages\ListRecords;

class ManageAboutSections extends ListRecords
{
    protected static string $resource = AboutSectionResource::class;

    public function mount(): void
    {
        $record = AboutSection::query()->firstOrFail();
        $this->redirect(AboutSectionResource::getUrl('edit', ['record' => $record]));
    }
}
