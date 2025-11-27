<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentTrashResource\Pages;
use App\Models\Document;
use Filament\Forms;
use App\Models\DocumentTrash;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DocumentTrashResource extends Resource
{
    protected static ?string $model = DocumentTrash::class;

    protected static ?string $navigationIcon = 'heroicon-o-trash';
    protected static ?string $navigationLabel = 'سلة المحذوفات';
    protected static ?string $pluralLabel = 'سلة المحذوفات';
    protected static ?string $modelLabel = 'محذوف';

    public static function form(Form $form): Form
    {
        return $form->schema([]); 
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->label('ID'),
                Tables\Columns\TextColumn::make('name')->label('اسم المستند')->searchable(),
                Tables\Columns\TextColumn::make('case.title')->label('القضية'),
                Tables\Columns\TextColumn::make('clinic.name')->label('العميل'),
                Tables\Columns\TextColumn::make('lawyer.name')->label('المحامي'),
                Tables\Columns\TextColumn::make('doc_type')->label('النوع'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d-m-Y H:i')->label('تاريخ الإنشاء'),
            ])
            ->actions([
                Tables\Actions\Action::make('restore')
                    ->label('استعادة')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->action(fn (Document $record) => $record->update(['in_trash' => false])),

                Tables\Actions\DeleteAction::make()
                    ->label('حذف نهائي')
                    ->requiresConfirmation()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('restore')
                    ->label('استعادة')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->action(fn ($records) => $records->each->update(['in_trash' => false]))
                    ->color('success'),

                Tables\Actions\DeleteBulkAction::make()
                    ->label('حذف نهائي')
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
            'index' => Pages\ListDocumentTrashes::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('in_trash', true);
    }
         public static function getPermissionPrefix(): string
    {
        return 'document_trash';
    }

     public static function getNavigationGroup(): ?string
{
    return 'المستندات والتقارير'; // حسب المجموعة
}

public static function getNavigationSort(): ?int
{
    return 1; // حسب الترتيب داخل المجموعة
}
}
