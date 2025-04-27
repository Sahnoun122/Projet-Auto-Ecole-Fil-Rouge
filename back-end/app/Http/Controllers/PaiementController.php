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
        
        return view('admin.paiements.index', compact('paiements', 'candidats'));
    }

    public function adminQuickStore(Request $request)
    {
        $request->validate([
            'candidat_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:1',
            'montant_total' => 'required|numeric|min:'.$request->montant,
            'date_paiement' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        Paiement::create([
            'user_id' => $request->candidat_id,
            'montant' => $request->montant,
            'montant_total' => $request->montant_total,
            'date_paiement' => $request->date_paiement,
            'description' => $request->description,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.paiements.index')
            ->with('success', 'Paiement enregistré avec succès');
    }

    public function adminDestroy(Paiement $paiement)
    {
        $paiement->delete();
        
        return redirect()->route('admin.paiements.index')
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
        
        return view('candidat.paiements.index', compact('paiements', 'totalPaye', 'montantTotal', 'montantRestant'));
    }
}