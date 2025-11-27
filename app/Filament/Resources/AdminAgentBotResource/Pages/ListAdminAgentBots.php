<?php

namespace App\Filament\Resources\AdminAgentBotResource\Pages;

use App\Filament\Resources\AdminAgentBotResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdminAgentBots extends ListRecords
{
    protected static string $resource = AdminAgentBotResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }
}
