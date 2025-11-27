<?php

namespace App\Filament\Resources\FeeDistributionResource\Pages;

use App\Filament\Resources\FeeDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeeDistribution extends EditRecord
{
    protected static string $resource = FeeDistributionResource::class;

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
