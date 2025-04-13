<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Vehicle::class);
        
        $vehicles = Vehicle::with('admin')
            ->when(Auth::user()->role !== 'admin', function($query) {
                return $query->where('admin_id', Auth::id());
            })
            ->get();
            
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Vehicle::class);
        
        $request->validate([
            'marque' => 'required|string|max:50',
            'modele' => 'required|string|max:50',
            'immatriculation' => 'required|string|max:20|unique:vehicles',
            'date_achat' => 'required|date',
            'kilometrage' => 'required|integer|min:0',
            'prochaine_maintenance' => 'required|date|after_or_equal:today',
            'statut' => 'required|in:disponible,en maintenance,hors service'
        ]);

        $vehicle = Vehicle::create([
            'marque' => $request->marque,
            'modele' => $request->modele,
            'immatriculation' => $request->immatriculation,
            'date_achat' => $request->date_achat,
            'kilometrage' => $request->kilometrage,
            'prochaine_maintenance' => $request->prochaine_maintenance,
            'statut' => $request->statut,
            'admin_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'vehicle' => $vehicle,
            'message' => 'Véhicule créé avec succès'
        ]);
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        Gate::authorize('update', $vehicle);
        
        $request->validate([
            'marque' => 'required|string|max:50',
            'modele' => 'required|string|max:50',
            'immatriculation' => 'required|string|max:20|unique:vehicles,immatriculation,'.$vehicle->id,
            'date_achat' => 'required|date',
            'kilometrage' => 'required|integer|min:0',
            'prochaine_maintenance' => 'required|date|after_or_equal:today',
            'statut' => 'required|in:disponible,en maintenance,hors service'
        ]);

        $vehicle->update([
            'marque' => $request->marque,
            'modele' => $request->modele,
            'immatriculation' => $request->immatriculation,
            'date_achat' => $request->date_achat,
            'kilometrage' => $request->kilometrage,
            'prochaine_maintenance' => $request->prochaine_maintenance,
            'statut' => $request->statut,
        ]);

        return response()->json([
            'success' => true,
            'vehicle' => $vehicle,
            'message' => 'Véhicule mis à jour avec succès'
        ]);
    }

    public function destroy(Vehicle $vehicle)
    {
        Gate::authorize('delete', $vehicle);

        $vehicle->delete();
        return response()->json([
            'success' => true,
            'message' => 'Véhicule supprimé avec succès'
        ]);
    }

    public function maintenanceAlerts()
    {
        Gate::authorize('manageMaintenance', Vehicle::class);
        
        $alerts = Vehicle::where('prochaine_maintenance', '<=', now()->addDays(7))
            ->orderBy('prochaine_maintenance')
            ->get(['id', 'marque', 'modele', 'immatriculation', 'prochaine_maintenance']);

        return response()->json($alerts);
    }
}