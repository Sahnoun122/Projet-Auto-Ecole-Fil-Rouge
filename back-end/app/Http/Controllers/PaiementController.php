<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = Paiement::with(['candidat', 'admin']);

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->whereHas('candidat', function (Builder $q) use ($searchTerm) {
                $q->where('nom', 'like', "%{$searchTerm}%")
                  ->orWhere('prenom', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'complete') {
                $query->whereRaw('montant >= montant_total');
            } elseif ($status === 'partial') {
                $query->whereRaw('montant < montant_total');
            }
        }

        if ($request->filled('date')) {
            $date = $request->input('date');
            $query->whereDate('date_paiement', $date);
        }

        $paiements = $query->orderBy('date_paiement', 'desc')
                           ->paginate(10)
                           ->appends($request->query());

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
            'montant' => 'required|numeric|min:0',
            'montant_total' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'methode_paiement' => 'nullable|string|in:especes,cheque,virement',
            'description' => 'nullable|string|max:500',
        ]);

        if ($request->montant_total > 0 && $request->montant > $request->montant_total) {
             return back()->withErrors(['montant' => 'Le montant payé ne peut pas être supérieur au montant total.'])->withInput();
        }


        Paiement::create([
            'user_id' => $request->candidat_id,
            'montant' => $request->montant,
            'montant_total' => $request->montant_total,
            'date_paiement' => $request->date_paiement,
            'methode_paiement' => $request->methode_paiement,
            'description' => $request->description,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.paiements')
            ->with('success', 'Paiement créé avec succès');
    }

    public function edit(Paiement $paiement)
    {

            return response()->json([
                'success' => true,
                'paiement' => [
                    'id' => $paiement->id,
                    'user_id' => $paiement->user_id,
                    'montant' => $paiement->montant,
                    'montant_total' => $paiement->montant_total,
                    'date_paiement' => $paiement->date_paiement,
                    'description' => $paiement->description
                ]
            ]);
        }

    public function update(Request $request, Paiement $paiement)
    {
        $request->validate([
            'candidat_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:0',
            'montant_total' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'methode_paiement' => 'nullable|string|in:especes,cheque,virement',
            'description' => 'nullable|string|max:500',
        ]);

        if ($request->montant_total > 0 && $request->montant > $request->montant_total) {
             return back()->withErrors(['montant' => 'Le montant payé ne peut pas être supérieur au montant total.'])->withInput();
        }

        $paiement->update([
            'user_id' => $request->candidat_id,
            'montant' => $request->montant,
            'montant_total' => $request->montant_total,
            'date_paiement' => $request->date_paiement,
            'methode_paiement' => $request->methode_paiement,
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

    public function getPaiementDetails($id)
    {
        $paiement = Paiement::with(['candidat', 'admin'])->findOrFail($id);


        if (!(Auth::user()->role === 'admin' || $paiement->user_id === Auth::id())) {
             abort(403, 'Accès non autorisé');
        }

        return view('partials.paiement-details', compact('paiement'));
    }
}