<?php

namespace App\Filament\Resources\LawyerContactResource\Pages;

use App\Filament\Resources\LawyerContactResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLawyerContact extends CreateRecord
{
    protected static string $resource = LawyerContactResource::class;

         protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
