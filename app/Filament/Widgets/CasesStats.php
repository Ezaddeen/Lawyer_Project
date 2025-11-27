<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Legalcase;
use App\Models\Client;
use App\Models\Hearing;
use Carbon\Carbon;

class CasesStats extends BaseWidget
{
    protected ?string $heading = 'الإحصائيات';
    
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي القضايا', Legalcase::count())
                ->description('مجموع القضايا')
                ->color('primary')
                ->icon('heroicon-o-clipboard-document'),

            Stat::make('القضايا المفتوحة', Legalcase::where('status', 'open')->count())
                ->description('القضايا النشطة حالياً')
                ->color('success')
                ->icon('heroicon-o-scale'),

            Stat::make('القضايا المغلقة', Legalcase::where('status', 'closed')->count())
                ->description('تم الانتهاء منها')
                ->color('danger')
                ->icon('heroicon-o-check-circle'),

            Stat::make('القضايا الجديدة', Legalcase::whereDate('created_at', Carbon::today())->count())
                ->description('عدد القضايا المسجلة اليوم')
                ->color('secondary')
                ->icon('heroicon-o-document-text'),

            Stat::make('جلسات اليوم', Hearing::whereDate('hearing_datetime', Carbon::today())->count())
                ->description('عدد الجلسات المجدولة اليوم')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make('العملاء النشطون', Client::whereNull('end_at')->count())
                ->description('عملاء لديهم عقود سارية')
                ->color('info')
                ->icon('heroicon-o-user-group'),
        ];
    }
}
