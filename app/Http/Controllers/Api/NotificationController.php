<?php

// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// class NotificationController extends Controller
// {
//     public function index(Request $request)
//     {
//         $user = $request->user();

//         return response()->json([
//             'notifications' => $user->notifications()->latest()->get(),
//         ]);
//     }

//     public function markAsRead(Request $request, $id)
//     {
//         $notification = $request->user()->notifications()->find($id);

//         if ($notification) {
//             $notification->markAsRead();
//             return response()->json(['message' => 'تم تعليم الإشعار كمقروء']);
//         }

//         return response()->json(['message' => 'الإشعار غير موجود'], 404);
//     }
// }


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // جميع الإشعارات للمستخدم الحالي
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'notifications' => $user->notifications()->latest()->get(),
        ]);
    }

    // إشعارات جديدة فقط
    public function newNotifications(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()
                              ->whereNull('read_at')
                              ->get();

        // تعليم كمقروء لتجنب التكرار
        foreach ($notifications as $notification) {
            $notification->markAsRead();
        }

        return response()->json($notifications);
    }

    // تعليم إشعار كمقروء يدوي
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'تم تعليم الإشعار كمقروء']);
        }

        return response()->json(['message' => 'الإشعار غير موجود'], 404);
    }
}
