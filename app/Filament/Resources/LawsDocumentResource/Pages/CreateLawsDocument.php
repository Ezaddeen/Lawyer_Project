<?php

namespace App\Filament\Resources\LawsDocumentResource\Pages;

use App\Filament\Resources\LawsDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLawsDocument extends CreateRecord
{
    protected static string $resource = LawsDocumentResource::class;

     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
