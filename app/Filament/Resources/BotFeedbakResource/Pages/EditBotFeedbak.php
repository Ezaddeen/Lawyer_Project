<?php

namespace App\Filament\Resources\BotFeedbakResource\Pages;

use App\Filament\Resources\BotFeedbakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBotFeedbak extends EditRecord
{
    protected static string $resource = BotFeedbakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
