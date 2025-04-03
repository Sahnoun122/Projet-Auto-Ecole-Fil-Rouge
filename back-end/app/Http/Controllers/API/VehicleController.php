<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VehicleController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Vehicle::class);
        return Vehicle::with('admin')->get();
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Vehicle::class);
        
        $validated = $request->validate([/* ... */]);
        return Vehicle::create([...$validated, 'admin_id' => Auth::id()]);
    }

    public function show(Vehicle $vehicle)
    {
        Gate::authorize('view', $vehicle);
        return $vehicle->load('admin');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        Gate::authorize('update', $vehicle);
        
        $validated = $request->validate([/* ... */]);
        $vehicle->update($validated);
        return $vehicle->load('admin');
    }

    public function destroy(Vehicle $vehicle)
    {
        Gate::authorize('delete', $vehicle);
        $vehicle->delete();
        return response()->noContent();
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