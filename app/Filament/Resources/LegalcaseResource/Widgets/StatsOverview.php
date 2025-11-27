<?php

namespace App\Filament\Resources\LegalcaseResource\Widgets;

use App\Models\Legalcase;
use App\Models\Client;
use App\Models\Lawyer;
use App\Models\ActivityLog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('القضايا المفتوحة', Legalcase::where('status', 'open')->count())
                ->description('إجمالي القضايا النشطة')
                ->color('success'),

            Stat::make('القضايا الجديدة', Legalcase::where('status', 'closed')->count())
                ->description('إجمالي القضايا الجديدة')
                ->color('new'),

 Stat::make('القضايا المغلقة', Legalcase::where('status', 'closed')->count())
                ->description('إجمالي القضايا المكتملة')
                ->color('danger'),


        ];
    }
}
