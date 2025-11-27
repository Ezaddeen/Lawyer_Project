<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorizationResource\Pages;
use App\Models\Authorization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuthorizationResource extends Resource
{
    protected static ?string $model = Authorization::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'التوكيلات';
    protected static ?string $pluralModelLabel = 'التوكيلات';
    protected static ?string $modelLabel = 'توكيل';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['client', 'lawyer']); 
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required()
                    ->label('العميل'),

                Forms\Components\Select::make('lawyer_id')
                    ->relationship('lawyer', 'name')
                    ->required()
                    ->label('المحامي'),

                Forms\Components\Radio::make('type')
                    ->options([
                        'خاص' => 'خاص',
                        'عام' => 'عام',
                    ])
                    ->label('نوع التوكيل')
                    ->inline()
                    ->required(),

                Forms\Components\TextInput::make('company_name')
                    ->label('اسم الشركة')
                    ->maxLength(200),

                Forms\Components\DatePicker::make('year')
                    ->label('السنة'),

                Forms\Components\DatePicker::make('start_date')
                    ->label('تاريخ البداية'),

                Forms\Components\DatePicker::make('end_date')
                    ->label('تاريخ الانتهاء'),

                Forms\Components\TextInput::make('office_file_no')
                    ->label('رقم ملف المكتب')
                    ->maxLength(100),

                Forms\Components\FileUpload::make('attachments')
                    ->label('المرفقات')
                    ->multiple()
                    ->disk('public')
                    ->directory('authorizations'),

                Forms\Components\Textarea::make('notes')
                    ->label('ملاحظات')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->label('العميل')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lawyer.name')
                    ->label('المحامي')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('النوع'),

                Tables\Columns\TextColumn::make('company_name')
                    ->label('اسم الشركة'),

                Tables\Columns\TextColumn::make('year')
                    ->label('السنة')
                    ->date('Y'),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('تاريخ البداية')
                    ->date(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('تاريخ الانتهاء')
                    ->date(),

                Tables\Columns\TextColumn::make('office_file_no')
                    ->label('رقم ملف المكتب'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'خاص' => 'خاص',
                        'عام' => 'عام',
                    ])
                    ->label('النوع'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuthorizations::route('/'),
            'create' => Pages\CreateAuthorization::route('/create'),
            'edit' => Pages\EditAuthorization::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'العملاء والتوكيلات';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}
