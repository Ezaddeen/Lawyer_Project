<?php

namespace App\Filament\Resources\TransactionCategorieResource\Pages;

use App\Filament\Resources\TransactionCategorieResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransactionCategorie extends CreateRecord
{
    protected static string $resource = TransactionCategorieResource::class;

         protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
