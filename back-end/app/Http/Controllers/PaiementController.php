<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with(['candidat', 'admin'])
            ->orderBy('date_paiement', 'desc')
            ->paginate(10);
            
        $candidats = User::where('role', 'candidat')->get();
        
        return view('admin.paiements', compact('paiements', 'candidats'));
    }

    public function create()
    {
        $candidats = User::where('role', 'candidat')->get();
        return view('admin.paiements.create', compact('candidats'));
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

        Paiement::create([
            'user_id' => $request->candidat_id,
            'montant' => $request->montant,
            'montant_total' => $request->montant_total,
            'date_paiement' => $request->date_paiement,
            'description' => $request->description,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.paiements')
            ->with('success', 'Paiement créé avec succès');
    }

    public function show(Paiement $paiement)
    {
        return view('admin.paiements.show', compact('paiement'));
    }

    public function edit(Paiement $paiement)
    {
        $candidats = User::where('role', 'candidat')->get();
        return view('admin.paiements.edit', compact('paiement', 'candidats'));
    }

    public function update(Request $request, Paiement $paiement)
    {
        $request->validate([
            'candidat_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:1',
            'montant_total' => 'required|numeric|min:'.$request->montant,
            'date_paiement' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        $paiement->update([
            'user_id' => $request->candidat_id,
            'montant' => $request->montant,
            'montant_total' => $request->montant_total,
            'date_paiement' => $request->date_paiement,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.paiements')
            ->with('success', 'Paiement mis à jour avec succès');
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

   

    public function getPaiementDetails(Paiement $paiement)
    {
        if (Auth::user() && $paiement->user_id !== Auth::id()) {
            abort(403);
        }

        return view('partials.paiement-details', compact('paiement'));
    }
}