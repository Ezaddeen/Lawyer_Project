<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityObserver
{
    /**
     * حدث عند إنشاء سجل جديد.
     */
    public function created($model)
    {
        $this->logActivity('create', $model);
    }

    /**
     * حدث عند تحديث سجل.
     */
    public function updated($model)
    {
        $this->logActivity('update', $model);
    }

    /**
     * حدث عند حذف سجل.
     */
    public function deleted($model)
    {
        $this->logActivity('delete', $model);
    }

    /**
     * دالة لتسجيل النشاط.
     */
    protected function logActivity(string $action, $model)
    {
        // إذا لم يكن هناك مستخدم مسجل (مثل Seeder أو عملية تلقائية) تجاهل التسجيل
        if (!Auth::check()) {
            return;
        }

        // استخرج اسم الجدول و رقم السجل
        $table = $model->getTable();
        $recordId = $model->id ?? null;

        // لا تسجل نشاطات جدول activity_logs نفسه (حتى لا يدخل في حلقة لا نهائية)
        if ($table === 'activity_logs') {
            return;
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'table_name' => $table,
            'record_id' => $recordId,
        ]);
    }
}
