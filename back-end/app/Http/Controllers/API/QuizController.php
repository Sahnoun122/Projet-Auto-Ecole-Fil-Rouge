<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class QuizController extends Controller
{
   
    public function index()
    {
        Gate::authorize('viewAny', Quiz::class); 

        $quizzes = Quiz::with('admin')->get();
        return response()->json($quizzes);
    }


    public function store(Request $request)
{

     Gate::authorize('create', Quiz::class);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'admin_id' => 'sometimes|integer|exists:users,id' 
    ]);

    $quiz = Quiz::create([
        'admin_id' => $validated['admin_id'] ?? Auth::id(),
        'title' => $validated['title'],
        'description' => $validated['description'],
    ]);

    return response()->json($quiz, 201);
}

    public function show(Quiz $quiz)
    {
        Gate::authorize('view', $quiz); 

        $quiz->load('questions.choices');
        return response()->json($quiz);
    }

    public function update(Request $request, Quiz $quiz)
    {
        Gate::authorize('update', $quiz);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string'
        ]);

        $quiz->update($validated);

        return response()->json($quiz);
    }

    public function destroy(Quiz $quiz)
    {
        Gate::authorize('delete', $quiz); 

        $quiz->delete();
        return response()->json(['message' => 'Quiz deleted successfully.'], 200);
    }
}