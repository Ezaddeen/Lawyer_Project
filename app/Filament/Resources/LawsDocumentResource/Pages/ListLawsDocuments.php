<?php

namespace App\Filament\Resources\LawsDocumentResource\Pages;

use App\Filament\Resources\LawsDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLawsDocuments extends ListRecords
{
    protected static string $resource = LawsDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
