<?php

namespace App\Filament\Resources\AuthorizationResource\Pages;

use App\Filament\Resources\AuthorizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAuthorization extends EditRecord
{
    protected static string $resource = AuthorizationResource::class;

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
