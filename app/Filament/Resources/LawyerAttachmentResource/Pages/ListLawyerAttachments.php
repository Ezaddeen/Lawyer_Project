<?php

namespace App\Filament\Resources\LawyerAttachmentResource\Pages;

use App\Filament\Resources\LawyerAttachmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLawyerAttachments extends ListRecords
{
    protected static string $resource = LawyerAttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
