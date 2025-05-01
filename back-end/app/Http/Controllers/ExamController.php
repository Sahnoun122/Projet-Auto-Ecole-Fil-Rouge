<?php
namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\ExamScheduled;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        
        $query = Exam::with(['admin', 'candidat', 'result']);

        
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('lieu', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('statut', 'like', "%{$search}%")
                  ->orWhereHas('candidat', function($subQuery) use ($search) {
                      $subQuery->where('nom', 'like', "%{$search}%")
                               ->orWhere('prenom', 'like', "%{$search}%");
                  });
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($statut = $request->input('statut')) {
            $query->where('statut', $statut);
        }

        $exams = $query->latest()->paginate(10);
        $candidats = User::where('role', 'candidat')->get();

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
    
            try {
                DB::beginTransaction();
    
                $exam = Exam::create([
                    ...$validated,
                    'admin_id' => Auth::id()
                ]);
    
                if ($exam->candidat_id) {
                    $candidat = User::find($exam->candidat_id);
                    if ($candidat && $candidat->email_notifications) {
                        $candidat->notify(new ExamScheduled($exam));
                        Log::info("Notification d'examen envoyée au candidat ID: {$candidat->id}");
                    }
                }
    
                DB::commit();
    
                return redirect()->route('admin.exams')
                    ->with('success', 'Examen créé avec succès.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Erreur création examen: " . $e->getMessage());
                return back()->with('error', 'Erreur lors de la création de l\'examen : ' . $e->getMessage());
            }
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
    
            try {
                DB::beginTransaction();
    
                $wasChanged = $exam->wasChanged(['date_exam', 'lieu', 'type']);
                $exam->update($validated);
    
                if ($exam->candidat_id && $wasChanged) {
                    $candidat = User::find($exam->candidat_id);
                    if ($candidat && $candidat->email_notifications) {
                        $candidat->notify(new ExamScheduled($exam));
                        Log::info("Notification de modification d'examen envoyée au candidat ID: {$candidat->id}");
                    }
                }
    
                DB::commit();
    
                return redirect()->route('admin.exams')
                    ->with('success', 'Examen mis à jour avec succès.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Erreur mise à jour examen: " . $e->getMessage());
                return back()->with('error', 'Erreur lors de la mise à jour de l\'examen : ' . $e->getMessage());
            }
        }
    
    
    public function destroy(Exam $exam)
    {
        try {
            DB::beginTransaction();

            $exam->delete();

            DB::commit();

            return redirect()->route('admin.exams.index')
                ->with('success', 'Examen supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression de l\'examen : ' . $e->getMessage());
        }
    }

  
    public function candidatExams()
    {
        $user = Auth::user();
        $candidatId = $user->id; // Use candidatId for clarity in closures
        
        $plannedExams = Exam::where('candidat_id', $candidatId)
            ->where('statut', 'planifie') // Also check status
            // ->where('date_exam', '>', now()) // Removed date check, rely on status
            ->orderBy('date_exam', 'asc')
            ->get();

        $completedExams = Exam::where('candidat_id', $candidatId)
            ->where('statut', 'termine') // Filter by status 'termine'
            ->with([
                'result' => function($query) use ($candidatId) { // Load result relationship
                    $query->where('user_id', $candidatId);
                }
                // Removed feedbacks loading
            ])
            ->orderBy('date_exam', 'desc')
            ->get();

        return view('candidats.exams', compact('plannedExams', 'completedExams'));
    }

    
    public function storeResult(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'resultat' => 'required|string|in:reussi,echoue,excellent,bien,moyen',
            'feedbacks' => 'nullable|string|max:1000',
            'present' => 'required|boolean',
        ]);

        
        if (!$exam->candidat_id) {
            
            
             return back()->with('error', 'Impossible d\'enregistrer les résultats : Aucun candidat n\'est assigné à cet examen.')->withInput();
        }

        try {
            DB::beginTransaction();

            
            $examResult = ExamResult::updateOrCreate(
                [
                    'exam_id' => $exam->id,
                    'user_id' => $exam->candidat_id 
                ],
                [                         
                    'score' => $validated['score'],
                    'resultat' => $validated['resultat'],
                    'feedbacks' => $validated['feedbacks'],
                    'present' => $validated['present'],
                    
                ]
            );

            
            if ($examResult) {
                $exam->statut = 'termine';
                $exam->save();
            }

            DB::commit();

            return redirect()->route('admin.exams')
                ->with('success', 'Résultats de l\'examen enregistrés avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur enregistrement résultat examen ID {$exam->id} pour user ID {$exam->candidat_id}: " . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'enregistrement des résultats : ' . $e->getMessage())->withInput();
        }
    }


    public function showExams() 
    {
        $candidatId = Auth::id();

        $plannedExams = Exam::where('statut', 'planifie')
                        
                            ->whereHas('candidats', function ($query) use ($candidatId) {
                                $query->where('user_id', $candidatId);
                            })
                            ->orderBy('date_exam', 'asc')
                            ->get();

        $completedExams = Exam::where('statut', 'termine')
                            ->whereHas('results', function ($query) use ($candidatId) {
                                $query->where('user_id', $candidatId);
                            })
                            ->with(['results' => function ($query) use ($candidatId) {
                                $query->where('user_id', $candidatId);
                            }, 'feedbacks' => function ($query) use ($candidatId) {
                                $query->where('user_id', $candidatId);
                            }])
                            ->orderBy('date_exam', 'desc')
                            ->get();

        return view('candidats.exams', compact('plannedExams', 'completedExams'));
    }
}