<?php

namespace App\Filament\Resources\DocumentTrashResource\Pages;

use App\Filament\Resources\DocumentTrashResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocumentTrashes extends ListRecords
{
    protected static string $resource = DocumentTrashResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
