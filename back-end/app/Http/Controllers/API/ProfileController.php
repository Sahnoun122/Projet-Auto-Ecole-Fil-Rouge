<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'photo_profile_url' => $user->profile_photo_url,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::class()->user();

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type_permis' => $user->isCandidat() ? 'required|string' : 'nullable',
            'certifications' => $user->isMoniteur() ? 'required|string' : 'nullable',
            'Qualifications' => $user->isMoniteur() ? 'required|string' : 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('photo_profile');

        if ($request->hasFile('photo_profile')) {
            if ($user->photo_profile) {
                Storage::delete($user->photo_profile);
            }
            $path = $request->file('photo_profile')->store('profile-photos');
            $data['photo_profile'] = $path;
        }

        $user->update($data);

        return response()->json([
            'message' => 'Profil mis à jour avec succès',
            'user' => $user,
            'photo_profile_url' => $user->profile_photo_url,
        ]);
    }
}