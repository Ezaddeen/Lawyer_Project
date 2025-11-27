<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RevenueDistributionRuleResource\Pages;
use App\Models\RevenueDistributionRule;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class RevenueDistributionRuleResource extends Resource
{
    protected static ?string $model = RevenueDistributionRule::class;
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $pluralModelLabel = 'قواعد توزيع الإيرادات';
    protected static ?string $modelLabel = 'قاعدة';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['lawyer', 'case']); 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('lawyer_id')
                    ->label('المحامي')
                    ->relationship('lawyer', 'name')
                    ->searchable(),

                Select::make('case_id')
                    ->label('القضية')
                    ->relationship('case', 'title')
                    ->searchable(),

                Select::make('type')
                    ->label('نوع القاعدة')
                    ->options([
                        'جلب عميل' => 'جلب عميل',
                        'حضور جلسة' => 'حضور جلسة',
                        'إعداد عرائض' => 'إعداد عرائض',
                        'تكاليف' => 'تكاليف',
                        'نسبة المكتب' => 'نسبة المكتب',
                    ])
                    ->required(),

                TextInput::make('percentage')
                    ->label('النسبة %')
                    ->numeric(),

                TextInput::make('amount')
                    ->label('المبلغ')
                    ->numeric(),

                DatePicker::make('effective_from')
                    ->label('ساري من'),

                DatePicker::make('effective_to')
                    ->label('ساري إلى'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('lawyer.name')->label('المحامي')->searchable()->sortable(),
                TextColumn::make('case.title')->label('القضية')->searchable()->sortable(),
                TextColumn::make('type')->label('النوع')->sortable(),
                TextColumn::make('percentage')->label('النسبة %')->sortable(),
                TextColumn::make('amount')->label('المبلغ')->sortable(),
                TextColumn::make('effective_from')->label('ساري من')->date()->sortable(),
                TextColumn::make('effective_to')->label('ساري إلى')->date()->sortable(),
            ])
            ->filters([
                // إضافة الفلاتر حسب الحاجة لاحقًا
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRevenueDistributionRules::route('/'),
            'create' => Pages\CreateRevenueDistributionRule::route('/create'),
            'edit' => Pages\EditRevenueDistributionRule::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'المالية';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }
}
