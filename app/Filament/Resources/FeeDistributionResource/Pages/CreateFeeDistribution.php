<?php

namespace App\Filament\Resources\FeeDistributionResource\Pages;

use App\Filament\Resources\FeeDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFeeDistribution extends CreateRecord
{
    protected static string $resource = FeeDistributionResource::class;

         protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
