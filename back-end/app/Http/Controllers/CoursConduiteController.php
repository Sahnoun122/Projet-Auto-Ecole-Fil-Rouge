<?php

namespace App\Http\Controllers;

use App\Models\CoursConduite;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\NouveauCoursNotification;
use Illuminate\Support\Facades\Notification;

class CoursConduiteController extends Controller
{
    public function index(Request $request)
    {
        // Gate::authorize('viewAny', CoursConduite::class);

        $search = $request->input('search');
        
        $cours = CoursConduite::with(['moniteur', 'vehicule', 'candidats'])
            ->when($search, function($query) use ($search) {
                return $query->whereHas('moniteur', function($q) use ($search) {
                    $q->where('nom', 'like', "%$search%")
                      ->orWhere('prenom', 'like', "%$search%");
                })
                ->orWhereHas('vehicule', function($q) use ($search) {
                    $q->where('marque', 'like', "%$search%")
                      ->orWhere('modele', 'like', "%$search%")
                      ->orWhere('immatriculation', 'like', "%$search%");
                })
                ->orWhere('statut', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.cours-conduite', compact('cours'));
    }

    public function store(Request $request)
    {
        // Gate::authorize('create', CoursConduite::class);

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

        Vehicle::where('id', $validated['vehicule_id'])
            ->update(['statut' => 'reserve']);

        $this->envoyerNotifications($cours);

        return response()->json([
            'success' => true,
            'message' => 'Cours créé avec succès et notifications envoyées.'
        ]);
    }

    protected function envoyerNotifications($cours)
    {
        $moniteur = User::find($cours->moniteur_id);
        $moniteur->notify(new NouveauCoursNotification($cours));

        $candidats = $cours->candidats;
        Notification::send($candidats, new NouveauCoursNotification($cours));
    }

    public function show($id)
    {
        $cours = CoursConduite::with(['moniteur', 'vehicule', 'candidats', 'admin'])->findOrFail($id);
        return response()->json($cours);
    }

    public function update(Request $request, $id)
    {
        $cours = CoursConduite::findOrFail($id);
        // Gate::authorize('update', $cours);

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

        if ($ancienVehiculeId != $validated['vehicule_id']) {
            Vehicle::where('id', $ancienVehiculeId)
                ->update(['statut' => 'disponible']);
            Vehicle::where('id', $validated['vehicule_id'])
                ->update(['statut' => 'reserve']);
        }

        if (in_array($validated['statut'], ['termine', 'annule'])) {
            Vehicle::where('id', $validated['vehicule_id'])
                ->update(['statut' => 'disponible']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cours mis à jour avec succès.'
        ]);
    }

    public function destroy($id)
    {
        $cours = CoursConduite::findOrFail($id);
        // Gate::authorize('delete', $cours);

        if ($cours->statut === 'planifie') {
            Vehicle::where('id', $cours->vehicule_id)
                ->update(['statut' => 'disponible']);
        }

        $cours->candidats()->detach();
        $cours->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cours supprimé avec succès.'
        ]);
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
