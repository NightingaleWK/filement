<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('猫', Patient::query()->where('type', 'cat')->count()),
            Stat::make('狗', Patient::query()->where('type', 'dog')->count()),
            Stat::make('兔', Patient::query()->where('type', 'rabbit')->count()),
        ];
    }
}
