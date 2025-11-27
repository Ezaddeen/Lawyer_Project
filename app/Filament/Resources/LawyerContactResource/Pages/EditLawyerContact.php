<?php

namespace App\Filament\Resources\LawyerContactResource\Pages;

use App\Filament\Resources\LawyerContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLawyerContact extends EditRecord
{
    protected static string $resource = LawyerContactResource::class;

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
