<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogalAssistantBot;
use Illuminate\Http\Request;

class LogalAssistantBotController extends Controller
{
    // ✅ عرض السجلات الخاصة بالمستخدم المصادق عليه فقط
    public function index(Request $request)
    {
        $user = $request->user();

        $bots = LogalAssistantBot::with(['user', 'sourceLaw'])
            ->where('user_id', $user->id)
            ->get();

        return response()->json($bots);
    }

    // ✅ عرض سجل واحد
    public function show(LogalAssistantBot $logalAssistantBot)
    {
        return response()->json($logalAssistantBot->load(['user', 'sourceLaw']));
    }

    // ✅ إنشاء سجل جديد مرتبط بالمستخدم المصادق عليه تلقائيًا
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'question' => 'required|string',
            'response' => 'nullable|string',
            'source_law_id' => 'nullable|exists:laws_documents,id',
        ]);

        $data['user_id'] = $user->id;

        $bot = LogalAssistantBot::create($data);

        return response()->json($bot, 201);
    }

    // ✅ تحديث سجل (بدون تغيير user_id)
    public function update(Request $request, LogalAssistantBot $logalAssistantBot)
    {
        $data = $request->validate([
            'question' => 'sometimes|required|string',
            'response' => 'nullable|string',
            'source_law_id' => 'nullable|exists:laws_documents,id',
        ]);

        $logalAssistantBot->update($data);

        return response()->json($logalAssistantBot);
    }

    // ✅ حذف سجل
    public function destroy(LogalAssistantBot $logalAssistantBot)
    {
        $logalAssistantBot->delete();

        return response()->json(null, 204);
    }
}
