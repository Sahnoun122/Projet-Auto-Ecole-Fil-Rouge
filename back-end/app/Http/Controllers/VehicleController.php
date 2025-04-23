<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::when(Auth::user()->role !== 'admin', function($query) {
            return $query->where('admin_id', Auth::id());
        })->latest()->get();
        
        return view('admin.vehicles', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'marque' => 'required|string|max:50',
            'modele' => 'required|string|max:50',
            'immatriculation' => 'required|string|max:20|unique:vehicles',
            'date_achat' => 'required|date',
            'kilometrage' => 'required|integer|min:0',
            'prochaine_maintenance' => 'required|date|after_or_equal:today',
            'statut' => 'required|in:disponible,en maintenance,hors service'
        ]);

        Vehicle::create([
            'marque' => $request->marque,
            'modele' => $request->modele,
            'immatriculation' => $request->immatriculation,
            'date_achat' => $request->date_achat,
            'kilometrage' => $request->kilometrage,
            'prochaine_maintenance' => $request->prochaine_maintenance,
            'statut' => $request->statut,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.vehicles')->with('success', 'Véhicule créé avec succès');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'marque' => 'required|string|max:50',
            'modele' => 'required|string|max:50',
            'immatriculation' => 'required|string|max:20|unique:vehicles,immatriculation,'.$vehicle->id,
            'date_achat' => 'required|date',
            'kilometrage' => 'required|integer|min:0',
            'prochaine_maintenance' => 'required|date|after_or_equal:today',
            'statut' => 'required|in:disponible,en maintenance,hors service'
        ]);

        $vehicle->update($request->all());

        return redirect()->route('admin.vehicles')->with('success', 'Véhicule mis à jour avec succès');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles')->with('success', 'Véhicule supprimé avec succès');
    }

    // public function maintenanceAlerts()
    // {
    //     $alerts = Vehicle::where('prochaine_maintenance', '<=', now()->addDays(7))
    //         ->orderBy('prochaine_maintenance')
    //         ->get(['id', 'marque', 'modele', 'immatriculation', 'prochaine_maintenance']);

    //     return view('admin.vehicles', compact('alerts'));
    // }


    public function indexMoniteur()
    {
        $vehicles = Vehicle::whereIn('statut', ['disponible', 'en maintenance'])
                    ->orderBy('marque')
                    ->orderBy('modele')
                    ->get();

        $brands = Vehicle::select('marque')
                    ->distinct()
                    ->orderBy('marque')
                    ->pluck('marque');

        return view('moniteur.vehicles', compact('vehicles', 'brands'));
    }

}