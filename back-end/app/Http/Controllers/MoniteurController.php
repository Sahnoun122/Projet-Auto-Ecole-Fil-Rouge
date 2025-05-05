<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Title;
use App\Models\Quiz;
use App\Models\Exam;
use App\Models\ExamFeedback;

use App\Models\CoursConduite;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MoniteurController extends Controller
{

    public function dashboard(){
        $moniteurId = Auth::id();

        $coursConduite = CoursConduite::where('moniteur_id', $moniteurId)
                                    ->with([
                                        'candidat',
                                        'candidatsAssignes' => function ($query) {
                                            $query->where('role', 'candidat');
                                        },
                                        'vehicule'
                                    ])
                                    ->orderBy('date_heure', 'desc')
                                    ->take(5)
                                    ->get();

        $candidatsAssignes = User::where('role', 'candidat')
            ->whereHas('coursConduites', function($q) use ($moniteurId) {
                $q->where('moniteur_id', $moniteurId);
            })
            ->limit(5)
            ->get();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $notifications = $user ? $user->unreadNotifications()->limit(5)->get() : collect();

       return view('moniteur.dashboard', compact('coursConduite', 'candidatsAssignes', 'notifications'));
    }
    
        public function index(Request $request)
        {
            $search = $request->input('search');
            
            $moniteurs = User::where('role', 'moniteur')
                ->when($search, function($query) use ($search) {
                    return $query->where('nom', 'like', "%$search%")
                                 ->orWhere('prenom', 'like', "%$search%")
                                 ->orWhere('email', 'like', "%$search%")
                                 ->orWhere('telephone', 'like', "%$search%")
                                 ->orWhere('type_permis', 'like', "%$search%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        
            return view('admin.monitors', compact('moniteurs'));
        }
    
        public function store(Request $request)
        {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'adresse' => 'required|string|max:255',
                'telephone' => 'required|string|max:20',
                'photo_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'photo_identite' => 'required|file|mimes:pdf|max:2048',
                'type_permis' => 'required|string|max:255',
                'certifications' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'qualifications' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
            ]);
    
            $validated['photo_profile'] = $request->file('photo_profile')->store('moniteurs/profile', 'public');
            $validated['photo_identite'] = $request->file('photo_identite')->store('moniteurs/identite', 'public');
            $validated['certifications'] = $request->file('certifications')->store('moniteurs/certifications', 'public');
            $validated['qualifications'] = $request->file('qualifications')->store('moniteurs/qualifications', 'public');
            $validated['password'] = Hash::make($validated['password']);
            $validated['role'] = 'moniteur';
    
            User::create($validated);
    
            return redirect()->route('admin.monitors.index')->with('success', 'Moniteur ajouté avec succès');
        }
    
        public function show($id)
        {
            $moniteur = User::findOrFail($id);
            return response()->json($moniteur);
        }
    
        public function edit($id)
        {
            $moniteur = User::findOrFail($id);
            return response()->json($moniteur);
        }
    
        public function update(Request $request, $id)
        {
            $moniteur = User::findOrFail($id);
    
            $rules = [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $moniteur->id,
                'adresse' => 'required|string|max:255',
                'telephone' => 'required|string|max:20',
                'type_permis' => 'required|string|max:255',
            ];
    
            if ($request->hasFile('photo_profile')) {
                $rules['photo_profile'] = 'image|mimes:jpeg,png,jpg|max:2048';
            }
            if ($request->hasFile('photo_identite')) {
                $rules['photo_identite'] = 'file|mimes:pdf|max:2048';
            }
            if ($request->hasFile('certifications')) {
                $rules['certifications'] = 'file|mimes:pdf,doc,docx|max:2048';
            }
            if ($request->hasFile('qualifications')) {
                $rules['qualifications'] = 'file|mimes:pdf,doc,docx|max:2048';
            }
    
            $data = $request->validate($rules);
    
            if ($request->hasFile('photo_profile')) {
                Storage::disk('public')->delete($moniteur->photo_profile);
                $data['photo_profile'] = $request->file('photo_profile')->store('moniteurs/profile', 'public');
            }
            if ($request->hasFile('photo_identite')) {
                Storage::disk('public')->delete($moniteur->photo_identite);
                $data['photo_identite'] = $request->file('photo_identite')->store('moniteurs/identite', 'public');
            }
            if ($request->hasFile('certifications')) {
                Storage::disk('public')->delete($moniteur->certifications);
                $data['certifications'] = $request->file('certifications')->store('moniteurs/certifications', 'public');
            }
            if ($request->hasFile('qualifications')) {
                Storage::disk('public')->delete($moniteur->qualifications);
                $data['qualifications'] = $request->file('qualifications')->store('moniteurs/qualifications', 'public');
            }
    
            $moniteur->update($data);
    
            return redirect()->route('admin.monitors.index')->with('success', 'Moniteur mis à jour avec succès');
        }
    
        public function destroy($id)
        {
            $moniteur = User::findOrFail($id);
            
            Storage::disk('public')->delete([
                $moniteur->photo_profile,
                $moniteur->photo_identite,
                $moniteur->certifications,
                $moniteur->qualifications
            ]);
            
            $moniteur->delete();
    
            return redirect()->route('admin.monitors.index')->with('success', 'Moniteur supprimé avec succès');
        }
    

    public function candidats(Request $request)
    {
        $search = $request->input('search');
        
        $candidats = User::where('role', 'candidat')
            ->where(function($query) {
                $query->whereHas('coursPrincipaux', function($q) {
                        $q->where('moniteur_id', Auth::id());
                    })
                    ->orWhereHas('coursConduites', function($q) {
                        $q->where('moniteur_id', Auth::id());
                    });
            })
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nom', 'like', "%$search%")
                      ->orWhere('prenom', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                });
            })
            ->paginate(10);
    
        return view('moniteur.candidats', compact('candidats', 'search'));
    }


    public function progression(User $candidat)
    {
        $this->checkCandidatAssignement($candidat);

        return view('moniteur.progression', compact('candidat'));
    }

    public function cours(User $candidat)
    {
        $this->checkCandidatAssignement($candidat);

        $titles = Title::where('type_permis', $candidat->type_permis)
            ->with(['courses' => function($query) use ($candidat) {
                $query->withCount(['views as viewed' => function($q) use ($candidat) {
                    $q->where('user_id', $candidat->id);
                }]);
            }])
            ->withCount('courses')
            ->get();

        return view('moniteur.cours', compact('candidat', 'titles'));
    }

    public function quiz(User $candidat)
    {
        $this->checkCandidatAssignement($candidat);

        $quizzes = Quiz::where('type_permis', $candidat->type_permis)
            ->with(['questions.answers' => function($query) use ($candidat) {
                $query->where('candidat_id', $candidat->id)
                    ->with('choice');
            }])
            ->withCount(['questions', 
                'questions as correct_answers_count' => function($query) use ($candidat) {
                    $query->whereHas('answers', function($q) use ($candidat) {
                        $q->where('candidat_id', $candidat->id)
                            ->whereHas('choice', function($q) {
                                $q->where('is_correct', true);
                            });
                    });
                }
            ])
            ->get()
            ->map(function($quiz) {
                $quiz->score = $quiz->correct_answers_count;
                $quiz->total_questions = $quiz->questions_count;
                $quiz->passed = $quiz->score >= Quiz::PASSING_SCORE;
                return $quiz;
            });

        return view('moniteur.quiz', compact('candidat', 'quizzes'));
    }

    public function quizResults(Quiz $quiz, User $candidat)
    {
        if ($candidat->role !== 'candidat') {
            abort(403, "Cet utilisateur n'est pas un candidat.");
        }

        $results = $quiz->getResults($candidat->id);

        return view('moniteur.quiz-results', [
            'quiz' => $quiz,
            'candidate' => $candidat,
            'results' => $results
        ]);
    }

    private function checkCandidatAssignement(User $candidat)
    {
        if ($candidat->role !== 'candidat' || 
            !CoursConduite::where('moniteur_id', Auth::id())
                ->where(function($q) use ($candidat) {
                    $q->where('candidat_id', $candidat->id)
                      ->orWhereHas('candidats', function($q) use ($candidat) {
                          $q->where('users.id', $candidat->id);
                      });
                })
                ->exists()) {
            abort(403, "Ce candidat ne vous est pas assigné");
        }
    }

    public function showAssignedExams(Request $request)
    {
        $search = $request->input('search');
        $moniteurId = Auth::id();

        $candidatIds = CoursConduite::where('moniteur_id', $moniteurId)
            ->pluck('candidat_id')
            ->merge(
                DB::table('presences_cours')
                    ->join('cours_conduites', 'presences_cours.cours_conduite_id', '=', 'cours_conduites.id')
                    ->where('cours_conduites.moniteur_id', $moniteurId)
                    ->pluck('presences_cours.candidat_id')
            )
            ->unique()
            ->filter()
            ->toArray();

        $assignedExamsQuery = Exam::whereIn('candidat_id', $candidatIds)
            ->with('candidat', 'result')
            ->orderBy('date_exam', 'desc');

        if ($search) {
            $assignedExamsQuery->where(function($query) use ($search) {
                $query->where('type', 'like', "%$search%")
                      ->orWhere('lieu', 'like', "%$search%")
                      ->orWhere('statut', 'like', "%$search%")
                      ->orWhereHas('candidat', function($q) use ($search) {
                          $q->where('nom', 'like', "%$search%")
                            ->orWhere('prenom', 'like', "%$search%");
                      });
            });
        }

        $assignedExams = $assignedExamsQuery->paginate(15);

        return view('moniteur.exams', compact('assignedExams', 'search'));
    }


    public function candidatExamResults(User $candidat)
    {
        $this->checkCandidatAssignment($candidat);
        
        $exams = Exam::where('candidat_id', $candidat->id)
            ->orWhereHas('participants', function($q) use ($candidat) {
                $q->where('candidat_id', $candidat->id);
            })
            ->with(['participants' => function($q) use ($candidat) {
                $q->where('candidat_id', $candidat->id);
            }])
            ->orderBy('date_exam', 'desc')
            ->get();
        
        $feedbacks = ExamFeedback::where('candidat_id', $candidat->id)
            ->with('exam')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $averageRating = $feedbacks->avg('school_rating');
    
        return view('moniteur.candidat-exam-results', compact('candidat', 'exams', 'feedbacks', 'averageRating'));
    }
    
    private function getAssignedCandidatIds()
    {
        return CoursConduite::where('moniteur_id', Auth::id())
            ->get()
            ->flatMap(function($cours) {
                return [$cours->candidat_id, ...$cours->candidats->pluck('id')];
            })
            ->unique()
            ->toArray();
    }
    
    private function checkCandidatAssignment(User $candidat)
    {
        $candidatIds = $this->getAssignedCandidatIds();
        
        if (!in_array($candidat->id, $candidatIds)) {
            abort(403, "Ce candidat ne vous est pas assigné");
        }
}
}