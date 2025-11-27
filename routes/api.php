<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LogalAssistantBotController;
use App\Http\Controllers\Api\AdminAgentBotController;
use App\Http\Controllers\Api\BotFeedbakController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TaskController;

// Route::middleware('auth:api')->prefix('logal-assistant-bots')->group(function () {
//     Route::get('/', [LogalAssistantBotController::class, 'index']);        // عرض محادثات المستخدم
//     Route::post('/', [LogalAssistantBotController::class, 'store']);       // إنشاء محادثة جديدة
//     Route::get('/{id}', [LogalAssistantBotController::class, 'show']);   // عرض محادثة محددة
//     Route::put('/{id}', [LogalAssistantBotController::class, 'update']); // تعديل محادثة
//     Route::delete('/{id}', [LogalAssistantBotController::class, 'destroy']); // حذف محادثة
// });

Route::apiResource('logal-assistant-bots', LogalAssistantBotController::class)
    ->middleware('auth:api');

Route::middleware('auth:api')->prefix('admin-agent-bots')->group(function () {
    Route::get('/', [AdminAgentBotController::class, 'index']);
    Route::post('/', [AdminAgentBotController::class, 'store']);
    Route::get('/{id}', [AdminAgentBotController::class, 'show']);
    Route::put('/{id}', [AdminAgentBotController::class, 'update']);
    Route::delete('/{id}', [AdminAgentBotController::class, 'destroy']);
});

Route::prefix('bot-feedbaks')->group(function () {
    Route::get('/', [BotFeedbakController::class, 'index']);
    Route::post('/', [BotFeedbakController::class, 'store']);
    Route::get('/{id}', [BotFeedbakController::class, 'show']);
    Route::put('/{id}', [BotFeedbakController::class, 'update']);
    Route::delete('/{id}', [BotFeedbakController::class, 'destroy']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::middleware('auth:api')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/new', [NotificationController::class, 'newNotifications']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
});


Route::middleware('auth:api')->prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/{id}', [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'store']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);
});

