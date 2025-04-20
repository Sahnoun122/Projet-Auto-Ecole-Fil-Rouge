<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ExamScheduled;
use App\Notifications\ExamResultPublished;
use Illuminate\Support\Facades\Notification;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['admin', 'candidat'])
            ->withCount(['participants as participants_count'])
            ->latest()
            ->paginate(10);

        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        Gate::authorize('create', Exam::class);
        $candidats = User::where('role', 'candidat')->get();
        return view('admin.exams.create', compact('candidats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:theorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100',
            'places_max' => 'required|integer|min:1',
            'candidat_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string'
        ]);

        $exam = Exam::create([
            ...$validated,
            'admin_id' => Auth::id(),
            'statut' => 'planifie'
        ]);

        // Envoyer notification au candidat
        if ($exam->candidat) {
            $exam->candidat->notify(new ExamScheduled($exam));
        }

        return redirect()->route('admin.exams.index')
            ->with('success', 'Examen créé avec succès');
    }

    public function show(Exam $exam)
    {
        Gate::authorize('view', $exam);
        $exam->load(['admin', 'candidat', 'participants']);
        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        Gate::authorize('update', $exam);
        $candidats = User::where('role', 'candidat')->get();
        return view('admin.exams.edit', compact('exam', 'candidats'));
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
            'candidat_id' => 'nullable|exists:users,id',
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

    public function addResult(Request $request, Exam $exam)
    {
        $request->validate([
            'candidat_id' => 'required|exists:users,id',
            'present' => 'required|boolean',
            'resultat' => 'required|in:excellent,tres_bien,bien,moyen,insuffisant',
            'score' => 'required|integer|min:0|max:100',
            'observations' => 'nullable|string',
            'feedbacks' => 'nullable|string'
        ]);

        $exam->participants()->syncWithoutDetaching([
            $request->candidat_id => [
                'present' => $request->present,
                'resultat' => $request->resultat,
                'score' => $request->score,
                'observations' => $request->observations,
                'feedbacks' => $request->feedbacks
            ]
        ]);

        // Envoyer notification du résultat
        $candidat = User::find($request->candidat_id);
        $candidat->notify(new ExamResultPublished($exam));

        return redirect()->back()
            ->with('success', 'Résultat enregistré avec succès');
    }
}