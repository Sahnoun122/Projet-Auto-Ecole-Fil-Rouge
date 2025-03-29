<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CandidatService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CandidatController extends Controller
{
    protected $candidatService;

    public function __construct(CandidatService $candidatService)
    {
        $this->candidatService = $candidatService;
    }
    public function completeRegistration(Request $request)
    {
        // Valider les données d'entrée
        $validator = Validator::make($request->all(), [
            'photo_identite' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'type_permis' => 'required|in:A,B,C,D,EB'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        // Récupérer l'utilisateur authentifié
        $user = Auth::guard('api')->user();
        
        if (!$user) {
            return response()->json(['error' => 'Authentification requise'], 401);
        }
    
        // Vérifier le rôle
        if ($user->role !== 'candidat') {
            return response()->json(['error' => 'Accès réservé aux candidats'], 403);
        }
    
        // Traitement des données
        try {
            $candidat = $this->candidatService->createCandidat($user->id, $request->all());
            
            return response()->json([
                'message' => 'Inscription complétée avec succès',
                'candidat' => $candidat
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur du serveur'], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
