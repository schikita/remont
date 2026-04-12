<?php

namespace App\Filament\Resources\QuizResultResource\Pages;

use App\Filament\Resources\QuizResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ManageQuizResults extends ListRecords
{
    protected static string $resource = QuizResultResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
