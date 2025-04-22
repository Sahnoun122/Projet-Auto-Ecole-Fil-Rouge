<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ExamScheduled;
use App\Notifications\ExamResultPublished;

class ExamController extends Controller
{
    public function index()
    {
        $search = request('search');
        
        $exams = Exam::with(['admin', 'candidat', 'participants'])
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('lieu', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%")
                      ->orWhere('statut', 'like', "%{$search}%")
                      ->orWhereHas('candidat', function($q) use ($search) {
                          $q->where('nom', 'like', "%{$search}%")
                            ->orWhere('prenom', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate(10);

        $candidats = User::where('role', 'candidat')->get(['id', 'nom', 'prenom']);
        
        return view('admin.exams', compact('exams', 'candidats'));
    }

    public function create()
    {
        return redirect()->route('admin.exams');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:theorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100',
            'places_max' => 'required|integer|min:1|max:50',
            'candidat_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string|max:500',
            'statut' => 'required|in:planifie,en_cours,termine,annule'
        ]);

        $exam = Exam::create([
            ...$validated,
            'admin_id' => Auth::id()
        ]);

        if ($exam->candidat_id) {
            $exam->candidat->notify(new ExamScheduled($exam));
        }

        return redirect()->route('admin.exams')->with('success', 'Examen créé avec succès');
    }

    public function edit(Exam $exam)
    {
        $candidats = User::where('role', 'candidat')->get(['id', 'nom', 'prenom']);
        return view('admin.exams.edit', compact('exam', 'candidats'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'type' => 'required|in:theorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100',
            'places_max' => 'required|integer|min:1|max:50',
            'candidat_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string|max:500',
            'statut' => 'required|in:planifie,en_cours,termine,annule'
        ]);

        $exam->update($validated);

        return redirect()->route('admin.exams')->with('success', 'Examen mis à jour');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams')->with('success', 'Examen supprimé');
    }

    public function show(Exam $exam)
    {
        $exam->load(['candidat', 'participants']);
        $results = $exam->participants;
        
        return view('admin.exams', compact('exam', 'results'));
    }

    public function createResult(Exam $exam)
    {
        $candidats = User::where('role', 'candidat')->get();
        return view('admin.exams.results.create', compact('exam', 'candidats'));
    }

    public function storeResult(Request $request, Exam $exam)
    {
        $data = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'candidat_id' => 'required|exists:users,id',
            'present' => 'required|boolean',
            'resultat' => 'required|in:excellent,tres_bien,bien,moyen,insuffisant',
            'score' => 'required|integer|min:0|max:100',
            'feedbacks' => 'nullable|string|max:500'
        ]);
    
        $exam->participants()->attach($data['candidat_id'], [
            'present' => $data['present'],
            'resultat' => $data['resultat'],
            'score' => $data['score'],
            'feedbacks' => $data['feedbacks'] ?? null
        ]);
    
        $candidat = User::find($data['candidat_id']);
        $candidat->notify(new ExamResultPublished($exam));
    
        return back()->with('success', 'Résultat enregistré !');
    }
    public function editResult(Exam $exam, User $candidat)
    {
        $result = $exam->participants()->where('user_id', $candidat->id)->first();
        return view('admin.exams.results', compact('exam', 'candidat', 'result'));
    }

    public function updateResult(Request $request, Exam $exam, User $candidat)
    {
        $data = $request->validate([
            'present' => 'required|boolean',
            'resultat' => 'required|in:excellent,tres_bien,bien,moyen,insuffisant',
            'score' => 'required|integer|min:0|max:100',
            'feedbacks' => 'nullable|string|max:500'
        ]);

        $exam->participants()->updateExistingPivot($candidat->id, $data);

        return redirect()->route('admin.exams', $exam->id)
            ->with('success', 'Résultat mis à jour !');
    }
    public function checkResult(Exam $exam, User $candidat)
{
    $result = $exam->participants()
        ->where('user_id', $candidat->id)
        ->first();

    return response()->json([
        'exists' => $result !== null,
        'result' => $result ? [
            'present' => $result->pivot->present,
            'score' => $result->pivot->score,
            'resultat' => $result->pivot->resultat,
            'feedbacks' => $result->pivot->feedbacks
        ] : null
    ]);
}


public function candidatExams()
{
    $user = Auth::id();
    
    $plannedExams = Exam::where('candidat_id', $user)
                        ->whereIn('statut', ['planifie', 'en_cours'])
                        ->with('admin')
                        ->orderBy('date_exam', 'asc')
                        ->get();

    $examResults = Exam::where('candidat_id', $user)
                      ->where('statut', 'termine')
                      ->with(['admin', 'participants' => function($query) use ($user) {
                          $query->where('user_id', $user);
                      }])
                      ->orderBy('date_exam', 'desc')
                      ->get();

    return view('candidat.exams', compact('plannedExams', 'examResults'));
}

public function showCandidatExam(Exam $exam)
{
    $user = Auth::id();
    
    if ($exam->candidat_id !== $user) {
        abort(403);
    }

    $result = $exam->participants()->where('user_id', $user)->first();

    return view('candidat.exams', compact('exam', 'result'));
}
}