<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['roles', 'lawyer', 'client']);
    }

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'الإعدادات';
    protected static ?string $modelLabel = 'مستخدم';
    protected static ?string $pluralModelLabel = 'المستخدمين';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('الاسم')
                    ->required()
                    ->maxLength(150),

                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => !empty($state) ? bcrypt($state) : null)
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),

                Forms\Components\Select::make('roles')
                    ->label('الدور')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable(),

                Forms\Components\Select::make('lawyer_id')
                    ->label('المحامي')
                    ->relationship('lawyer', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Forms\Components\Select::make('client_id')
                    ->label('العميل')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                Forms\Components\Toggle::make('is_active')
                    ->label('مفعل')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('البريد')
                    ->searchable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('الأدوار')
                    ->badge(),

                Tables\Columns\TextColumn::make('lawyer.name')
                    ->label('المحامي')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('client.name')
                    ->label('العميل')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),

                Tables\Columns\TextColumn::make('last_login')
                    ->label('آخر تسجيل دخول')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->label('الدور'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('حذف جماعي'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // هنا ممكن تضيف Relation Managers (مثلاً: تقارير، مهام...)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'إدارة المستخدمين';
    }

    public static function getNavigationSort(): ?int
    {
        return 7;
    }
}
