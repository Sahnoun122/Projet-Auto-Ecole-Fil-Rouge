<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MoniteurController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $monitors = User::where('role', 'moniteur')
            ->when($search, function($query) use ($search) {
                return $query->where('nom', 'like', "%$search%")
                             ->orWhere('prenom', 'like', "%$search%")
                             ->orWhere('email', 'like', "%$search%")
                             ->orWhere('telephone', 'like', "%$search%")
                             ->orWhere('type_permis', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('admin.monitors', compact('monitors'));
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

        $validated['photo_profile'] = $request->file('photo_profile')->store('monitors/profile', 'public');
        $validated['photo_identite'] = $request->file('photo_identite')->store('monitors/identite', 'public');
        $validated['certifications'] = $request->file('certifications')->store('monitors/certifications', 'public');
        $validated['qualifications'] = $request->file('qualifications')->store('monitors/qualifications', 'public');
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'moniteur';

        User::create($validated);

        return redirect()->route('admin.monitors.index')->with('success', 'Moniteur ajouté avec succès');
    }

    public function show($id)
    {
        $monitor = User::findOrFail($id);
        return response()->json($monitor);
    }

    public function edit($id)
    {
        $monitor = User::findOrFail($id);
        return response()->json($monitor);
    }

    public function update(Request $request, $id)
    {
        $monitor = User::findOrFail($id);

        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $monitor->id,
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
            Storage::disk('public')->delete($monitor->photo_profile);
            $data['photo_profile'] = $request->file('photo_profile')->store('monitors/profile', 'public');
        }
        if ($request->hasFile('photo_identite')) {
            Storage::disk('public')->delete($monitor->photo_identite);
            $data['photo_identite'] = $request->file('photo_identite')->store('monitors/identite', 'public');
        }
        if ($request->hasFile('certifications')) {
            Storage::disk('public')->delete($monitor->certifications);
            $data['certifications'] = $request->file('certifications')->store('monitors/certifications', 'public');
        }
        if ($request->hasFile('qualifications')) {
            Storage::disk('public')->delete($monitor->qualifications);
            $data['qualifications'] = $request->file('qualifications')->store('monitors/qualifications', 'public');
        }

        $monitor->update($data);

        return redirect()->route('admin.monitors.index')->with('success', 'Moniteur mis à jour avec succès');
    }

    public function destroy($id)
    {
        $monitor = User::findOrFail($id);
                Storage::disk('public')->delete([
            $monitor->photo_profile,
            $monitor->photo_identite,
            $monitor->certifications,
            $monitor->qualifications
        ]);
        
        $monitor->delete();

        return redirect()->route('admin.monitors.index')->with('success', 'Moniteur supprimé avec succès');
    }
}