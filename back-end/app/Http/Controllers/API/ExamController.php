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

  
}