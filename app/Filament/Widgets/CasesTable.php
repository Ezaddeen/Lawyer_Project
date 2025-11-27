<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Legalcase;
use Illuminate\Database\Eloquent\Builder;

class CasesTable extends BaseWidget
{
    protected static ?string $heading = 'جدول القضايا';
   // protected static ?string $emptyStateHeading = 'لا توجد قضايا';
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): ?Builder
    {
        return Legalcase::query();
    }

    protected function getTableColumns(): array
    {
       return [
            Tables\Columns\TextColumn::make('case_number')
                ->label('رقم القضية')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('title')
                ->label('الموضوع')
                ->limit(30)
                ->searchable(),

            Tables\Columns\TextColumn::make('client.name')
                ->label('العميل')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('lawyer.name')
                ->label('المحامي')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('court.name')
                ->label('المحكمة')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('client_role')
                ->label('صفة العميل'),

            Tables\Columns\TextColumn::make('category')
                ->label('التصنيف'),

            Tables\Columns\TextColumn::make('status')
                ->label('الحالة')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'قيد النظر' => 'warning',
                    'منتهية بحكم' => 'danger',
                    'معلقة' => 'gray',
                    'مؤجلة' => 'gray',
                    'مغلقة' => 'secondary',
                    'منتهية بصلح' => 'success',
                    'منتهية بتنازل' => 'success',
                    'متوقفة' => 'gray',
                    default => 'secondary',
                }),

            Tables\Columns\TextColumn::make('received_at')
                ->label('تاريخ الاستلام')
                ->date(),

            Tables\Columns\TextColumn::make('ended_at')
                ->label('تاريخ الانتهاء')
                ->date(),

            Tables\Columns\TextColumn::make('office_file_no')
                ->label('رقم ملف المكتب')
                ->sortable(),

            Tables\Columns\TextColumn::make('note')
                ->label('ملاحظات')
                ->limit(30),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('status')
                ->label('الحالة')
                ->options([
                    'قيد النظر' => 'قيد النظر',
                    'منتهية بحكم' => 'منتهية بحكم',
                    'معلقة' => 'معلقة',
                    'مؤجلة' => 'مؤجلة',
                    'مغلقة' => 'مغلقة',
                    'منتهية بصلح' => 'منتهية بصلح',
                    'منتهية بتنازل' => 'منتهية بتنازل',
                    'متوقفة' => 'متوقفة',
                ]),

            Tables\Filters\SelectFilter::make('category')
                ->label('التصنيف')
                ->options([
                    'جنائي' => 'جنائي',
                    'مدني' => 'مدني',
                    'تجاري' => 'تجاري',
                    'أحوال شخصية' => 'أحوال شخصية',
                    'عمالي' => 'عمالي',
                    'أخرى' => 'أخرى',
                ]),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            // Tables\Actions\ViewAction::make(),
            // Tables\Actions\EditAction::make(),
            // Tables\Actions\DeleteAction::make(),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\DeleteBulkAction::make(),
        ];
    }
    protected function getTableEmptyStateHeading(): ?string
{
    return 'لا توجد قضايا حالياً';
}
}

