<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\AccountResource\Widgets\AccountsOverview;

class ListAccounts extends ListRecords
{
    protected static string $resource = AccountResource::class;

    // الأزرار (مثل إنشاء حساب جديد)
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
            AccountsOverview::class,
        ];
    }
}
