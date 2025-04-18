<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CoursConduite;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CoursConduiteController extends Controller
{
    public function index()
    {
        $cours = CoursConduite::with(['moniteur', 'vehicule', 'candidat', 'candidats'])
                    ->latest()
                    ->paginate(10);
             dd($cours);
        $moniteurs = User::where('role', 'moniteur')->get();
        $candidats = User::where('role', 'candidat')->get();
        $vehicules = Vehicle::all();
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
            'candidat_ids' => 'required|array',
            'candidat_ids.*' => 'exists:users,id',
            'statut' => 'required|in:planifie,termine,annule',
        ]);

        $cours = CoursConduite::create([
            'date_heure' => $validated['date_heure'],
            'duree_minutes' => $validated['duree_minutes'],
            'moniteur_id' => $validated['moniteur_id'],
            'vehicule_id' => $validated['vehicule_id'],
            'admin_id' => Auth::id(),
            'statut' => $validated['statut'],
            'candidat_id' => $validated['candidat_ids'][0] 
        ]);

        if (count($validated['candidat_ids']) ){
            $cours->candidats()->sync($validated['candidat_ids']);
        }

        return redirect()->route('admin.conduite')
            ->with('success', 'Cours de conduite créé avec succès');
    }

    public function update(Request $request, CoursConduite $coursConduite)
    {
        $validated = $request->validate([
            'date_heure' => 'required|date',
            'duree_minutes' => 'required|integer|min:30|max:240',
            'moniteur_id' => 'required|exists:users,id',
            'vehicule_id' => 'required|exists:vehicles,id',
            'candidat_ids' => 'required|array',
            'candidat_ids.*' => 'exists:users,id',
            'statut' => 'required|in:planifie,termine,annule',
        ]);

        $coursConduite->update([
            'date_heure' => $validated['date_heure'],
            'duree_minutes' => $validated['duree_minutes'],
            'moniteur_id' => $validated['moniteur_id'],
            'vehicule_id' => $validated['vehicule_id'],
            'statut' => $validated['statut'],
            'candidat_id' => $validated['candidat_ids'][0]
        ]);

        // Mettre à jour les candidats supplémentaires
        $coursConduite->candidats()->sync($validated['candidat_ids']);

        return redirect()->route('admin.conduite')
            ->with('success', 'Cours de conduite mis à jour avec succès');
    }

    public function destroy(CoursConduite $coursConduite)
    {
        $coursConduite->delete();
        return redirect()->route('admin.conduite')
            ->with('success', 'Cours de conduite supprimé avec succès');
    }

    public function marquerPresence(Request $request, $id)
    {
        $cours = CoursConduite::findOrFail($id);
        // Gate::authorize('manageAttendance', $cours);

        $request->validate([
            'candidat_id' => 'required|exists:users,id',
            'present' => 'required|boolean',
            'notes' => 'nullable|string|max:500'
        ]);

        $cours->candidats()->updateExistingPivot($request->candidat_id, [
            'present' => $request->present,
            'notes' => $request->notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Présence enregistrée avec succès.'
        ]);
    }

    public function getResources()
    {
        // Gate::authorize('viewAny', CoursConduite::class);

        $moniteurs = User::where('role', 'moniteur')->get();
        $vehicules = Vehicle::where('statut', 'disponible')->get();
        $candidats = User::where('role', 'candidat')->get();

        return view('admin.conduite', compact('moniteurs' , 'vehicules' , 'candidats'));

    }
}
