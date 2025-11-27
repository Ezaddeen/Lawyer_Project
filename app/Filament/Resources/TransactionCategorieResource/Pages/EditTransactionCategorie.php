<?php

namespace App\Filament\Resources\TransactionCategorieResource\Pages;

use App\Filament\Resources\TransactionCategorieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionCategorie extends EditRecord
{
    protected static string $resource = TransactionCategorieResource::class;

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
