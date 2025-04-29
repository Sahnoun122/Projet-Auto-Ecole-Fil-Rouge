<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
    
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit($id = null)
    {
        $user = $id ? User::findOrFail($id) : Auth::user();
        
      
        return view('profile.edit', [
            'user' => $user,
            'isCurrentUser' => Auth::id() === $user->id
        ]);
    }

public function update(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    
    $rules = [
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        'telephone' => 'required|string|max:20',
        'adresse' => 'required|string|max:255',
        'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'password' => 'nullable|string|min:8',
    ];
    
    if ($user->isMoniteur()) {
        $rules['certifications'] = 'nullable|file|mimes:pdf|max:5120';
        $rules['qualifications'] = 'nullable|file|mimes:pdf|max:5120'; 
    }
    
    $validated = $request->validate($rules);
    
    if ($request->hasFile('photo_profile')) {
        if ($user->photo_profile) {
            Storage::delete('public/' . $user->photo_profile);
        }
        $path = $request->file('photo_profile')->store('profile-photos', 'public');
        $validated['photo_profile'] = str_replace('public/', '', $path);
    }
    
    if ($user->isMoniteur()) {
        if ($request->hasFile('certifications')) {
            if ($user->certifications) {
                Storage::delete('public/' . $user->certifications);
            }
            $path = $request->file('certifications')->store('/certifications', 'public');
            $validated['certifications'] = str_replace('public/', '', $path);
        }
        
        if ($request->hasFile('qualifications')) {
            if ($user->qualifications) {
                Storage::delete('public/' . $user->qualifications);
            }
            $path = $request->file('qualifications')->store('/qualifications', 'public');
            $validated['qualifications'] = str_replace('public/', '', $path);
        }
    }
    
    if ($request->filled('password')) {
        $validated['password'] = Hash::make($request->password);
    } else {
        unset($validated['password']);
    }
    
    $user->update($validated);
    
    return redirect()->route('profile.show')->with('success', 'Profil mis à jour avec succès');
}
    
    public function destroy($id)
    {
       
        
        $user = User::findOrFail($id);
        
        if (Auth::id() === $user->id) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }
        
        if ($user->photo_profile) {
            Storage::delete('public/' . $user->photo_profile);
        }
        
        $user->delete();
        
        return redirect()->route('dashboard')
            ->with('success', 'Utilisateur supprimé avec succès');
    }
}