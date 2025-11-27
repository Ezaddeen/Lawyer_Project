<?php

namespace App\Filament\Resources\TransactionCategorieResource\Pages;

use App\Filament\Resources\TransactionCategorieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionCategories extends ListRecords
{
    protected static string $resource = TransactionCategorieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
