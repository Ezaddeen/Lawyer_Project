<?php

namespace App\Filament\Resources\LawyerContactResource\Pages;

use App\Filament\Resources\LawyerContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLawyerContacts extends ListRecords
{
    protected static string $resource = LawyerContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
