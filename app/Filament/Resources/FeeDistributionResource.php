<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeeDistributionResource\Pages;
use App\Models\FeeDistribution;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FeeDistributionResource extends Resource
{
    protected static ?string $model = FeeDistribution::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
    protected static ?string $pluralLabel = 'توزيعات الرسوم';
    protected static ?string $modelLabel = 'توزيع الرسوم';

    protected static function getTableQuery(): Builder
    {
        return parent::getTableQuery()->with('transaction');
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transaction_id')
                    ->relationship('transaction', 'id')
                    ->label('المعاملة')
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('beneficiary_type')
                    ->label('نوع المستفيد')
                    ->options([
                        'محامي' => 'محامي',
                        'مكتب' => 'مكتب',
                        'تكلفة' => 'تكلفة',
                        'وكيل' => 'وكيل',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('beneficiary_id')
                    ->label('رقم المستفيد')
                    ->numeric()
                    ->nullable(),

                Forms\Components\Select::make('rule_type')
                    ->label('نوع القاعدة')
                    ->options([
                        'جلب عميل' => 'جلب عميل',
                        'حضور جلسة' => 'حضور جلسة',
                        'إعداد عرائض' => 'إعداد عرائض',
                        'تكاليف' => 'تكاليف',
                        'نسبة المكتب' => 'نسبة المكتب',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('percentage')
                    ->label('النسبة %')
                    ->numeric()
                    ->step(0.01)
                    ->nullable(),

                Forms\Components\TextInput::make('amount')
                    ->label('المبلغ')
                    ->numeric()
                    ->step(0.01)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('م')
                    ->sortable(),

                // عرض transaction_id فقط لأن هذا العمود موجود في جدولك
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('المعاملة')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('beneficiary_type')
                    ->label('نوع المستفيد'),

                Tables\Columns\TextColumn::make('beneficiary_id')
                    ->label('رقم المستفيد'),

                Tables\Columns\TextColumn::make('rule_type')
                    ->label('نوع القاعدة'),

                Tables\Columns\TextColumn::make('percentage')
                    ->label('النسبة')
                    ->suffix('%'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->money('SAR', true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('beneficiary_type')
                    ->label('نوع المستفيد')
                    ->options([
                        'محامي' => 'محامي',
                        'مكتب' => 'مكتب',
                        'تكلفة' => 'تكلفة',
                        'وكيل' => 'وكيل',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeeDistributions::route('/'),
            'create' => Pages\CreateFeeDistribution::route('/create'),
            'edit' => Pages\EditFeeDistribution::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'المالية';
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    
}
