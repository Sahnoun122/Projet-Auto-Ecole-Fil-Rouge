<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ExamScheduled;
use App\Notifications\ExamResultPublished;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['admin', 'candidat'])
            ->withCount(['participants as participants_count'])
            ->latest()
            ->paginate(10);

        $candidats = User::where('role', 'candidat')->get(['id', 'nom', 'prenom']);
        
        return view('admin.exams', compact('exams', 'candidats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:theorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100',
            'places_max' => 'required|integer|min:1',
            'candidat_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string'
        ]);

        $exam = Exam::create([
            ...$validated,
            'admin_id' => Auth::id(),
            'statut' => 'planifie'
        ]);

        // Notification et email
        if ($exam->candidat) {
            $exam->candidat->notify(new ExamScheduled($exam));
        }

        return response()->json([
            'success' => true,
            'message' => 'Examen créé avec succès',
            'exam' => $exam
        ]);
    }

    public function update(Request $request, Exam $exam)
    {
        Gate::authorize('update', $exam);

        $validated = $request->validate([
            'type' => 'required|in:theorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100',
            'places_max' => 'required|integer|min:1',
            'candidat_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string'
        ]);

        $exam->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Examen mis à jour avec succès'
        ]);
    }

    public function destroy(Exam $exam)
    {
        Gate::authorize('delete', $exam);
        $exam->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Examen supprimé avec succès'
        ]);
    }

    public function addResult(Request $request, Exam $exam)
    {
        $request->validate([
            'candidat_id' => 'required|exists:users,id',
            'present' => 'required|boolean',
            'resultat' => 'required|in:excellent,tres_bien,bien,moyen,insuffisant',
            'score' => 'required|integer|min:0|max:100',
            'feedbacks' => 'nullable|string'
        ]);

        $exam->participants()->syncWithoutDetaching([
            $request->candidat_id => $request->only(['present', 'resultat', 'score', 'feedbacks'])
        ]);

        $candidat = User::find($request->candidat_id);
        $candidat->notify(new ExamResultPublished($exam));

        return response()->json(['success' => true]);
    }

    // public function candidateExams(Request $request)
    // {
    //     $exams = Auth::user()->exams()
    //         ->with('admin')
    //         ->latest('date_exam')
    //         ->paginate(10);

    //     return view('candidate.exams', compact('exams'));
    // }

    public function examResults(Exam $exam)
    {
        $result = $exam->participants()
            ->where('user_id', Auth::id())
            ->first()
            ->pivot;

        return view('candidate.results', compact('exam', 'result'));
    }
}