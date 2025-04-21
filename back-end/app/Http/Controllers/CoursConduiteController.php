<?php

namespace App\Http\Controllers;

use App\Models\CoursConduite;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoursConduiteController extends Controller
{
    public function index()
    {
        $cours = CoursConduite::with([
            'moniteur:id,nom,prenom',
            'vehicule:id,marque,immatriculation',
            'candidat:id,nom,prenom',
            'candidats:id,nom,prenom'
        ])->latest()->paginate(10);

        $moniteurs = User::where('role', 'moniteur')
                     ->select('id', 'nom', 'prenom')
                     ->get();

        $candidats = User::where('role', 'candidat')
                     ->select('id', 'nom', 'prenom')
                     ->get();

        $vehicules = Vehicle::select('id', 'marque', 'immatriculation')->get();

        $vehiculesDisponibles = Vehicle::whereDoesntHave('coursConduites', function($query) {
            $query->where('statut', 'planifie');
        })->get();

        return view('admin.conduite', compact(
            'cours',
            'moniteurs',
            'candidats',
            'vehicules',
            'vehiculesDisponibles'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_heure' => 'required|date',
            'duree_minutes' => 'required|integer|min:30|max:240',
            'moniteur_id' => 'required|exists:users,id',
            'vehicule_id' => 'required|exists:vehicles,id',
            'candidat_id' => 'required|exists:users,id', 
            'candidat_ids' => 'sometimes|array',
            'candidat_ids.*' => 'exists:users,id',
            'statut' => 'required|in:planifie,termine,annule',
        ]);

        $cours = CoursConduite::create([
            'date_heure' => $validated['date_heure'],
            'duree_minutes' => $validated['duree_minutes'],
            'moniteur_id' => $validated['moniteur_id'],
            'vehicule_id' => $validated['vehicule_id'],
            'admin_id' => Auth::id(),
            'candidat_id' => $validated['candidat_id'],
            'statut' => $validated['statut'],
        ]);

        if (!empty($validated['candidat_ids'])) {
            $cours->candidats()->sync($validated['candidat_ids']);
        }

        return redirect()->route('admin.conduite')
            ->with('success', 'Cours créé avec succès');
    }

    public function update(Request $request, CoursConduite $coursConduite)
    {
        $validated = $request->validate([
            'date_heure' => 'required|date',
            'duree_minutes' => 'required|integer|min:30|max:240',
            'moniteur_id' => 'required|exists:users,id',
            'vehicule_id' => 'required|exists:vehicles,id',
            'candidat_id' => 'required|exists:users,id',
            'candidat_ids' => 'sometimes|array',
            'candidat_ids.*' => 'exists:users,id',
            'statut' => 'required|in:planifie,termine,annule',
        ]);

        $coursConduite->update([
            'date_heure' => $validated['date_heure'],
            'duree_minutes' => $validated['duree_minutes'],
            'moniteur_id' => $validated['moniteur_id'],
            'vehicule_id' => $validated['vehicule_id'],
            'candidat_id' => $validated['candidat_id'],
            'statut' => $validated['statut'],
        ]);

        $coursConduite->candidats()->sync($validated['candidat_ids'] ?? []);

        return redirect()->route('admin.conduite')
            ->with('success', 'Cours de conduite mis à jour avec succès');
    }

    public function destroy(CoursConduite $coursConduite)
    {
        $coursConduite->delete();
        return redirect()->route('admin.conduite')
            ->with('success', 'Cours de conduite supprimé avec succès');
    }

    // public function marquerPresence($id)
    // {
    //     $cours = CoursConduite::with(['candidat', 'candidats'])->findOrFail($id);
    //     return view('admin.conduite', compact('cours'));
    // }

    public function presence($id)
    {
        return redirect()->route('admin.conduite', ['show_presence' => $id]);
    }

    public function savePresence(Request $request, $id)
    {
        $cours = CoursConduite::findOrFail($id);
        
        $request->validate([
            'present' => 'required|array',
            'present.*' => 'boolean',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:500'
        ]);

        foreach ($request->present as $candidat_id => $present) {
            $cours->candidats()->updateExistingPivot($candidat_id, [
                'present' => $present,
                'notes' => $request->notes[$candidat_id] ?? null
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Présences enregistrées avec succès'
        ]);
    }
}