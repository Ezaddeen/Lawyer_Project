<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'المعاملات المالية';
    protected static ?string $pluralLabel = 'المعاملات المالية';
    protected static ?string $modelLabel = 'معاملة';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with([
            'account',
            'client',
            'lawyer',
            'case',
            'transaction_category',
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('account_id')
                    ->label('الحساب')
                    ->relationship('account', 'account_name')
                    ->searchable()
                    ->preload(false)
                    ->required(),

                Forms\Components\Select::make('client_id')
                    ->label('العميل')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload(false),

                Forms\Components\Select::make('lawyer_id')
                    ->label('المحامي')
                    ->relationship('lawyer', 'name')
                    ->searchable()
                    ->preload(false),

                Forms\Components\Select::make('case_id')
                    ->label('القضية')
                    ->relationship('case', 'title')
                    ->searchable()
                    ->preload(false),

                Forms\Components\Select::make('transaction_category_id')
                    ->label('تصنيف العملية')
                    ->relationship('transaction_category', 'name')
                    ->searchable()
                    ->preload(false)
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->label('المبلغ')
                    ->numeric()
                    ->required(),

                Forms\Components\Select::make('txn_type')
                    ->label('نوع العملية')
                    ->options([
                        'دفعة مقدمة' => 'دفعة مقدمة',
                        'دفعة نهائية' => 'دفعة نهائية',
                        'رسوم' => 'رسوم',
                        'أخرى' => 'أخرى',
                    ])
                    ->required(),

                Forms\Components\DateTimePicker::make('txn_date')
                    ->label('تاريخ العملية')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('ملاحظات')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('رقم')->sortable(),
                Tables\Columns\TextColumn::make('account.account_name')->label('الحساب')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('client.name')->label('العميل')->searchable(),
                Tables\Columns\TextColumn::make('lawyer.name')->label('المحامي'),
                Tables\Columns\TextColumn::make('case.title')->label('القضية'),
                Tables\Columns\TextColumn::make('transaction_category.name')->label('تصنيف العملية'),
                Tables\Columns\TextColumn::make('amount')->label('المبلغ')->money('usd', true)->sortable(),
                Tables\Columns\TextColumn::make('txn_type')->label('نوع العملية')->sortable(),
                Tables\Columns\TextColumn::make('txn_date')->label('تاريخ العملية')->dateTime('d-m-Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('notes')->label('ملاحظات')->limit(20),
            ])
            ->filters([
                // أضف الفلاتر حسب الحاجة
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('عرض'),
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'المالية';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}
