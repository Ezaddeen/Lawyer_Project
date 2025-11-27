<?php

namespace App\Filament\Resources\LawyerAttachmentResource\Pages;

use App\Filament\Resources\LawyerAttachmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLawyerAttachment extends CreateRecord
{
    protected static string $resource = LawyerAttachmentResource::class;

         protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
