<?php

namespace App\Filament\Resources\ContactSettingResource\Pages;

use App\Filament\Resources\ContactSettingResource;
use App\Models\ContactSetting;
use Filament\Resources\Pages\ListRecords;

class ManageContactSettings extends ListRecords
{
    protected static string $resource = ContactSettingResource::class;

    public function mount(): void
    {
        $record = ContactSetting::query()->firstOrFail();
        $this->redirect(ContactSettingResource::getUrl('edit', ['record' => $record]));
    }
}
