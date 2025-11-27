<?php

namespace App\Filament\Resources\LawyerAttachmentResource\Pages;

use App\Filament\Resources\LawyerAttachmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLawyerAttachment extends EditRecord
{
    protected static string $resource = LawyerAttachmentResource::class;

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
