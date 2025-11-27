<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkflowResource\Pages;
use App\Models\Workflow;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;

class WorkflowResource extends Resource
{
    protected static ?string $model = Workflow::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'سير العمل';
    protected static ?string $modelLabel = 'خطوة سير العمل';
    protected static ?string $pluralModelLabel = 'خطوات سير العمل';

    // Eager loading للعلاقات لتقليل الاستعلامات
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['relatedCase', 'assignedUser']);
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('اسم الخطوة')->required(),
            Forms\Components\TextInput::make('module')->label('الوحدة')->required(),

            Forms\Components\Select::make('related_case_id')
                ->label('القضية المرتبطة')
                ->relationship('relatedCase', 'name')
                ->searchable(),

            Forms\Components\Select::make('assigned_user_id')
                ->label('المستخدم المسؤول')
                ->relationship('assignedUser', 'name')
                ->searchable(),

            Forms\Components\Select::make('state')
                ->label('الحالة')
                ->options([
                    'جديد' => 'جديد',
                    'قيد التنفيذ' => 'قيد التنفيذ',
                    'مكتمل' => 'مكتمل',
                    'مؤجل' => 'مؤجل',
                ])
                ->default('جديد'),

            Forms\Components\TextInput::make('step_no')->label('رقم الخطوة')->numeric(),
            Forms\Components\Textarea::make('step_desc')->label('وصف الخطوة'),
            Forms\Components\DateTimePicker::make('start_at')->label('تاريخ البدء'),
            Forms\Components\DateTimePicker::make('end_at')->label('تاريخ الانتهاء'),
            Forms\Components\Textarea::make('notes')->label('ملاحظات إضافية'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('الرقم')->searchable(),
                Tables\Columns\TextColumn::make('name')->label('اسم الخطوة')->searchable(),
                Tables\Columns\TextColumn::make('relatedCase.name')->label('القضية')->searchable(),
                Tables\Columns\TextColumn::make('assignedUser.name')->label('المستخدم')->searchable(),
                Tables\Columns\TextColumn::make('state')->label('الحالة')->searchable(),
                Tables\Columns\TextColumn::make('step_no')->label('الترتيب'),
                Tables\Columns\TextColumn::make('start_at')->label('البداية')->dateTime(),
                Tables\Columns\TextColumn::make('end_at')->label('النهاية')->dateTime(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkflows::route('/'),
            'create' => Pages\CreateWorkflow::route('/create'),
            'edit' => Pages\EditWorkflow::route('/{record}/edit'),
        ];
    }

     public static function getNavigationGroup(): ?string
    {
        return 'المهام والأنشطة وسير العمل';
    }

    public static function getNavigationSort(): ?int
    {
        return 10;
    }
}
