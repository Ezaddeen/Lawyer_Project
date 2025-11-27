<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LawyerResource\Pages;
use App\Models\Lawyer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LawyerResource extends Resource
{
    protected static ?string $model = Lawyer::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'المحامين';
    protected static ?string $pluralLabel = 'المحامين';
    protected static ?string $modelLabel = 'محامي';

   public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        // إذا عنده صلاحية عرض الكل
        if ($user->can('view_any_lawyer')) {
            return $query;
        }

        // إذا عنده صلاحية عرض فقط → يعرض المحامي المرتبط به
        if ($user->can('view_lawyer')) {
            return $query->where('id', $user->lawyer_id);
        }

        // إذا لا يملك صلاحيات العرض
        return $query->whereRaw('1=0'); // لا يعرض شيء
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم المحامي')
                    ->required()
                    ->maxLength(150),

                Forms\Components\Select::make('grade')
                    ->label('الدرجة')
                    ->options([
                        'تحت التمرين' => 'تحت التمرين',
                        'ابتدائي' => 'ابتدائي',
                        'استئناف' => 'استئناف',
                        'عليا' => 'عليا',
                    ])
                    ->searchable()
                    ->nullable(),

                Forms\Components\TextInput::make('city')
                    ->label('المدينة')
                    ->maxLength(120)
                    ->nullable(),

                Forms\Components\TextInput::make('address')
                    ->label('العنوان')
                    ->maxLength(255)
                    ->nullable(),

                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->nullable(),

                Forms\Components\TextInput::make('username')
                    ->label('اسم المستخدم')
                    ->unique(ignoreRecord: true)
                    ->nullable(),

                Forms\Components\TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->nullable(),

                Forms\Components\TextInput::make('phone')
                    ->label('الهاتف')
                    ->nullable(),

                Forms\Components\DatePicker::make('joined_at')
                    ->label('تاريخ الانضمام')
                    ->nullable(),

                Forms\Components\DatePicker::make('end_at')
                    ->label('تاريخ الانتهاء')
                    ->nullable(),

                Forms\Components\Textarea::make('note')
                    ->label('ملاحظات')
                    ->nullable(),
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

                Tables\Columns\TextColumn::make('grade')
                    ->label('الدرجة')
                    ->sortable(),

                Tables\Columns\TextColumn::make('city')
                    ->label('المدينة'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف'),

                Tables\Columns\TextColumn::make('joined_at')
                    ->label('تاريخ الانضمام')
                    ->date(),

                Tables\Columns\TextColumn::make('end_at')
                    ->label('تاريخ الانتهاء')
                    ->date(),
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
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLawyers::route('/'),
            'create' => Pages\CreateLawyer::route('/create'),
            'edit' => Pages\EditLawyer::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'المحامين';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}
