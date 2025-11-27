<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Models\ActivityLog;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'سجل النشاطات';
    protected static ?string $pluralLabel = 'سجلات النشاط';
    protected static ?string $label = 'نشاط';
    protected static ?string $slug = 'activity-logs';

    public static function form(Forms\Form $form): Forms\Form
    {
        // لا نحتاج نموذج تعديل لأن هذه السجلات تُنشأ تلقائيًا
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('الرقم')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('المستخدم')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('action')
                    ->label('العملية')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'create' => 'إضافة',
                        'update' => 'تعديل',
                        'delete' => 'حذف',
                        default => $state,
                    })
                    ->colors([
                        'success' => 'create',
                        'warning' => 'update',
                        'danger' => 'delete',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('table_name')
                    ->label('الجدول')
                    ->formatStateUsing(fn ($state) => match ($state) {
         'accounts' => 'الحسابات',
        'activity_logs' => 'سجل النشاطات',
        'admin_agent_bots' => 'روبوتات الإدارة',
        'app_settings' => 'إعدادات التطبيق',
        'authorizations' => 'التصريحات',
        'a_i_training_data' => 'بيانات تدريب الذكاء الاصطناعي',
        'bot_feedbaks' => 'تغذية الروبوت',
        'cache' => 'التخزين المؤقت',
        'cache_locks' => 'أقفال التخزين',
        'case_amendments' => 'تعديلات القضايا',
        'clients' => 'العملاء',
        'client_contacts' => 'جهات اتصال العملاء',
        'courts' => 'المحاكم',
        'court_changes' => 'تغييرات المحاكم',
        'daily_reports' => 'التقارير اليومية',
        'documents' => 'الملفات',
        'failed_jobs' => 'الوظائف الفاشلة',
        'fee_distributions' => 'توزيع الرسوم',
        'hearings' => 'الجلسات',
        'inventories' => 'المخزون',
        'jobs' => 'الوظائف',
        'job_batches' => 'دفعات الوظائف',
        'laws_documents' => 'مستندات القوانين',
        'lawyers' => 'المحامون',
        'lawyer_attachments' => 'مرفقات المحامين',
        'lawyer_contacts' => 'جهات اتصال المحامين',
        'legal_case' => 'القضايا القانونية',
        'logal_assistant_bots' => 'روبوتات المساعد القانوني',
        'migrations' => 'الترحيلات',
        'model_has_permissions' => 'نماذج الصلاحيات',
        'model_has_roles' => 'نماذج الأدوار',
        'notifications' => 'الإشعارات',
        'password_reset_tokens' => 'رموز إعادة كلمة المرور',
        'permissions' => 'الصلاحيات',
        'personal_access_tokens' => 'رموز الوصول الشخصية',
        'revenue_distribution_rules' => 'قواعد توزيع الإيرادات',
        'roles' => 'الأدوار',
        'role_has_permissions' => 'أدوار وصلاحيات',
        'sessions' => 'الجلسات',
        'tasks' => 'المهام',
        'transactions' => 'المعاملات',
        'transaction_categories' => 'فئات المعاملات',
        'users' => 'المستخدمين',
        'workflows' => 'سير العمل',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('record_id')
                    ->label('رقم السجل')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التنفيذ')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()->label('حذف'),
            ]) 
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
            ]);
    }

    /**
     * تحميل العلاقة user مسبقًا لتجنب مشكلة N+1
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
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
