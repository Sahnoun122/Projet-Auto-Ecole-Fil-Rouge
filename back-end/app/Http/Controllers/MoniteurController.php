<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MoniteurController  extends Controller
{

    public function dashboard()
    {
        return view('moniteur.dashboard'); 
    }
    
    public function index()
    {
        $moniteurs = User::where('role', 'moniteur')->get();
        return view('admin.moniteurs.index', compact('moniteurs'));
    }

    public function create()
    {
        return view('admin.moniteurs.create');
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
            'certifications' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'qualifications' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
        ]);

        $validated['photo_profile'] = $request->file('photo_profile')->store('profile', 'public');
        $validated['photo_identite'] = $request->file('photo_identite')->store('identite', 'public');
        $validated['certifications'] = $request->file('certifications')->store('certifications', 'public');
        $validated['qualifications'] = $request->file('qualifications')->store('qualifications', 'public');
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'moniteur';

        User::create($validated);

        return redirect()->route('moniteurs.index')->with('success', 'Moniteur ajouté avec succès');
    }

    public function edit($id)
    {
        $moniteur = User::findOrFail($id);
        return view('admin.moniteurs.edit', compact('moniteur'));
    }

    public function update(Request $request, $id)
    {
        $moniteur = User::findOrFail($id);

        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $moniteur->id,
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

        if ($request->hasFile('certifications')) {
            $rules['certifications'] = 'file|mimes:pdf,doc,docx|max:2048';
        }

        if ($request->hasFile('qualifications')) {
            $rules['qualifications'] = 'file|mimes:pdf,doc,docx|max:2048';
        }

        $data = $request->validate($rules);

        if ($request->hasFile('photo_profile')) {
            $data['photo_profile'] = $request->file('photo_profile')->store('profile', 'public');
        }
        if ($request->hasFile('photo_identite')) {
            $data['photo_identite'] = $request->file('photo_identite')->store('identite', 'public');
        }
        if ($request->hasFile('certifications')) {
            $data['certifications'] = $request->file('certifications')->store('certifications', 'public');
        }
        if ($request->hasFile('qualifications')) {
            $data['qualifications'] = $request->file('qualifications')->store('qualifications', 'public');
        }

        $moniteur->update($data);

        return redirect()->route('moniteurs.index')->with('success', 'Moniteur mis à jour avec succès');
    }

    public function destroy($id)
    {
        $moniteur = User::findOrFail($id);
        $moniteur->delete();

        return redirect()->route('moniteurs.index')->with('success', 'Moniteur supprimé avec succès');
    }
}
