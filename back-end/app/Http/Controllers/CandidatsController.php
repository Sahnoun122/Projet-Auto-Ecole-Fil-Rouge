<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class CandidatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function dashboard()
    // {
    //     return view('candidats.dashboard'); 
    // }

  public function index()
  {
      $candidats = User::where('role', 'candidat')->get();
      return view('admin.candidats', compact('candidats'));
    //   return view('admin.candidats');

  }

  public function create()
  {
      return view('admin.candidats.create');
  }

  public function store(Request $request)
  {
      $validated = $request->validate([
          'nom' => 'required|string|max:255',
          'prenom' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          'adresse' => 'required|string|max:255',
          'telephone' => 'required|string|max:20',
          'photo_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
          'photo_identite' => 'required|image|mimes:jpeg,png,jpg|max:2048',
          'type_permis' => 'required|string|max:255',
          'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
      ]);

      $profilePhotoPath = $request->file('photo_profile')->store('profile', 'public');
      $identityPhotoPath = $request->file('photo_identite')->store('identite', 'public');

      $userData = [
          'nom' => $request->nom,
          'prenom' => $request->prenom,
          'email' => $request->email,
          'adresse' => $request->adresse,
          'telephone' => $request->telephone,
          'photo_profile' => $profilePhotoPath,
          'photo_identite' => $identityPhotoPath,
          'type_permis' => $request->type_permis,
          'role' => 'candidat',
          'password' => Hash::make($request->password),
      ];

      User::create($userData);

      return redirect()->route('admin.candidats.index')->with('success', 'Candidat ajouté avec succès.');
  }

  public function edit($id)
  {
      $candidat = User::findOrFail($id);
      return view('admin.candidats.edit', compact('candidat'));
  }

  public function update(Request $request, $id)
  {
      $candidat = User::findOrFail($id);

      $rules = [
          'nom' => 'required|string|max:255',
          'prenom' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users,email,' . $candidat->id,
          'adresse' => 'required|string|max:255',
          'telephone' => 'required|string|max:20',
          'type_permis' => 'required|string|max:255',
      ];

      if ($request->hasFile('photo_profile')) {
          $rules['photo_profile'] = 'image|mimes:jpeg,png,jpg|max:2048';
      }

      if ($request->hasFile('photo_identite')) {
          $rules['photo_identite'] = 'image|mimes:jpeg,png,jpg|max:2048';
      }

      $data = $request->validate($rules);

      if ($request->hasFile('photo_profile')) {
          $data['photo_profile'] = $request->file('photo_profile')->store('profile', 'public');
      }

      if ($request->hasFile('photo_identite')) {
          $data['photo_identite'] = $request->file('photo_identite')->store('identite', 'public');
      }

      $candidat->update($data);

      return redirect()->route('admin.candidats.index')->with('success', 'Candidat mis à jour avec succès.');
  }

  public function destroy($id)
  {
      $candidat = User::findOrFail($id);
      $candidat->delete();

      return redirect()->route('admin.candidats.index')->with('success', 'Candidat supprimé avec succès.');
  }
}
