<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ChoiceController extends Controller
{
   

    public function store(Request $request, $questionId)
    {
        $question = Question::findOrFail($questionId);

        Gate::authorize('create', Choice::class); 

        $validated = $request->validate([
            'choice_text' => 'required|string|max:255',
            'is_correct' => 'required|boolean',
        ]);

        $choice = $question->choices()->create([
            'admin_id' => Auth::id(),
            'choice_text' => $validated['choice_text'],
            'is_correct' => $validated['is_correct'],
        ]);

        return response()->json($choice, 201);
    }

    public function update(Request $request, Choice $choice)
    {
        Gate::authorize('update', $choice);

        $validated = $request->validate([
            'choice_text' => 'sometimes|string|max:255',
            'is_correct' => 'sometimes|boolean',
        ]);

        $choice->update($validated);

        return response()->json($choice);
    }

    public function destroy(Choice $choice)
    {
        Gate::authorize('delete', $choice); 

        $choice->delete();
        return response()->json(['message' => 'Choice deleted successfully'], 200);
    }
}
