<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function connecter()
    {
        return view('auth.connecter');
    }

    /**
     * Display registration form
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Show the form for creating a new resource.
     */
     public function CreeCompte(Request $request)
     {
         $validated = $request->validate([
             'nom' => 'required|string|max:255',
             'prenom' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users',
             'adresse' => 'required|string|max:255',
             'telephone' => 'required|string|max:20',
             'type-permis' => 'required|string|max:50',
             'photos-identité' => 'required|image|mimes:jpeg,png,jpg|max:2048',
             'photos-profile' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
             'diplome' => 'sometimes|file|mimes:pdf,doc,docx|max:2048',
             'mot-de-passe' => ['required','confirmed','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
             'role' => 'sometimes|in:admin,moniteur,candidats',
         ]);
 
         $photosPath = null;
         if ($request->hasFile('photos-identité')) {
             $photosPath = $request->file('photos-identité')->store('photos-identité', 'public');
         }
 
         $profilePhotoPath = null;
         if ($request->hasFile('photos-profile')) {
             $profilePhotoPath = $request->file('photos-profile')->store('photos-identité', 'public');
         }
 
         $diplomePath = null;
         if ($request->hasFile('diplome')) {
             $diplomePath = $request->file('diplome')->store('diplome', 'public');
         }
 
         $user = User::create([
             'nom' => $validated['nom'],
             'prenom' => $validated['prenom'],
             'email' => $validated['email'],
             'adresse' => $validated['adresse'],
             'telephone' => $validated['phone'],
             'type-permis' => $validated['type'],
             'photos-identité' => $photosPath,
             'photos-profile' => $profilePhotoPath,
             'diplome' => $diplomePath,
             'role' => $request->input('role', 'candidats'),
             'mot-de-passe' => Hash::make($validated['password']),
         ]);
 
         Auth::connecter($user);
 
         return redirect()->route('auth.connecter')->with('success', 'Compte créé avec succès!');
     }
 
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
