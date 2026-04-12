<?php

namespace App\Filament\Resources\SeoSettingResource\Pages;

use App\Filament\Resources\SeoSettingResource;
use App\Models\SeoSetting;
use Filament\Resources\Pages\ListRecords;

class ManageSeoSettings extends ListRecords
{
    protected static string $resource = SeoSettingResource::class;

    public function mount(): void
    {
        $record = SeoSetting::query()->firstOrFail();
        $this->redirect(SeoSettingResource::getUrl('edit', ['record' => $record]));
    }
}
