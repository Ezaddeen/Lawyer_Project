<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'الحسابات';
    protected static ?string $pluralLabel = 'الحسابات';
    protected static ?string $modelLabel = 'حساب';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('account_name')
                    ->label('اسم الحساب')
                    ->required()
                    ->maxLength(150),

                Forms\Components\Select::make('account_type')
                    ->label('نوع الحساب')
                    ->options([
                        'بنك' => 'بنك',
                        'نقدي' => 'نقدي',
                        'محفظة' => 'محفظة',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('currency')
                    ->label('العملة')
                    ->required()
                    ->maxLength(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('account_name')
                    ->label('اسم الحساب')
                    ->weight('bold')
                    ->size('lg')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('account_type')
                    ->label('نوع الحساب')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'بنك' => 'success',
                        'نقدي' => 'warning',
                        'محفظة' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('currency')
                    ->label('العملة'),

                TextColumn::make('transactions_sum_amount')
                    ->label('الرصيد')
                    ->numeric()
                    ->money('SAR')
                    ->weight('bold')
                    ->color('primary'),
            ])
            // ->contentGrid([  
            //     'md' => 2,
            //     'lg' => 3,
            // ])
            ->actions([
                // Action::make('transfer')
                //     ->label('تحويل')
                //     ->icon('heroicon-o-arrow-right')
                //     ->color('success')
                //     ->url(fn ($record) => route('accounts.transfer', $record)),

                // Tables\Actions\EditAction::make()
                //     ->label('تعديل'),

                // Action::make('details')
                //     ->label('تفاصيل')
                //     ->icon('heroicon-o-eye')
                //     ->url(fn ($record) => route('accounts.show', $record)),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                   Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }

    public static function getPages(): array
    {
        return [
            
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
            return 'المالية'; 
    }

    public static function getNavigationSort(): ?int
    {
        return 5;
    }
}
