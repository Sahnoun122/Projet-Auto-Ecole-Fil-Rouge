<?php


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        // Gate::authorize('view', $quiz);
        
        $questions = $quiz->questions()->with('choices')->get();
        
        return view('admin.questions', compact('quiz', 'questions'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        // Gate::authorize('create', Question::class);
        
        $validated = $request->validate([
            'question_text' => 'required|string',
            'image_path' => 'nullable|string',
            'duration' => 'required|integer|min:1',
        ]);
        
        $question = $quiz->questions()->create([
            'admin_id' => Auth::id(),
            'question_text' => $validated['question_text'],
            'image_path' => $validated['image_path'],
            'duration' => $validated['duration'],
        ]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'question' => $question]);
        }
        
        return redirect()->route('questions', $quiz)->with('success', 'Question ajoutée avec succès!');
    }

    public function update(Request $request, Question $question)
    {
        Gate::authorize('update', $question);
        
        $validated = $request->validate([
            'question_text' => 'sometimes|string',
            'image_path' => 'nullable|string',
            'duration' => 'sometimes|integer|min:1',
        ]);
        
        $question->update($validated);
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('questions', $question->quiz)->with('success', 'Question mise à jour avec succès!');
    }

    public function destroy(Question $question)
    {
        Gate::authorize('delete', $question);
        
        $quiz = $question->quiz;
        $question->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('questions', $quiz)->with('success', 'Question supprimée avec succès!');
    }
}