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
    public function index()
    {
        Gate::authorize('viewAny', CoursConduite::class);

        $cours = CoursConduite::with(['moniteur', 'vehicule', 'candidats'])
            ->latest()
            ->paginate(10);

        return view('cours.index', compact('cours'));
    }

    public function create()
    {
        Gate::authorize('create', CoursConduite::class);

        $moniteurs = User::whereHas('roles', function($query) {
            $query->where('nom', 'moniteur');
        })->get();

        $vehicules = Vehicle::where('statut', 'disponible')->get();

        $candidats = User::whereHas('roles', function($query) {
            $query->where('nom', 'candidat');
        })->get();

        return view('cours.create', compact('moniteurs', 'vehicules', 'candidats'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', CoursConduite::class);

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

        // Envoyer les notifications
        $this->envoyerNotifications($cours);

        return redirect()->route('cours.index')
            ->with('success', 'Cours créé avec succès et notifications envoyées.');
    }

    protected function envoyerNotifications($cours)
    {
        // Notification au moniteur
        $moniteur = User::find($cours->moniteur_id);
        $moniteur->notify(new NouveauCoursNotification($cours));

        // Notifications aux candidats
        $candidats = $cours->candidats;
        Notification::send($candidats, new NouveauCoursNotification($cours));
    }

    public function show(CoursConduite $cours)
    {
        Gate::authorize('view', $cours);

        $cours->load(['moniteur', 'vehicule', 'candidats', 'admin']);

        return view('cours.show', compact('cours'));
    }

    public function edit(CoursConduite $cours)
    {
        Gate::authorize('update', $cours);

        $moniteurs = User::whereHas('roles', function($query) {
            $query->where('name', 'moniteur');
        })->get();

        $vehicules = Vehicle::where('statut', 'disponible')
            ->orWhere('id', $cours->vehicule_id)
            ->get();

        $candidats = User::whereHas('roles', function($query) {
            $query->where('name', 'candidat');
        })->get();

        $selectedCandidats = $cours->candidats->pluck('id')->toArray();

        return view('cours.edit', compact('cours', 'moniteurs', 'vehicules', 'candidats', 'selectedCandidats'));
    }

    public function update(Request $request, CoursConduite $cours)
    {
        Gate::authorize('update', $cours);

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

        return redirect()->route('cours.index')
            ->with('success', 'Cours mis à jour avec succès.');
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

        return redirect()->route('cours.index')
            ->with('success', 'Cours supprimé avec succès.');
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

        return back()->with('success', 'Présence enregistrée avec succès.');
    }

    public function calendrier()
    {
        Gate::authorize('viewAny', CoursConduite::class);
        return view('cours.calendrier');
    }

    public function apiCalendrier(Request $request)
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

    // Espace candidat
    public function mesCours()
    {
        $user = Auth::user();
        
        $cours = CoursConduite::with(['moniteur', 'vehicule'])
            ->whereHas('candidats', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->orderBy('date_heure', 'desc')
            ->paginate(10);

        return view('candidat.cours.index', compact('cours'));
    }

    public function detailsCours($id)
    {
        $user = Auth::user();
        $cours = CoursConduite::with(['moniteur', 'vehicule'])
            ->whereHas('candidats', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->findOrFail($id);

        $presence = $cours->candidats()->where('users.id', $user->id)->first()->pivot;

        return view('candidat.cours.show', compact('cours', 'presence'));
    }
}