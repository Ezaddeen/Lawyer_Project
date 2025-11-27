<?php

namespace App\Filament\Resources\DocumentTrashResource\Pages;

use App\Filament\Resources\DocumentTrashResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDocumentTrash extends CreateRecord
{
    protected static string $resource = DocumentTrashResource::class;

         protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
