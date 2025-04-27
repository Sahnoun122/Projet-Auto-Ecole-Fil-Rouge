<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    public function adminIndex()
    {
        $paiements = Paiement::with(['candidat', 'admin'])
            ->orderBy('date_paiement', 'desc')
            ->paginate(10);
            
        $candidats = User::where('role', 'candidat')->get();
        
        return view('admin.paiements', compact('paiements', 'candidats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidat_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:1',
            'montant_total' => 'required|numeric|min:'.$request->montant,
            'date_paiement' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        $data = [
            'user_id' => $request->candidat_id,
            'montant' => $request->montant,
            'montant_total' => $request->montant_total,
            'date_paiement' => $request->date_paiement,
            'description' => $request->description,
            'admin_id' => Auth::id(),
        ];

        if ($request->has('id')) {
            $paiement = Paiement::findOrFail($request->id);
            $paiement->update($data);
            $message = 'Paiement mis à jour avec succès';
        } else {
            Paiement::create($data);
            $message = 'Paiement enregistré avec succès';
        }

        return redirect()->route('admin.paiements')
            ->with('success', $message);
    }

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();
        
        return redirect()->route('admin.paiements')
            ->with('success', 'Paiement supprimé avec succès');
    }

    public function candidatIndex()
    {
        $paiements = Paiement::where('user_id', Auth::id())
            ->orderBy('date_paiement', 'desc')
            ->paginate(10);
            
        $totalPaye = Paiement::where('user_id', Auth::id())->sum('montant');
        $montantTotal = Paiement::where('user_id', Auth::id())->latest()->first()->montant_total ?? 0;
        $montantRestant = max(0, $montantTotal - $totalPaye);
        
        return view('candidats.paiements', compact('paiements', 'totalPaye', 'montantTotal', 'montantRestant'));
    }

    public function edit(Paiement $paiement)
    {
        return response()->json($paiement);
    }

    public function getPaiementDetails(Paiement $paiement)
    {
        if (Auth::user() && $paiement->user_id !== Auth::id()) {
            abort(403);
        }

        return view('partials.paiement-details', compact('paiement'));
    }
}