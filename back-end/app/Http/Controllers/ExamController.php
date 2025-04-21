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

    // Récupérer un examen pour édition (AJAX)
    public function edit(Exam $exam)
    {
        return response()->json([
            'type' => $exam->type,
            'date_exam' => $exam->date_exam->format('Y-m-d\TH:i'),
            'lieu' => $exam->lieu,
            'places_max' => $exam->places_max,
            'statut' => $exam->statut,
            'candidat_id' => $exam->candidat_id,
            'instructions' => $exam->instructions
        ]);
    }

    // Stocker un nouvel examen
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:theorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s\-.,\'àâäéèêëîïôöùûüçÀÂÄÉÈÊËÎÏÔÖÙÛÜÇ]{3,100}$/',
            'places_max' => 'required|integer|min:1|max:50',
            'candidat_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string|max:500',
            'statut' => 'required|in:planifie,en_cours,termine,annule'
        ]);

        $exam = Exam::create([
            ...$validated,
            'admin_id' => Auth::id()
        ]);

        return redirect()->route('admin.exams')->with('success', 'Examen créé avec succès');
    }

    // Mettre à jour un examen
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'type' => 'required|in:theorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s\-.,\'àâäéèêëîïôöùûüçÀÂÄÉÈÊËÎÏÔÖÙÛÜÇ]{3,100}$/',
            'places_max' => 'required|integer|min:1|max:50',
            'candidat_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string|max:500',
            'statut' => 'required|in:planifie,en_cours,termine,annule'
        ]);

        $exam->update($validated);

        return redirect()->route('admin.exams')->with('success', 'Examen mis à jour avec succès');
    }


        // Supprimer un examen
        public function destroy(Exam $exam)
        {
            $exam->delete();
            return redirect()->route('admin.exams')->with('success', 'Examen supprimé avec succès');
        }
    

    // Afficher les résultats d'un candidat
    public function showCandidateResults(User $candidat)
    {
        $candidat->load(['exams' => function($query) {
            $query->withPivot(['present', 'resultat', 'score', 'feedbacks'])
                  ->orderBy('date_exam', 'desc');
        }]);
    
        // Préparer les données pour les graphiques
        $chartData = [
            'labels' => [],
            'scores' => [],
            'resultats' => []
        ];
    
        foreach ($candidat->exams as $exam) {
            if ($exam->pivot->score !== null) {
                $chartData['labels'][] = $exam->type . ' - ' . $exam->date_exam->format('d/m');
                $chartData['scores'][] = $exam->pivot->score;
                $chartData['resultats'][] = $exam->pivot->resultat;
            }
        }
    
        $availableExams = Exam::whereDoesntHave('participants', function($query) use ($candidat) {
            $query->where('user_id', $candidat->id);
        })->get();
    
        return view('admin.exams.results', compact('candidat', 'chartData', 'availableExams'));
    }
    
    // Stocker un résultat d'examen
    public function storeResult(Request $request, User $candidat, Exam $exam)
    {
        $request->validate([
            'present' => 'required|boolean',
            'resultat' => 'required|in:excellent,tres_bien,bien,moyen,insuffisant',
            'score' => 'required|integer|min:0|max:100',
            'feedbacks' => 'nullable|string'
        ]);
    
        $exam->participants()->syncWithoutDetaching([
            $candidat->id => $request->only(['present', 'resultat', 'score', 'feedbacks'])
        ]);
        
        $candidat->notify(new ExamResultPublished($exam));

        return redirect()->route('admin.results.show', $candidat)->with('success', 'Résultat enregistré avec succès');
    }
}