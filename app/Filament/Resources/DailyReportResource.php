<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyReportResource\Pages;
use App\Models\DailyReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DailyReportResource extends Resource
{
    protected static ?string $model = DailyReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'التقارير اليومية';
    protected static ?string $pluralLabel = 'التقارير اليومية';
    protected static ?string $modelLabel = 'تقرير يومي';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['case', 'lawyer', 'reviewer']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('case_id')
                    ->label('القضية')
                    ->relationship('case', 'title')
                    ->searchable()
                    ->preload(false) // 🚀 يمنع تحميل جميع القضايا مرة واحدة
                    ->nullable(),

                Forms\Components\Select::make('lawyer_id')
                    ->label('المحامي')
                    ->relationship('lawyer', 'name')
                    ->searchable()
                    ->preload(false)
                    ->required(),

                Forms\Components\DatePicker::make('report_date')
                    ->label('تاريخ التقرير')
                    ->required(),

                Forms\Components\Textarea::make('content')
                    ->label('المحتوى')
                    ->required()
                    ->rows(6),

                Forms\Components\TextInput::make('week_no')
                    ->label('أسبوع رقم')
                    ->numeric()
                    ->nullable(),

                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'مكتمل' => 'مكتمل',
                        'قيد المراجعة' => 'قيد المراجعة',
                        'مرفوض' => 'مرفوض',
                    ])
                    ->default('قيد المراجعة')
                    ->required(),

                Forms\Components\Select::make('reviewer_id')
                    ->label('المراجع')
                    ->relationship('reviewer', 'name')
                    ->searchable()
                    ->preload(false)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('id')
                //     ->label('#')
                //     ->sortable(),

                Tables\Columns\TextColumn::make('case.title')
                    ->label('القضية')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('lawyer.name')
                    ->label('المحامي')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('report_date')
                    ->label('تاريخ التقرير')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('week_no')
                    ->label('الأسبوع'),

                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'مكتمل' => 'success',
                        'قيد المراجعة' => 'warning',
                        'مرفوض' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('reviewer.name')
                    ->label('المراجع'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailyReports::route('/'),
            'create' => Pages\CreateDailyReport::route('/create'),
            'edit' => Pages\EditDailyReport::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'المستندات والتقارير';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}
