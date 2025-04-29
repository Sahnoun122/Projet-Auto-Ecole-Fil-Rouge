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
            ])
            ->latest()
            ->paginate(10);

        $moniteurs = User::where('role', 'moniteur')
                     ->select('id', 'nom', 'prenom')
                     ->get();

        $candidats = User::where('role', 'candidat')
                     ->select('id', 'nom', 'prenom')
                     ->get();

        $vehicules = Vehicle::select('id', 'marque', 'immatriculation')->get();

        return view('admin.conduite', compact(
            'cours',
            'moniteurs',
            'candidats',
            'vehicules'
        ));
    }

    public function getPresences($id)
    {
        $course = CoursConduite::with([
            'moniteur:id,nom,prenom',
            'vehicule:id,marque,immatriculation',
            'candidat:id,nom,prenom',
            'candidats' => function($query) {
                $query->withPivot(['present', 'notes']);
            }
        ])->find($id);
    
        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Cours non trouvé'
            ], 404);
        }
    
        $presences = $course->candidats->map(function($candidat) use ($course) {
            return [
                'id' => $candidat->id,
                'nom' => $candidat->nom,
                'prenom' => $candidat->prenom,
                'present' => $candidat->pivot->present,
                'notes' => $candidat->pivot->notes,
                'is_principal' => $course->candidat_id && $candidat->id === $course->candidat_id
            ];
        });
    
        return response()->json([
            'success' => true,
            'data' => [
                'course' => $course,
                'presences' => $presences
            ]
        ]);
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

        $coursConduite->update($validated);
        $coursConduite->candidats()->sync($validated['candidat_ids'] ?? []);

        return redirect()->route('admin.conduite')
            ->with('success', 'Cours mis à jour avec succès');
    }

    public function destroy(CoursConduite $coursConduite)
    {
        $coursConduite->delete();
        return redirect()->route('admin.conduite')
            ->with('success', 'Cours supprimé avec succès');
    }



    public function moniteurIndex()
    {
        $cours = CoursConduite::with(['vehicule', 'candidat', 'candidats'])
            ->where('moniteur_id', Auth::id())
            ->where('statut', 'planifie')
            ->latest()
            ->paginate(10);

        return view('moniteur.conduite', compact('cours'));
    }

    public function moniteurSavePresence(Request $request, $id)
    {
        $cours = CoursConduite::where('moniteur_id', Auth::id())
                    ->findOrFail($id);

        $request->validate([
            'present' => 'required|array',
            'present.*' => 'boolean',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:500'
        ]);

        $updates = [];
        foreach ($request->present as $candidat_id => $present) {
            $updates[$candidat_id] = [
                'present' => $present,
                'notes' => $request->notes[$candidat_id] ?? null
            ];
        }

        $cours->candidats()->sync($updates);

        return redirect()->route('moniteur.conduite')
            ->with('success', 'Présences enregistrées avec succès');
    }


    public function candidatIndex()
    {
        $user = Auth::user();
        
        $cours = CoursConduite::with(['moniteur', 'vehicule'])
            ->where(function($query) use ($user) {
                $query->where('candidat_id', $user->id)
                      ->orWhereHas('candidats', function($q) use ($user) {
                          $q->where('users.id', $user->id);
                      });
            })
            ->orderBy('date_heure', 'desc')
            ->paginate(10);

        return view('candidats.conduite', compact('cours'));
    }

    public function candidatShow($id)
    {
        $user = Auth::user();
        
        $cours = CoursConduite::with(['moniteur', 'vehicule'])
            ->where('id', $id)
            ->where(function($query) use ($user) {
                $query->where('candidat_id', $user->id)
                      ->orWhereHas('candidats', function($q) use ($user) {
                          $q->where('users.id', $user->id);
                      });
            })
            ->firstOrFail();

        $presence = $cours->candidats()->where('users.id', $user->id)->first();
        
        return response()->json([
            'success' => true,
            'data' => [
                'date_heure' => $cours->date_heure,
                'duree_minutes' => $cours->duree_minutes,
                'moniteur' => $cours->moniteur,
                'vehicule' => $cours->vehicule,
                'statut' => $cours->statut,
                'present' => $presence ? $presence->pivot->present : null,
                'notes' => $presence ? $presence->pivot->notes : null,
                'is_principal' => $cours->candidat_id == $user->id
            ]
        ]);
    }

    
}