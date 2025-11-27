<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'العملاء';
    protected static ?string $pluralModelLabel = 'العملاء';
    protected static ?string $modelLabel = 'عميل';

   
    public static function getEloquentQuery(): Builder
    {
       $query = parent::getEloquentQuery();

    // إذا عنده صلاحية عرض الكل
    if (auth()->user()->can('view_any_client')) {
        return $query;
    }

    // إذا المستخدم عنده صلاحية عرض فقط → نعرض العميل المرتبط به
    if (auth()->user()->can('view_client')) {
        return $query->where('id', auth()->user()->client_id);
    }

    // إذا لا يملك صلاحيات العرض
    return $query->whereRaw('1=0'); // لا يعرض شيء
}
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('الاسم')
                    ->required()
                    ->maxLength(150),

                Forms\Components\Select::make('type')
                    ->label('النوع')
                    ->options([
                        'شركة' => 'شركة',
                        'فرد' => 'فرد',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('city')
                    ->label('المدينة')
                    ->maxLength(120),

                Forms\Components\TextInput::make('address')
                    ->label('العنوان')
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->unique(ignoreRecord: true),
                 

                Forms\Components\TextInput::make('username')
                    ->label('اسم المستخدم')
                    ->unique(ignoreRecord: true)
                    ->maxLength(120),

                Forms\Components\TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('start_at')
                    ->label('تاريخ البداية'),

                Forms\Components\DatePicker::make('end_at')
                    ->label('تاريخ النهاية'),

                Forms\Components\Textarea::make('note')
                    ->label('ملاحظات')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),

                Tables\Columns\TextColumn::make('username')
                    ->label('اسم المستخدم'),

                Tables\Columns\TextColumn::make('city')
                    ->label('المدينة'),

                Tables\Columns\TextColumn::make('start_at')
                    ->label('بداية')
                    ->date(),

                Tables\Columns\TextColumn::make('end_at')
                    ->label('نهاية')
                    ->date(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            'index'  => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view'   => Pages\ViewClient::route('/{record}'),
            'edit'   => Pages\EditClient::route('/{record}/edit'),
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
