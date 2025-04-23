<?php

namespace App\Http\Controllers;

use App\Models\CoursConduite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceCoursController extends Controller
{
    public function index()
    {
        $cours = CoursConduite::with(['candidat', 'vehicule', 'candidats' => function($query) {
                    $query->withPivot('present', 'notes');
                }])
                ->where('moniteur_id', Auth::id())
                ->orderBy('date_heure', 'desc')
                ->paginate(10);

        return view('moniteur.cours', compact('cours'));
    }

    public function updatePresences(Request $request, $courseId)
    {
        $request->validate([
            'present' => 'required|array',
            'present.*' => 'boolean',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:500'
        ]);

        $cours = CoursConduite::where('moniteur_id', Auth::id())
                 ->findOrFail($courseId);

        $presenceData = [];
        foreach ($request->present as $candidatId => $present) {
            $presenceData[$candidatId] = [
                'present' => $present,
                'notes' => $request->notes[$candidatId] ?? null
            ];
        }

        $cours->candidats()->sync($presenceData);

        return response()->json([
            'success' => true,
            'message' => 'Présences enregistrées avec succès',
            'data' => $cours->load('candidats')
        ]);
    }
}