<?php

namespace App\Filament\Resources\RevenueDistributionRuleResource\Pages;

use App\Filament\Resources\RevenueDistributionRuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRevenueDistributionRule extends EditRecord
{
    protected static string $resource = RevenueDistributionRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

         protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
