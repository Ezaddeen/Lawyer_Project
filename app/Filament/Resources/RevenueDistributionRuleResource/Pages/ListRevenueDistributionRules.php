<?php

namespace App\Filament\Resources\RevenueDistributionRuleResource\Pages;

use App\Filament\Resources\RevenueDistributionRuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRevenueDistributionRules extends ListRecords
{
    protected static string $resource = RevenueDistributionRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
