<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Title;
use App\Models\Quiz;

use App\Models\CoursConduite;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class MoniteurController extends Controller
{
    
    public function dashboard()
    {
        return view('moniteur.dashboard'); 
    }
    

    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $monitors = User::where('role', 'moniteur')
            ->when($search, function($query) use ($search) {
                return $query->where('nom', 'like', "%$search%")
                             ->orWhere('prenom', 'like', "%$search%")
                             ->orWhere('email', 'like', "%$search%")
                             ->orWhere('telephone', 'like', "%$search%")
                             ->orWhere('type_permis', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('admin.monitors', compact('monitors'));
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
            'photo_identite' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'type_permis' => 'required|string|max:255',
            'certifications' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'qualifications' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
        ]);

        $validated['photo_profile'] = $request->file('photo_profile')->store('monitors/profile', 'public');
        $validated['photo_identite'] = $request->file('photo_identite')->store('monitors/identite', 'public');
        $validated['certifications'] = $request->file('certifications')->store('monitors/certifications', 'public');
        $validated['qualifications'] = $request->file('qualifications')->store('monitors/qualifications', 'public');
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'moniteur';

        User::create($validated);

        return redirect()->route('admin.monitors.index')->with('success', 'Moniteur ajouté avec succès');
    }

    public function show($id)
    {
        $monitor = User::findOrFail($id);
        return response()->json($monitor);
    }

    public function edit($id)
    {
        $monitor = User::findOrFail($id);
        return response()->json($monitor);
    }

    public function update(Request $request, $id)
    {
        $monitor = User::findOrFail($id);

        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $monitor->id,
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'type_permis' => 'required|string|max:255',
        ];

        if ($request->hasFile('photo_profile')) {
            $rules['photo_profile'] = 'image|mimes:jpeg,png,jpg|max:2048';
        }
        if ($request->hasFile('photo_identite')) {
            $rules['photo_identite'] = 'image|mimes:jpeg,png,jpg|max:2048';
        }
        if ($request->hasFile('certifications')) {
            $rules['certifications'] = 'file|mimes:pdf,doc,docx|max:2048';
        }
        if ($request->hasFile('qualifications')) {
            $rules['qualifications'] = 'file|mimes:pdf,doc,docx|max:2048';
        }

        $data = $request->validate($rules);

        if ($request->hasFile('photo_profile')) {
            Storage::disk('public')->delete($monitor->photo_profile);
            $data['photo_profile'] = $request->file('photo_profile')->store('monitors/profile', 'public');
        }
        if ($request->hasFile('photo_identite')) {
            Storage::disk('public')->delete($monitor->photo_identite);
            $data['photo_identite'] = $request->file('photo_identite')->store('monitors/identite', 'public');
        }
        if ($request->hasFile('certifications')) {
            Storage::disk('public')->delete($monitor->certifications);
            $data['certifications'] = $request->file('certifications')->store('monitors/certifications', 'public');
        }
        if ($request->hasFile('qualifications')) {
            Storage::disk('public')->delete($monitor->qualifications);
            $data['qualifications'] = $request->file('qualifications')->store('monitors/qualifications', 'public');
        }

        $monitor->update($data);

        return redirect()->route('admin.monitors.index')->with('success', 'Moniteur mis à jour avec succès');
    }

    public function destroy($id)
    {
        $monitor = User::findOrFail($id);
                Storage::disk('public')->delete([
            $monitor->photo_profile,
            $monitor->photo_identite,
            $monitor->certifications,
            $monitor->qualifications
        ]);
        
        $monitor->delete();

        return redirect()->route('admin.monitors.index')->with('success', 'Moniteur supprimé avec succès');
    }


    //candiadts 

    public function candidats(Request $request)
    {
        $search = $request->input('search');
        
        $candidats = User::where('role', 'candidat')
            ->whereHas('coursConduites', function($query) {
                $query->where('moniteur_id', Auth::id());
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
}
