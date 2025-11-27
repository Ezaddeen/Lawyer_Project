<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionCategorieResource\Pages;
use App\Models\TransactionCategorie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionCategorieResource extends Resource
{
    protected static ?string $model = TransactionCategorie::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'تصنيفات المعاملات';
    protected static ?string $pluralModelLabel = 'تصنيفات المعاملات';
    protected static ?string $modelLabel = 'تصنيف المعاملة';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('الاسم')
                    ->required()
                    ->maxLength(120),

                Forms\Components\Textarea::make('description')
                    ->label('الوصف')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('الرقم')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('الاسم')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('description')->label('الوصف')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإنشاء')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('حذف متعدد'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTransactionCategories::route('/'),
            'create' => Pages\CreateTransactionCategorie::route('/create'),
            'edit'   => Pages\EditTransactionCategorie::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'المالية';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }
}
