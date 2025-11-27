<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BotFeedbak;
use Illuminate\Http\Request;

class BotFeedbakController extends Controller
{
    public function index()
    {
        return response()->json(BotFeedbak::with('user')->get());
    }

    public function show($id)
    {
        $feedback = BotFeedbak::with('user')->findOrFail($id);
        return response()->json($feedback);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bot_kind' => 'required|in:LegalAssistant,AdminAgent',
            'user_id' => 'nullable|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $feedback = BotFeedbak::create($data);
        return response()->json($feedback, 201);
    }

    public function update(Request $request, $id)
    {
        $feedback = BotFeedbak::findOrFail($id);

        $data = $request->validate([
            'bot_kind' => 'sometimes|in:LegalAssistant,AdminAgent',
            'user_id' => 'nullable|exists:users,id',
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $feedback->update($data);
        return response()->json($feedback);
    }

    public function destroy($id)
    {
        BotFeedbak::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
