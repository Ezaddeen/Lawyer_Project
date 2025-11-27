<?php

namespace App\Filament\Resources\LegalcaseResource\Pages;

use App\Filament\Resources\LegalcaseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLegalcase extends CreateRecord
{
    protected static string $resource = LegalcaseResource::class;

     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
