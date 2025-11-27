<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;   // ✅ استيراد زر التصدير
use pxlrbt\FilamentExcel\Exports\ExcelExport;           // ✅ استيراد التصدير إلى Excel
use Illuminate\Database\Eloquent\Builder;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $modelLabel = 'مهمة';
    protected static ?string $pluralModelLabel = 'المهام';
    protected static ?string $navigationLabel = 'المهام';

    public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();

    // إذا عنده صلاحية عرض كل المهام
    if (auth()->user()->can('view_any_task')) {
        return $query;
    }

    // إذا عنده صلاحية عرض مهامه فقط
    if (auth()->user()->can('view_task')) {
        return $query->where('user_id', auth()->id());
    }

    // إذا لا يملك صلاحية عرض أي مهام
    return $query->whereRaw('1=0');
}

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('المستخدم')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('title')
                    ->label('العنوان')
                    ->required(),

                Forms\Components\Select::make('priority')
                    ->label('الأولوية')
                    ->options([
                        'High'   => 'عالية',
                        'Normal' => 'متوسطة',
                        'Low'    => 'منخفضة',
                    ])
                    ->default('Normal'),

                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'Not Started' => 'لم تبدأ',
                        'In Progress' => 'قيد التنفيذ',
                        'Completed'   => 'مكتملة',
                        'Deferred'    => 'مؤجلة',
                        'Waiting'     => 'في الانتظار',
                    ])
                    ->default('Not Started'),

                Forms\Components\TextInput::make('percent_complete')
                    ->label('نسبة الإنجاز (%)')
                    ->numeric()
                    ->default(0),

                Forms\Components\Textarea::make('description')
                    ->label('الوصف'),

                Forms\Components\DatePicker::make('due_date')
                    ->label('تاريخ الاستحقاق'),

                Forms\Components\DateTimePicker::make('finished_at')
                    ->label('تاريخ الإكمال'),

                Forms\Components\FileUpload::make('attachments')
                    ->label('المرفقات')
                    ->multiple()
                    ->disk('public')
                    ->directory('tasks/attachments'),

                Forms\Components\Textarea::make('notes')
                    ->label('ملاحظات'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable(),

                Tables\Columns\TextColumn::make('priority')
                    ->label('الأولوية')
                    ->badge()
                    ->colors([
                        'danger'  => 'High',
                        'warning' => 'Normal',
                        'success' => 'Low',
                    ])
                    ->formatStateUsing(fn($state) => match($state) {
                        'High'   => 'عالية',
                        'Normal' => 'متوسطة',
                        'Low'    => 'منخفضة',
                        default  => $state,
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->colors([
                        'gray'    => 'Not Started',
                        'warning' => 'In Progress',
                        'success' => 'Completed',
                        'danger'  => 'Deferred',
                        'info'    => 'Waiting',
                    ])
                    ->formatStateUsing(fn($state) => match($state) {
                        'Not Started' => 'لم تبدأ',
                        'In Progress' => 'قيد التنفيذ',
                        'Completed'   => 'مكتملة',
                        'Deferred'    => 'مؤجلة',
                        'Waiting'     => 'في الانتظار',
                        default       => $state,
                    }),

                Tables\Columns\TextColumn::make('percent_complete')
                    ->label('نسبة الإنجاز (%)'),

                Tables\Columns\TextColumn::make('due_date')
                    ->label('تاريخ الاستحقاق')
                    ->date(),

                Tables\Columns\TextColumn::make('finished_at')
                    ->label('تاريخ الإكمال')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            // ✅ زر تصدير المهام إلى Excel
            ->headerActions([
                ExportAction::make()
                    ->label('تصدير المهام')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable() // تصدير نفس الأعمدة الظاهرة في الجدول
                            ->withFilename('tasks_export_' . date('Y_m_d_H_i')),
                    ]),
            ])

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
            'index'  => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit'   => Pages\EditTask::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'المهام والأنشطة وسير العمل';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }
}

