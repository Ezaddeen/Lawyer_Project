<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminAgentBot;
use Illuminate\Http\Request;

class AdminAgentBotController extends Controller
{
    public function index()
    {
        return response()->json(AdminAgentBot::with('adminUser')->get());
    }

    public function show($id)
    {
        $bot = AdminAgentBot::with('adminUser')->findOrFail($id);
        return response()->json($bot);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'admin_user_id' => 'required|exists:users,id',
            'task' => 'required|string',
            'result' => 'nullable|string',
        ]);

        $bot = AdminAgentBot::create($data);
        return response()->json($bot, 201);
    }

    public function update(Request $request, $id)
    {
        $bot = AdminAgentBot::findOrFail($id);

        $data = $request->validate([
            'admin_user_id' => 'sometimes|exists:users,id',
            'task' => 'sometimes|required|string',
            'result' => 'nullable|string',
        ]);

        $bot->update($data);
        return response()->json($bot);
    }

    public function destroy($id)
    {
        AdminAgentBot::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
