<?php

namespace App\Filament\Resources\LawsDocumentResource\Pages;

use App\Filament\Resources\LawsDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLawsDocument extends EditRecord
{
    protected static string $resource = LawsDocumentResource::class;

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
