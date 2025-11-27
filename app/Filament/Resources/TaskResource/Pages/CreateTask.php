<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;


class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * بعد إنشاء المهمة بنجاح
     */
    protected function afterCreate(): void
    {
        $task = $this->record;

        // تأكد أن هناك مستخدم مرتبط بالمهمة
        if ($task->user) {
            Notification::make()
                ->title('تم تعيين مهمة جديدة لك')
                ->body("تمت إضافة مهمة بعنوان: {$task->title}")
                ->success()
                ->sendToDatabase($task->user);
        }
    }
}


