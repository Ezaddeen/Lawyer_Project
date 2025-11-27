<?php

namespace App\Filament\Resources\DocumentTrashResource\Pages;

use App\Filament\Resources\DocumentTrashResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocumentTrash extends EditRecord
{
    protected static string $resource = DocumentTrashResource::class;

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
