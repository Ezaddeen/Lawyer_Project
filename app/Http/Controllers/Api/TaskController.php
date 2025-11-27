<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // عرض جميع المهام للمستخدم الحالي
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return response()->json($tasks);
    }

    // عرض مهمة معينة
    public function show($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($task);
    }

    // إنشاء مهمة جديدة
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'priority' => 'in:High,Normal,Low',
            'status' => 'in:Not Started,In Progress,Completed,Deferred,Waiting',
            'percent_complete' => 'integer|min:0|max:100',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'finished_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();
        $task = Task::create($data);

        return response()->json($task, 201);
    }

    // تحديث مهمة
    public function update(Request $request, $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        $task->update($request->only([
            'title', 'priority', 'status', 'percent_complete',
            'description', 'due_date', 'finished_at', 'notes'
        ]));

        return response()->json($task);
    }

    // حذف مهمة
    public function destroy($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
