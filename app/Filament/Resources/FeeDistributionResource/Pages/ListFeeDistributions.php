<?php

namespace App\Filament\Resources\FeeDistributionResource\Pages;

use App\Filament\Resources\FeeDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeeDistributions extends ListRecords
{
    protected static string $resource = FeeDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
