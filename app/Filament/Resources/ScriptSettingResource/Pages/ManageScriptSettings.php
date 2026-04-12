<?php

namespace App\Filament\Resources\ScriptSettingResource\Pages;

use App\Filament\Resources\ScriptSettingResource;
use App\Models\ScriptSetting;
use Filament\Resources\Pages\ListRecords;

class ManageScriptSettings extends ListRecords
{
    protected static string $resource = ScriptSettingResource::class;

    public function mount(): void
    {
        $record = ScriptSetting::query()->firstOrFail();
        $this->redirect(ScriptSettingResource::getUrl('edit', ['record' => $record]));
    }
}
