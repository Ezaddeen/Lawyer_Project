<?php

namespace App\Filament\Resources\AuthorizationResource\Pages;

use App\Filament\Resources\AuthorizationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthorization extends CreateRecord
{
    protected static string $resource = AuthorizationResource::class;
    
     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
