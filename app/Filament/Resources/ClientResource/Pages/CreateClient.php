<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * بعد إنشاء العميل بنجاح
     */
    protected function afterCreate(): void
    {
        $client = $this->record;

        // المستخدم الذي أضاف العميل (المستخدم الحالي)
        $user = auth()->user();

        // إرسال الإشعار إليه فقط
        Notification::make()
            ->title('تم إضافة العميل بنجاح')
            ->body("تمت إضافة العميل: {$client->name}")
            ->success() // اللون الأخضر في الجرس
            ->sendToDatabase($user);
    }
}
