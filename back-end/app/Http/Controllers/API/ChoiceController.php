<?php
namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ChoiceController extends Controller
{
    public function store(Request $request, Question $question)
    {
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
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'choice' => $choice]);
        }
        
        return redirect()->route('questions.index', $question->quiz)->with('success', 'Choix ajouté avec succès!');
    }

    public function update(Request $request, Choice $choice)
    {
        Gate::authorize('update', $choice);
        
        $validated = $request->validate([
            'choice_text' => 'sometimes|string|max:255',
            'is_correct' => 'sometimes|boolean',
        ]);
        
        $choice->update($validated);
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('questions.index', $choice->question->quiz)->with('success', 'Choix mis à jour avec succès!');
    }

    public function destroy(Choice $choice)
    {
        Gate::authorize('delete', $choice);
        
        $quiz = $choice->question->quiz;
        $choice->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('questions.index', $quiz)->with('success', 'Choix supprimé avec succès!');
    }
}