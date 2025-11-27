<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminAgentBotResource\Pages;
use App\Models\AdminAgentBot;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdminAgentBotResource extends Resource
{
    protected static ?string $model = AdminAgentBot::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'إدارة الذكاء الاصطناعي';
    protected static ?string $navigationLabel = 'مهام البوت الإداري';
    protected static ?string $pluralModelLabel = 'مهام البوتات الإدارية';
    protected static ?string $modelLabel = 'مهمة بوت إداري';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('admin_user_id')
                    ->label('المستخدم الإداري')
                    ->relationship('adminUser', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Textarea::make('task')
                    ->label('المهمة')
                    ->rows(4)
                    ->required(),

                Forms\Components\Textarea::make('result')
                    ->label('النتيجة')
                    ->rows(6)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('المعرف')
                    ->sortable(),

                Tables\Columns\TextColumn::make('adminUser.name')
                    ->label('المستخدم الإداري')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('task')
                    ->label('المهمة')
                    ->limit(50),

                Tables\Columns\TextColumn::make('result')
                    ->label('النتيجة')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
               // Tables\Actions\ViewAction::make()->label('عرض'),
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminAgentBots::route('/'),
            //'create' => Pages\CreateAdminAgentBot::route('/create'),
            'edit' => Pages\EditAdminAgentBot::route('/{record}/edit'),
        ];
    }

      public static function getNavigationGroup(): ?string
    {
        return 'الذكاء الاصطناعي';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }
}
