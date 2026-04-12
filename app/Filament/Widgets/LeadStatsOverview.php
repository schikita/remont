<?php

namespace App\Filament\Widgets;

use App\Enums\LeadStatus;
use App\Models\Lead;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Новые заявки', (string) Lead::query()->where('status', LeadStatus::New)->count()),
            Stat::make('В работе', (string) Lead::query()->where('status', LeadStatus::InProgress)->count()),
            Stat::make('Всего заявок', (string) Lead::query()->count()),
        ];
    }
}
