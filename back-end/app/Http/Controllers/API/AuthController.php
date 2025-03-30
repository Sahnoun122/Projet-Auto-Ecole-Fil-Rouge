<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg',
            'photo_identite' => 'required|image|mimes:jpeg,png,jpg',
            'type_permis' => 'required|string|max:255',
            'role' => 'required|in:admin,moniteur,candidat',
            'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'certifications' => 'nullable|string', 
            'qualifications' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
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
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ];
    
        if ($request->role == 'moniteur') {
            $userData['certifications'] = $request->certifications;
            $userData['qualifications'] = $request->qualifications;
        }
    
        $user = User::create($userData);

        
        // $token = JWTAuth::fromUser($user);

        // return response()->json(compact('user','token'), 201);
    
        return response()->json(['user' => $user], 201);
    }


        public function connecter(Request $request)
        {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
    
            $credentials = $request->only('email', 'password');
            
            if ($token = JWTAuth::attempt($credentials)) {
                return response()->json(['token' => $token]);
            }
    
            return response()->json(['message' => 'Unauthorized'], 401);
        }
 
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $user->password = bcrypt($request->password);
        $user->save();
    
        return response()->json(['message' => 'Password reset successfully']);
    }
    
    public function refresh(Request $request)
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json(['token' => $token]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token refresh failed'], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to logout, please try again.'], 500);
        }
    }
    public function getCandidats()
    {
        return User::where('role', 'candidat')
                  ->orderBy('created_at', 'desc')
                  ->get([ 'nom', 'prenom', 'email', 'telephone', 'photo_profile', 'created_at']);
    }

    public function getMoniteurs()
    {
        return User::where('role', 'moniteur')
                  ->orderBy('created_at', 'desc')
                  ->get([ 'nom', 'prenom', 'email', 'certifications', 'photo_profile', 'created_at']);
    }

       public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg',
            'photo_identite' => 'nullable|image|mimes:jpeg,png,jpg',
            'type_permis' => 'nullable|string|max:255',
            'role' => 'required|in:admin,moniteur,candidat',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('photo_profile')) {
            $user->photo_profile = $request->file('photo_profile')->store('profile', 'public');
        }

        if ($request->hasFile('photo_identite')) {
            $user->photo_identite = $request->file('photo_identite')->store('identite', 'public');
        }

        $user->save();

        return response()->json(['message' => 'Utilisateur mis à jour avec succès']);
    }

    public function deleteUser($id)
{
    $user = User::find($id);
    
    if (!$user) {
        return response()->json(['message' => 'Utilisateur non trouvé'], 404);
    }

    Storage::disk('public')->delete($user->photo_profile);
    Storage::disk('public')->delete($user->photo_identite);

    $user->delete();

    return response()->json(['message' => 'Utilisateur supprimé avec succès']);
}


public function searchUsers(Request $request)
{
    $request->validate([
        'role' => 'required|in:candidat,moniteur',
        'search' => 'nullable|string|max:255',
        'per_page' => 'nullable|integer|min:1|max:100'
    ]);

    $perPage = $request->per_page ?? 15;

    return User::query()
        ->where('role', $request->role)
        ->when($request->search, function ($query) use ($request) {
            $searchTerm = "%{$request->search}%";
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nom', 'like', $searchTerm)
                  ->orWhere('prenom', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm);
              
            });
        })
        ->paginate($perPage);
}
}