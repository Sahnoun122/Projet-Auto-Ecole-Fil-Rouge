<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($id = null)
    {
        $user = $id ? User::findOrFail($id) : Auth::user();
        
        // Autorisations
        if (!(Auth::isAdmin() || Auth::id() === $user->id)) {
            abort(403, 'Accès non autorisé');
        }

        return view('profile.show', [
            'user' => $user,
            'isCurrentUser' => Auth::id() === $user->id
        ]);
    }

    public function edit($id = null)
    {
        $user = $id ? User::findOrFail($id) : Auth::user();
        
        // Autorisations
        if (!(Auth::isAdmin() || Auth::id() === $user->id)) {
            abort(403, 'Accès non autorisé');
        }

        return view('profile.edit', [
            'user' => $user,
            'isCurrentUser' => Auth::id() === $user->id
        ]);
    }

    public function update(Request $request, $id = null)
    {
        $user = $id ? User::findOrFail($id) : Auth::user();
        
        if (!(Auth::isAdmin() || Auth::id() === $user->id)) {
            abort(403, 'Accès non autorisé');
        }

        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($user->isCandidat()) {
            $rules['type_permis'] = 'required|string';
        }

        if ($user->isMoniteur()) {
            $rules['certifications'] = 'required|string';
            $rules['qualifications'] = 'required|string';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('photo_profile')) {
            if ($user->photo_profile) {
                Storage::delete($user->photo_profile);
            }
            $path = $request->file('photo_profile')->store('profile-photos', 'public');
            $validated['photo_profile'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile.show', $user->id)
                         ->with('success', 'Profil mis à jour avec succès');
    }

    public function destroy($id)
    {
        if (!Auth::isAdmin()) {
            abort(403, 'Seuls les administrateurs peuvent supprimer des comptes');
        }

        $user = User::findOrFail($id);
        
        if (Auth::id() === $user->id) {
            return redirect()->back()
                             ->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }

        if ($user->photo_profile) {
            Storage::delete($user->photo_profile);
        }

        $user->delete();

        return redirect()->route('dashboard')
                         ->with('success', 'Utilisateur supprimé avec succès');
    }
}