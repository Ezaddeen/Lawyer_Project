<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogalAssistantBotResource\Pages;
use App\Models\LogalAssistantBot;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class LogalAssistantBotResource extends Resource
{
    protected static ?string $model = LogalAssistantBot::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $pluralLabel = 'المساعد القانوني';
    protected static ?string $label = 'مساعد قانوني';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->nullable()
                    ->label('المستخدم'),

                Forms\Components\Textarea::make('question')
                    ->required()
                    ->label('السؤال'),

                Forms\Components\Textarea::make('response')
                    ->nullable()
                    ->label('الإجابة'),

                Forms\Components\Select::make('source_law_id')
                    ->relationship('sourceLaw', 'title')
                    ->searchable()
                    ->nullable()
                    ->label('القانون المرجعي'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('رقم')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('المستخدم')->searchable(),
                Tables\Columns\TextColumn::make('question')->label('السؤال')->limit(50),
                Tables\Columns\TextColumn::make('response')->label('الإجابة')->limit(50)->toggleable(),
                Tables\Columns\TextColumn::make('sourceLaw.title')->label('القانون المرجعي'),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإنشاء')->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogalAssistantBots::route('/'),
            'edit' => Pages\EditLogalAssistantBot::route('/{record}/edit'),
        ];
    }
     public static function getNavigationGroup(): ?string
    {
        return 'الذكاء الاصطناعي';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}
