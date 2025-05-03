<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Exam;
use App\Models\Paiement;
use App\Models\Maintenance;
use Carbon\Carbon;
use App\Models\ExamResult;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class AdmindController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function dashboard()
     {
         $totalCandidats = User::where('role', 'candidat')->count();
         $totalMoniteurs = User::where('role', 'moniteur')->count();
         $totalVehicles = Vehicle::count(); // Add this line

         $examensTotal = Exam::count();
         $examensReussis = Exam::whereHas('result', function($query) {
             $query->whereIn('resultat', ['reussi', 'excellent', 'bien']);
         })->count();
         $tauxReussite = $examensTotal > 0 ? round(($examensReussis / $examensTotal) * 100) : 0;
         
         $paiementsEnRetard = Paiement::where('date_paiement', '<', now())
             ->whereColumn('montant', '<', 'montant_total')
             ->with('candidat')
             ->orderBy('date_paiement')
             ->limit(5)
             ->get();
             
         $maintenancesAVenir = Vehicle::whereDate('prochaine_maintenance', '<=', now()->addDays(7))
             ->whereDate('prochaine_maintenance', '>=', now())
             ->orderBy('prochaine_maintenance')
             ->limit(5)
             ->get();
         
         $derniersExamens = Exam::with(['candidat', 'result'])->latest()->limit(5)->get();
         
         $candidats = User::where('role', 'candidat')->orderBy('created_at', 'desc')->limit(5)->get();
     
         return view('admin.dashboard', compact(
             'totalCandidats',
             'totalMoniteurs',
             'totalVehicles',
             'tauxReussite',
             'paiementsEnRetard',
             'maintenancesAVenir',
             'derniersExamens',
             'candidats'
         ));
     }
    
    // public function AjouterMoniteur()
    // {
    //     return view('admin.AjouterMoniteur'); 
    // }

    public function gestionMoniteur()
    {
        return view('admin.gestionMoniteur'); 
    }

    public function gestionCandidats()
    {
        return view('admin.gestionCandidats'); 
    }


    // public function  AjouterQuiz() {
    //     return view('admin.AjouterQuiz'); 

    // }
    
    public function  AjouterQuestions() {
        return view('admin.AjouterQuestions'); 

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
