<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChoiceController extends Controller
{
    public function store(Request $request, $questionId)
    {
        $validated = $request->validate([
            'choice_text' => 'required|string|max:255',
            'is_correct' => 'required|boolean',
        ]);

        $choice = Choice::create([
            'question_id' => $questionId,
            'admin_id' => Auth::id(),
            'choice_text' => $validated['choice_text'],
            'is_correct' => $validated['is_correct'],
        ]);

        return response()->json([
            'message' => 'Choice created successfully',
            'data' => $choice
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $choice = Choice::findOrFail($id);

        $validated = $request->validate([
            'choice_text' => 'sometimes|string|max:255',
            'is_correct' => 'sometimes|boolean',
        ]);

        $choice->update($validated);

        return response()->json([
            'message' => 'Choice updated successfully',
            'data' => $choice
        ]);
    }

    public function destroy($id)
    {
        $choice = Choice::findOrFail($id);
        $choice->delete();

        return response()->json([
            'message' => 'Choice deleted successfully'
        ], 200);
    }
}
