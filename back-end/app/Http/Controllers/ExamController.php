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
        
        $exams = Exam::with(['admin', 'candidat'])
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

    // Mettre à jour un examen
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

    // Supprimer un examen
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams')->with('success', 'Examen supprimé');
    }

    public function showResults(Exam $exam, User $candidat)
    {
        if ($exam->candidat_id !== $candidat->id) {
            abort(404);
        }
    
        $result = $exam->participants()->where('user_id', $candidat->id)->first();
    
        $chartData = [
            'labels' => [],
            'scores' => [],
            'resultats' => []
        ];
    
        // Charger tous les résultats du candidat pour les graphiques
        $allResults = $candidat->exams()
            ->withPivot(['score', 'resultat'])
            ->orderBy('date_exam')
            ->get();
    
        foreach ($allResults as $res) {
            if ($res->pivot->score !== null) {
                $chartData['labels'][] = ucfirst($res->type) . ' - ' . $res->date_exam->format('d/m');
                $chartData['scores'][] = $res->pivot->score;
                $chartData['resultats'][] = $res->pivot->resultat;
            }
        }
    
        return view('admin.resultats', compact('exam', 'candidat', 'result', 'chartData'));
    }

    public function storeResult(Request $request, User $candidat)
    {
        $data = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'present' => 'required|boolean',
            'resultat' => 'required|in:excellent,tres_bien,bien,moyen,insuffisant',
            'score' => 'required|integer|min:0|max:100',
            'feedbacks' => 'nullable|string|max:500'
        ]);

        $exam = Exam::find($data['exam_id']);
        $exam->participants()->attach($candidat->id, $data);

        $candidat->notify(new ExamResultPublished($exam));

        return back()->with('success', 'Résultat enregistré !');
    }

    public function updateResult(Request $request, User $candidat, Exam $exam)
    {
        $data = $request->validate([
            'present' => 'required|boolean',
            'resultat' => 'required|in:excellent,tres_bien,bien,moyen,insuffisant',
            'score' => 'required|integer|min:0|max:100',
            'feedbacks' => 'nullable|string|max:500'
        ]);

        $exam->participants()->updateExistingPivot($candidat->id, $data);

        return back()->with('success', 'Résultat mis à jour !');
    }

    public function destroyResult(User $candidat, Exam $exam)
    {
        $exam->participants()->detach($candidat->id);
        return back()->with('success', 'Résultat supprimé !');
    }
}