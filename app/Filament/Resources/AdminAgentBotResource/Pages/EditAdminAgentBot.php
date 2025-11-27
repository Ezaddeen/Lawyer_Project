<?php

namespace App\Filament\Resources\AdminAgentBotResource\Pages;

use App\Filament\Resources\AdminAgentBotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminAgentBot extends EditRecord
{
    protected static string $resource = AdminAgentBotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
