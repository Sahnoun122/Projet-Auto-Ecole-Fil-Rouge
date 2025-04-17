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
        $cours = CoursConduite::with(['moniteur', 'vehicule', 'candidats'])->latest()->paginate(10);
        $moniteurs = User::where('role', 'moniteur')->get();
        $vehicules = Vehicle::all();
        $candidats = User::where('role', 'candidat')->get();
        
        $vehiculesDisponibles = Vehicle::where('statut', 'disponible')->get();
        
        return view('admin.cours-conduite', compact(
            'cours', 
            'moniteurs', 
            'vehicules',
            'vehiculesDisponibles',
            'candidats'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_heure' => 'required|date',
            'duree_minutes' => 'required|integer|min:30|max:240',
            'moniteur_id' => 'required|exists:users,id',
            'vehicule_id' => 'required|exists:vehicles,id',
            'candidat_ids' => 'required|array|min:1',
            'candidat_ids.*' => 'exists:users,id'
        ]);

        $cours = CoursConduite::create([
            'date_heure' => $validated['date_heure'],
            'duree_minutes' => $validated['duree_minutes'],
            'statut' => 'planifie',
            'moniteur_id' => $validated['moniteur_id'],
            'vehicule_id' => $validated['vehicule_id'],
            'admin_id' => Auth::id()
        ]);

        $cours->candidats()->attach($validated['candidat_ids']);

        Vehicle::where('id', $validated['vehicule_id'])->update(['statut' => 'reserve']);

        return redirect()->route('admin.cours-conduite.index')->with('success', 'Cours ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $cours = CoursConduite::findOrFail($id);

        $validated = $request->validate([
            'date_heure' => 'required|date',
            'duree_minutes' => 'required|integer|min:30|max:240',
            'moniteur_id' => 'required|exists:users,id',
            'vehicule_id' => 'required|exists:vehicles,id',
            'statut' => 'required|in:planifie,termine,annule',
            'candidat_ids' => 'required|array|min:1',
            'candidat_ids.*' => 'exists:users,id'
        ]);

        $ancienVehiculeId = $cours->vehicule_id;

        $cours->update([
            'date_heure' => $validated['date_heure'],
            'duree_minutes' => $validated['duree_minutes'],
            'statut' => $validated['statut'],
            'moniteur_id' => $validated['moniteur_id'],
            'vehicule_id' => $validated['vehicule_id']
        ]);

        $cours->candidats()->sync($validated['candidat_ids']);

        // Gestion du statut des véhicules
        if ($ancienVehiculeId != $validated['vehicule_id']) {
            Vehicle::where('id', $ancienVehiculeId)->update(['statut' => 'disponible']);
            Vehicle::where('id', $validated['vehicule_id'])->update(['statut' => 'reserve']);
        }

        if (in_array($validated['statut'], ['termine', 'annule'])) {
            Vehicle::where('id', $validated['vehicule_id'])->update(['statut' => 'disponible']);
        }

        return redirect()->route('admin.cours-conduite.index')->with('success', 'Cours mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $cours = CoursConduite::findOrFail($id);

        if ($cours->statut === 'planifie') {
            Vehicle::where('id', $cours->vehicule_id)->update(['statut' => 'disponible']);
        }

        $cours->candidats()->detach();
        $cours->delete();

        return redirect()->route('admin.cours-conduite.index')->with('success', 'Cours supprimé avec succès.');
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

        return view('admin.cours-conduite', compact('moniteurs' , 'vehicules' , 'candidats'));

    }
}
