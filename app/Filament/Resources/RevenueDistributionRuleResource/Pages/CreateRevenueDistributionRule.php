<?php

namespace App\Filament\Resources\RevenueDistributionRuleResource\Pages;

use App\Filament\Resources\RevenueDistributionRuleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRevenueDistributionRule extends CreateRecord
{
    protected static string $resource = RevenueDistributionRuleResource::class;

         protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
