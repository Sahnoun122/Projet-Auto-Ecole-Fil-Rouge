<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CandidatsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $candidats = User::where('role', 'candidat')
            ->when($search, function($query) use ($search) {
                return $query->where('nom', 'like', "%$search%")
                             ->orWhere('prenom', 'like', "%$search%")
                             ->orWhere('email', 'like', "%$search%")
                             ->orWhere('telephone', 'like', "%$search%")
                             ->orWhere('type_permis', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('admin.candidats', compact('candidats'));
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
            'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
        ]);

        $validated['photo_profile'] = $request->file('photo_profile')->store('candidats/profile', 'public');
        $validated['photo_identite'] = $request->file('photo_identite')->store('candidats/identite', 'public');
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'candidat';

        User::create($validated);

        return redirect()->route('admin.candidats')->with('success', 'Candidat ajouté avec succès');
    }

    public function show($id)
    {
        $candidat = User::findOrFail($id);
        return response()->json($candidat);
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
            Storage::disk('public')->delete($candidat->photo_profile);
            $data['photo_profile'] = $request->file('photo_profile')->store('candidats/profile', 'public');
        }
        if ($request->hasFile('photo_identite')) {
            Storage::disk('public')->delete($candidat->photo_identite);
            $data['photo_identite'] = $request->file('photo_identite')->store('candidats/identite', 'public');
        }

        $candidat->update($data);

        return redirect()->route('admin.candidats')->with('success', 'Candidat mis à jour avec succès');
    }

    public function destroy($id)
    {
        $candidat = User::findOrFail($id);
        
        Storage::disk('public')->delete([
            $candidat->photo_profile,
            $candidat->photo_identite
        ]);
        
        $candidat->delete();

        return redirect()->route('admin.candidats')->with('success', 'Candidat supprimé avec succès');
    }
}