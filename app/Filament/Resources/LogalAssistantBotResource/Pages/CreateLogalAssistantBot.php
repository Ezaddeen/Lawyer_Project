<?php

namespace App\Filament\Resources\LogalAssistantBotResource\Pages;

use App\Filament\Resources\LogalAssistantBotResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLogalAssistantBot extends CreateRecord
{
    protected static string $resource = LogalAssistantBotResource::class;

         protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
