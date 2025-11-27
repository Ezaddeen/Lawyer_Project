<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BotFeedbakResource\Pages;
use App\Models\BotFeedbak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class BotFeedbakResource extends Resource
{
    protected static ?string $model = BotFeedbak::class;

    // إعدادات الواجهة في لوحة التحكم
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'التقييمات';
    protected static ?string $pluralModelLabel = 'تقييمات البوت';
    protected static ?string $modelLabel = 'تقييم';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('bot_kind')
                ->label('نوع البوت')
                ->options([
                    'LegalAssistant' => 'المساعد القانوني',
                    'AdminAgent' => 'وكيل الإدارة',
                ])
                ->required(),

            Forms\Components\Select::make('user_id')
                ->label('المستخدم')
                ->relationship('user', 'name')
                ->searchable()
                ->nullable(),

            Forms\Components\TextInput::make('rating')
                ->label('التقييم (1–5)')
                ->numeric()
                ->minValue(1)
                ->maxValue(5)
                ->required(),

            Forms\Components\Textarea::make('comment')
                ->label('التعليق')
                ->nullable()
                ->rows(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('المعرف')
                ->sortable(),

            Tables\Columns\TextColumn::make('bot_kind')
                ->label('نوع البوت')
                ->searchable(),

            Tables\Columns\TextColumn::make('user.name')
                ->label('المستخدم')
                ->searchable(),

            Tables\Columns\TextColumn::make('rating')
                ->label('التقييم')
                ->sortable(),

            Tables\Columns\TextColumn::make('comment')
                ->label('التعليق')
                ->limit(50),

            Tables\Columns\TextColumn::make('created_at')
                ->label('تاريخ الإنشاء')
                ->dateTime(),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make()->label('تعديل'),
            Tables\Actions\DeleteAction::make()->label('حذف'),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make()->label('حذف جماعي'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBotFeedbaks::route('/'),
            //'create' => Pages\CreateBotFeedbak::route('/create'),
            'edit' => Pages\EditBotFeedbak::route('/{record}/edit'),
        ];
    }

     public static function getNavigationGroup(): ?string
    {
        return 'الذكاء الاصطناعي';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }
}
