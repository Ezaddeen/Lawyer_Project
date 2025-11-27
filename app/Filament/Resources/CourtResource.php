<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourtResource\Pages;
use App\Models\Court;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CourtResource extends Resource
{
    protected static ?string $model = Court::class;

    protected static ?string $navigationIcon  = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'المحاكم';
    protected static ?string $pluralModelLabel = 'المحاكم';
    protected static ?string $modelLabel = 'محكمة';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('الاسم')
                ->required()
                ->maxLength(200),

            Forms\Components\Select::make('kind')
                ->label('النوع')
                ->required()
                ->options([
                    'محكمة'   => 'محكمة',
                    'نيابة'   => 'نيابة',
                    'قسم شرطة' => 'قسم شرطة',
                ]),

            Forms\Components\Select::make('level')
                ->label('المستوى')
                ->nullable()
                ->options([
                    'ابتدائية' => 'ابتدائية',
                    'استئناف'  => 'استئناف',
                    'عليا'     => 'عليا',
                    'غير ذالك' => 'غير ذالك',
                ]),

            Forms\Components\TextInput::make('city')
                ->label('المدينة')
                ->maxLength(120),

            Forms\Components\TextInput::make('address')
                ->label('العنوان')
                ->maxLength(255),

            Forms\Components\Textarea::make('location')
                ->label('الموقع')
                ->columnSpanFull(),

            Forms\Components\Textarea::make('notes')
                ->label('ملاحظات')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            // Tables\Columns\TextColumn::make('id')
            //     ->label('الرقم')
            //     ->sortable(),

            Tables\Columns\TextColumn::make('name')
                ->label('الاسم')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('kind')
                ->label('النوع')
                ->sortable(),

            Tables\Columns\TextColumn::make('level')
                ->label('المستوى')
                ->sortable(),

            Tables\Columns\TextColumn::make('city')
                ->label('المدينة')
                ->searchable(),

            Tables\Columns\TextColumn::make('address')
                ->label('العنوان')
                ->limit(20),

            Tables\Columns\TextColumn::make('created_at')
                ->label('تاريخ الإنشاء')
                ->dateTime('d-m-Y'),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('kind')
                ->label('نوع الجهة')
                ->options([
                    'محكمة'   => 'محكمة',
                    'نيابة'   => 'نيابة',
                    'قسم شرطة' => 'قسم شرطة',
                ]),

            Tables\Filters\SelectFilter::make('level')
                ->label('المستوى')
                ->options([
                    'ابتدائية' => 'ابتدائية',
                    'استئناف'  => 'استئناف',
                    'عليا'     => 'عليا',
                    'غير ذالك' => 'غير ذالك',
                ]),
        ])
        ->actions([
            Tables\Actions\ViewAction::make()->label('عرض'),
            Tables\Actions\EditAction::make()->label('تعديل'),
            Tables\Actions\DeleteAction::make()->label('حذف'),
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
            // إضافة Relation Managers لاحقاً مثل القضايا والجلسات
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCourts::route('/'),
            'create' => Pages\CreateCourt::route('/create'),
            'edit'   => Pages\EditCourt::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'الإدارة القانونية والقضايا';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}
