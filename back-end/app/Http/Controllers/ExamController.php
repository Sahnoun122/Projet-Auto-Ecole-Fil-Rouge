<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    // ADMIN PART
    public function index()
    {
        // Gate::authorize('viewAny', Exam::class);
        
        $exams = Exam::with(['admin', 'moniteur', 'candidat'])
            ->withCount('candidat')
            ->latest()
            ->paginate(10);
            
        $moniteurs = User::where('role', 'moniteur')->get();
        
        return view('admin.exams', compact('exams', 'moniteurs'));
    }

    public function create()
    {
        Gate::authorize('create', Exam::class);
        
        $moniteurs = User::where('role', 'moniteur')->get();
        return view('admin.exams.create', compact('moniteurs'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Exam::class);

        $validated = $request->validate([
            'type' => 'required|in:theorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100',
            'places_max' => 'required|integer|min:1',
            'moniteur_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string'
        ]);

        $exam = Exam::create([
            ...$validated,
            'admin_id' => Auth::id(),
            'statut' => 'planifie'
        ]);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Examen créé avec succès');
    }

    public function show(Exam $exam)
    {
        Gate::authorize('view', $exam);
        
        $exam->load(['admin', 'moniteur', 'candidats']);
        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        Gate::authorize('update', $exam);
        
        $moniteurs = User::where('role', 'moniteur')->get();
        return view('admin.exams.edit', compact('exam', 'moniteurs'));
    }

    public function update(Request $request, Exam $exam)
    {
        Gate::authorize('update', $exam);

        $validated = $request->validate([
            'type' => 'sometimes|in:theorique,pratique',
            'date_exam' => 'sometimes|date|after:now',
            'lieu' => 'sometimes|string|max:100',
            'places_max' => 'sometimes|integer|min:1',
            'statut' => 'sometimes|in:planifie,en_cours,termine,annule',
            'moniteur_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string'
        ]);

        $exam->update($validated);

        if ($exam->statut === 'termine') {
            $exam->updateStats();
        }

        return redirect()->route('admin.exams.index')
            ->with('success', 'Examen mis à jour avec succès');
    }

    public function destroy(Exam $exam)
    {
        Gate::authorize('delete', $exam);
        
        $exam->delete();
        return redirect()->route('admin.exams.index')
            ->with('success', 'Examen supprimé avec succès');
    }

    public function manageCandidates(Exam $exam)
    {
        Gate::authorize('manageCandidats', $exam);
        
        $availableCandidates = User::where('role', 'candidat')
            ->whereDoesntHave('exams', function($q) use ($exam) {
                $q->where('exam_id', $exam->id);
            })
            ->get();
            
        $registeredCandidates = $exam->candidats;
        
        return view('admin.exams.candidates', compact('exam', 'availableCandidates', 'registeredCandidates'));
    }

    public function addCandidate(Request $request, Exam $exam)
    {
        Gate::authorize('manageCandidats', $exam);

        $request->validate([
            'candidat_id' => 'required|exists:users,id'
        ]);

        if ($exam->candidats()->count() >= $exam->places_max) {
            return back()->with('error', 'Nombre maximum de candidats atteint');
        }

        $exam->candidats()->syncWithoutDetaching([$request->candidat_id]);

        return back()->with('success', 'Candidat ajouté avec succès');
    }

    public function removeCandidate(Request $request, Exam $exam)
    {
        Gate::authorize('manageCandidats', $exam);

        $request->validate([
            'candidat_id' => 'required|exists:users,id'
        ]);

        $exam->candidats()->detach($request->candidat_id);

        return back()->with('success', 'Candidat retiré avec succès');
    }

    // CANDIDAT PART
    public function candidateExams(Request $request)
    {
        $user = Auth::user();
        
        $exams = Exam::with(['moniteur'])
            ->whereHas('candidats', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->orderBy('date_exam', 'desc');
            
        if ($request->has('type')) {
            $exams->where('type', $request->type);
        }

        if ($request->has('statut')) {
            $exams->where('statut', $request->statut);
        }

        return view('candidat.exams.index', [
            'exams' => $exams->paginate(10),
            'filters' => $request->only(['type', 'statut'])
        ]);
    }

    public function examResults(Exam $exam)
    {
        $user = Auth::user();
        
        if (!$exam->candidats()->where('users.id', $user->id)->exists()) {
            abort(403);
        }

        $result = $exam->candidats()->where('users.id', $user->id)->first()->pivot;
        
        return view('candidat.exams.results', compact('exam', 'result'));
    }
}