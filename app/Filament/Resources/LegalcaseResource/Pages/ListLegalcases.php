<?php

namespace App\Filament\Resources\LegalcaseResource\Pages;

use App\Filament\Resources\LegalcaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\LegalcaseResource\Widgets\StatsOverview; // ✅ عدل المسار هنا

class ListLegalcases extends ListRecords
{
    protected static string $resource = LegalcaseResource::class;

    // زر إنشاء قضية جديدة
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // البطاقات (الإحصائيات)
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,  // ✅ مثل الحسابات
        ];
    }
}
