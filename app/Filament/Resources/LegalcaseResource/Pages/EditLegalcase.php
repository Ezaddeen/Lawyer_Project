<?php

namespace App\Filament\Resources\LegalcaseResource\Pages;

use App\Filament\Resources\LegalcaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLegalcase extends EditRecord
{
    protected static string $resource = LegalcaseResource::class;

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
