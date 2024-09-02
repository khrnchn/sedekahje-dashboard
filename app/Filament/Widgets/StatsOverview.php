<?php

namespace App\Filament\Widgets;

use App\Models\Institution;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total institutions', Institution::count()),
            Stat::make('Total Added Today', Institution::whereDate('created_at', now())->count()),
        ];
    }
}
