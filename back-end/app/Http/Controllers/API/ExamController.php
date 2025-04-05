<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{

    public function index()
    {
        Gate::authorize('viewAny', Exam::class);
    
        $query = Exam::with(['admin', 'moniteur', 'candidats']);
        $user = Auth::user();
    
        if ($user->roles->contains('name', 'moniteur')) {
            $query->where('moniteur_id', $user->id);
        } 
        elseif ($user->roles->contains('name', 'candidat')) {
            $query->whereHas('candidats', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }
    
        return $query->latest()->paginate(10);
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

        return response()->json($exam->load(['admin', 'moniteur']), 201);
    }

    public function show(Exam $exam)
    {
        Gate::authorize('view', $exam);
        return $exam->load(['admin', 'moniteur', 'candidats']);
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

        return $exam->load(['admin', 'moniteur']);
    }

    public function destroy(Exam $exam)
    {
        Gate::authorize('delete', $exam);
        $exam->delete();
        return response()->noContent();
    }

    public function addCandidat(Request $request, Exam $exam)
    {
        Gate::authorize('manageCandidats', $exam);

        $request->validate([
            'candidat_id' => 'required|exists:users,id'
        ]);

        if ($exam->candidats()->count() >= $exam->places_max) {
            return response()->json(['message' => 'Nombre maximum de candidats atteint'], 422);
        }

        $exam->candidats()->syncWithoutDetaching([$request->candidat_id]);

        return response()->json($exam->load('candidats'));
    }

    public function recordResult(Request $request, Exam $exam, User $candidat)
    {
        Gate::authorize('recordResults', $exam);

        $request->validate([
            'present' => 'required|boolean',
            'resultat' => 'required_if:present,true|in:excellent,tres_bien,bien,moyen,insuffisant',
            'score' => 'required_if:present,true|integer|between:0,100',
            'observations' => 'nullable|string',
            'feedbacks' => 'nullable|string'
        ]);

        $exam->candidats()->updateExistingPivot($candidat->id, [
            'present' => $request->present,
            'resultat' => $request->present ? $request->resultat : null,
            'score' => $request->present ? $request->score : null,
            'observations' => $request->observations,
            'feedbacks' => $request->feedbacks
        ]);

        $exam->updateStats();

        return response()->json($exam->load('candidats'));
    }

//candidats
    public function VuDatesExam(Request $request)
    {
        $user = Auth::user();
        
        $query = Exam::with(['moniteur'])
            ->whereHas('candidat', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->orderBy('date_exam', 'desc');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }

        return $query->paginate(10);
    }

    public function RsultatsEXma($id)
    {
        $user = Auth::user();
        $exam = Exam::with(['moniteur'])
            ->whereHas('candidats', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->findOrFail($id);

        $exam->load(['candidat' => function($query) use ($user) {
            $query->where('users.id', $user->id);
        }]);

        return response()->json($exam);
    }
}