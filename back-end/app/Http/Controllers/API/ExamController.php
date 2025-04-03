<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ExamController extends Controller
{
  
    public function index()
    {
        Gate::authorize('viewAny', Exam::class);

        return Exam::with(['admin', 'candidats'])->get();
    }

   
    public function store(Request $request)
    {
        Gate::authorize('create', Exam::class);

        $validated = $request->validate([
            'type' => 'required|in:théorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100',
            'places_max' => 'required|integer|min:1'
        ]);

        $exam = Exam::create([
            ...$validated,
            'admin_id' => Auth::id(), 
        ]);

        return response()->json($exam->load('admin'), 201);
    }

  
    public function show(Exam $exam)
    {
        Gate::authorize('view', $exam);

        return $exam->load(['admin', 'candidats']);
    }

    public function update(Request $request, Exam $exam)
    {
        Gate::authorize('update', $exam);

        $validated = $request->validate([
            'type' => 'sometimes|in:théorique,pratique',
            'date_exam' => 'sometimes|date|after:now',
            'lieu' => 'sometimes|string|max:100',
            'places_max' => 'sometimes|integer|min:1'
        ]);

        $exam->update($validated);
        return $exam->load('admin');
    }


    public function destroy(Exam $exam)
    {
        Gate::authorize('delete', $exam);

        $exam->delete();
        return response()->noContent();
    }

    public function addCandidat(Request $request, Exam $exam)
    {
        Gate::authorize('addCandidat', $exam);

        $request->validate([
            'candidat_id' => 'required|exists:users,id'
        ]);

        $exam->candidats()->attach($request->candidat_id);
        return response()->json($exam->load('candidats'));
    }

  
    public function saveResult(Request $request, Exam $exam, User $candidat)
    {
        Gate::authorize('manageResults', $exam);

        $request->validate([
            'resultat' => 'required|integer|between:0,100',
            'observations' => 'nullable|string'
        ]);

        $exam->candidats()->updateExistingPivot($candidat->id, [
            'resultat' => $request->resultat,
            'observations' => $request->observations
        ]);

        return response()->json($exam->load('candidats'));
    }
}
