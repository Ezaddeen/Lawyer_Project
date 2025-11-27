<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LawsDocumentResource\Pages;
use App\Models\LawsDocument;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class LawsDocumentResource extends Resource
{
    protected static ?string $model = LawsDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $navigationLabel = 'القوانين';
    protected static ?string $pluralLabel = 'القوانين';
    protected static ?string $modelLabel = 'قانون';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('law_number')
                ->label('رقم القانون')
                ->required()
                ->maxLength(50),

            Forms\Components\TextInput::make('law_title')
                ->label('عنوان القانون')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('law_description')
                ->label('الوصف')
                ->rows(5),

            Forms\Components\DatePicker::make('issue_date')
                ->label('تاريخ الإصدار'),

            Forms\Components\DatePicker::make('amendment_date')
                ->label('تاريخ التعديل'),

            Forms\Components\TextInput::make('law_category')
                ->label('التصنيف')
                ->maxLength(100),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('law_number')->label('رقم القانون')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('law_title')->label('العنوان')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('issue_date')->label('تاريخ الإصدار')->date()->sortable(),
                Tables\Columns\TextColumn::make('amendment_date')->label('تاريخ التعديل')->date()->sortable(),
                Tables\Columns\TextColumn::make('law_category')->label('التصنيف')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإضافة')->dateTime()->sortable(),
            ])
            ->filters([
                // فلتر حسب التصنيف
                Tables\Filters\Filter::make('category')
                    ->label('حسب التصنيف')
                    ->form([
                        Forms\Components\TextInput::make('law_category')->label('التصنيف')
                    ])
                    ->query(function ($query, $data) {
                        if (!empty($data['law_category'])) {
                            $query->where('law_category', 'like', '%' . $data['law_category'] . '%');
                        }
                    }),

                // فلتر حسب تاريخ الإصدار
                Tables\Filters\Filter::make('issue_date')
                    ->label('حسب تاريخ الإصدار')
                    ->form([
                        Forms\Components\DatePicker::make('issue_date')->label('اختر تاريخ')
                    ])
                    ->query(function ($query, $data) {
                        if (!empty($data['issue_date'])) {
                            $query->whereDate('issue_date', $data['issue_date']);
                        }
                    }),

                // فلتر حسب تاريخ التعديل
                Tables\Filters\Filter::make('amendment_date')
                    ->label('حسب تاريخ التعديل')
                    ->form([
                        Forms\Components\DatePicker::make('amendment_date')->label('اختر تاريخ')
                    ])
                    ->query(function ($query, $data) {
                        if (!empty($data['amendment_date'])) {
                            $query->whereDate('amendment_date', $data['amendment_date']);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListLawsDocuments::route('/'),
            'create' => Pages\CreateLawsDocument::route('/create'),
            'edit' => Pages\EditLawsDocument::route('/{record}/edit'),
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
