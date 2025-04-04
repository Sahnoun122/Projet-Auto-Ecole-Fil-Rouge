<?php

namespace App\Http\Controllers;

use App\Models\CoursConduite;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CoursConduiteController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', CoursConduite::class);

        $cours = CoursConduite::with(['moniteur', 'vehicule', 'candidats'])
            ->latest()
            ->paginate(10);

        return response()->json($cours);
    }

    public function create()
    {
        Gate::authorize('create', CoursConduite::class);

        $moniteurs = User::whereHas('roles', function($query) {
            $query->where('name', 'moniteur');
        })->get();

        $vehicules = Vehicle::where('statut', 'disponible')->get();

        $candidats = User::whereHas('roles', function($query) {
            $query->where('name', 'candidat');
        })->get();

        return response()->json(compact('moniteurs', 'vehicules', 'candidats'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', CoursConduite::class);

        $validated = $request->validate([
            'date_heure' => 'required|date',
            'duree_minutes' => 'required|integer|min:30|max:240',
            'moniteur_id' => 'required|exists:users,id',
            'vehicule_id' => 'required|exists:vehicules,id',
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

        return response()->json($cours, 201);
    }

    public function show(CoursConduite $cours)
    {
        Gate::authorize('view', $cours);

        $cours->load(['moniteur', 'vehicule', 'candidats', 'admin']);

        return response()->json($cours);
    }

    public function update(Request $request, CoursConduite $cours)
    {
        Gate::authorize('update', $cours);

        $validated = $request->validate([
            'date_heure' => 'required|date',
            'duree_minutes' => 'required|integer|min:30|max:240',
            'moniteur_id' => 'required|exists:users,id',
            'vehicule_id' => 'required|exists:vehicules,id',
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

        return response()->json($cours);
    }

    public function destroy(CoursConduite $cours)
    {
        Gate::authorize('delete', $cours);

        if ($cours->statut === 'planifie') {
            Vehicle::where('id', $cours->vehicule_id)
                ->update(['statut' => 'disponible']);
        }

        $cours->candidats()->detach();

        $cours->delete();

        return response()->json(['message' => 'Cours supprimé avec succès!']);
    }

    public function marquerPresence(Request $request, CoursConduite $cours)
    {
        Gate::authorize('manageAttendance', $cours);

        $request->validate([
            'candidat_id' => 'required|exists:users,id',
            'present' => 'required|boolean',
            'notes' => 'nullable|string|max:500'
        ]);

        $cours->candidats()->updateExistingPivot($request->candidat_id, [
            'present' => $request->present,
            'notes' => $request->notes
        ]);

        return response()->json(['message' => 'Présence enregistrée!']);
    }

    public function apiIndex(Request $request)
    {
        Gate::authorize('viewAny', CoursConduite::class);

        $query = CoursConduite::with(['moniteur', 'vehicule', 'candidats']);

        if ($request->has('start') && $request->has('end')) {
            $query->whereBetween('date_heure', [
                $request->start,
                $request->end
            ]);
        }

        $events = $query->get()->map(function($cours) {
            return [
                'id' => $cours->id,
                'title' => 'Cours avec ' . $cours->moniteur->name,
                'start' => $cours->date_heure->toIso8601String(),
                'end' => $cours->date_heure->addMinutes($cours->duree_minutes)->toIso8601String(),
                'backgroundColor' => $this->getStatusColor($cours->statut),
                'borderColor' => $this->getStatusColor($cours->statut),
                'extendedProps' => [
                    'moniteur' => $cours->moniteur->name,
                    'vehicule' => $cours->vehicule->marque . ' ' . $cours->vehicule->modele,
                    'candidats' => $cours->candidats->pluck('name')->implode(', ')
                ]
            ];
        });

        return response()->json($events);
    }

    private function getStatusColor($statut)
    {
        $colors = [
            'planifie' => '#4D44B5',
            'termine' => '#28a745',
            'annule' => '#dc3545'
        ];

        return $colors[$statut] ?? '#6c757d';
    }
}
