<?php

namespace App\Http\Controllers;

use App\Models\CoursConduite;
use App\Models\PresenceCours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceCoursController extends Controller
{
    public function show($id)
    {
        $cours = CoursConduite::with([
            'candidat',
            'candidats' => function($query) {
                $query->withPivot('present', 'notes');
            }
        ])->where('moniteur_id', Auth::id())
          ->findOrFail($id);

        return view('moniteur.presence-modal', compact('cours'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'present' => 'required|array',
            'present.*' => 'boolean',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:500'
        ]);

        $cours = CoursConduite::where('moniteur_id', Auth::id())
                 ->findOrFail($id);

        $presenceData = [];
        foreach ($request->present as $candidatId => $present) {
            $presenceData[$candidatId] = [
                'present' => $present,
                'notes' => $request->notes[$candidatId] ?? null
            ];
        }

        $cours->candidats()->sync($presenceData);

        return redirect()->back()
               ->with('success', 'Les présences et notes ont été enregistrées avec succès');
    }

    public function showNotes($id)
    {
        $cours = CoursConduite::with([
            'candidat',
            'candidats' => function($query) {
                $query->withPivot('present', 'notes');
            }
        ])->findOrFail($id);

        return view('candidats.notes-modal', compact('cours'));
    }
}