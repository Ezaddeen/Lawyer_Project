<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'المستندات';
    protected static ?string $pluralLabel = 'المستندات';
    protected static ?string $modelLabel = 'مستند';

public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery()
        ->with(['legalCase', 'client', 'lawyer'])
        ->where('in_trash', false);

    $user = auth()->user();

    // إذا عنده صلاحية عرض الكل
    if ($user->can('view_any_document')) {
        return $query;
    }

    // المحامي: عرض مستنداته فقط
    if ($user->can('view_document') && $user->lawyer_id) {
        return $query->where('lawyer_id', $user->lawyer_id);
    }

    // العميل: عرض مستنداته فقط
    if ($user->can('view_document') && $user->client_id) {
        return $query->where('client_id', $user->client_id);
    }

    // إذا لا يملك صلاحيات العرض
    return $query->whereRaw('1=0');
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('case_id')
                    ->relationship('legalCase', 'title')
                    ->label('القضية')
                    ->searchable()
                    ->nullable(),

                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->label('العميل')
                    ->searchable()
                    ->nullable(),

                Forms\Components\Select::make('lawyer_id')
                    ->relationship('lawyer', 'name')
                    ->label('المحامي')
                    ->searchable()
                    ->nullable(),

                Forms\Components\TextInput::make('name')
                    ->label('اسم المستند')
                    ->required(),

                Forms\Components\Select::make('doc_type')
                    ->options([
                        'مستند' => 'مستند',
                        'عريضة' => 'عريضة',
                        'حكم' => 'حكم',
                        'محضر' => 'محضر',
                        'أخرى' => 'أخرى',
                    ])
                    ->label('نوع المستند'),

                Forms\Components\Select::make('storage_type')
                    ->options([
                        'Path' => 'مسار الملف',
                        'DB' => 'قاعدة البيانات',
                    ])
                    ->label('طريقة التخزين')
                    ->default('Path'),

                Forms\Components\FileUpload::make('file_path')
                    ->label('رفع الملف')
                    ->directory('documents')
                    ->visible(fn ($get) => $get('storage_type') === 'Path')
                    ->required(),

                Forms\Components\Textarea::make('file_blob')
                    ->label('محتوى الملف (DB)')
                    ->visible(fn ($get) => $get('storage_type') === 'DB'),

                Forms\Components\DatePicker::make('upload_at')
                    ->label('تاريخ الرفع')
                    ->nullable(),

                Forms\Components\Textarea::make('notes')
                    ->label('ملاحظات'),

                Forms\Components\Toggle::make('is_missing')
                    ->label('مفقود'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               // Tables\Columns\TextColumn::make('id')->sortable()->label('ID'),
                Tables\Columns\TextColumn::make('name')->label('اسم المستند')->searchable(),
                Tables\Columns\TextColumn::make('legalCase.title')->label('القضية'),
                Tables\Columns\TextColumn::make('client.name')->label('العميل'),
                Tables\Columns\TextColumn::make('lawyer.name')->label('المحامي'),
                Tables\Columns\TextColumn::make('doc_type')->label('النوع'),
                Tables\Columns\TextColumn::make('storage_type')->label('طريقة التخزين'),
                Tables\Columns\IconColumn::make('is_missing')->boolean()->label('مفقود'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d-m-Y H:i')->label('تاريخ الإنشاء'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('doc_type')
                    ->options([
                        'مستند' => 'مستند',
                        'عريضة' => 'عريضة',
                        'حكم' => 'حكم',
                        'محضر' => 'محضر',
                        'أخرى' => 'أخرى',
                    ])
                    ->label('نوع المستند'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('moveToTrash')
                    ->label('نقل إلى السلة')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(fn (Document $record) => $record->update(['in_trash' => true])),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('moveToTrash')
                    ->label('نقل إلى السلة')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn ($records) => $records->each->update(['in_trash' => true]))
                    ->color('danger'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
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

