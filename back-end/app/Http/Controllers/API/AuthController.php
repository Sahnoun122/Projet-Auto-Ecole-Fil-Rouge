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
    
        return response()->json(['user' => $user], 201);
    }
    
    public function connecter(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        $user = User::where('email', $credentials['email'])->first();
    
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'token' => $token,
                'role' => $user->role,
            ]);
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
        $candidats = User::where('role', 'candidat')->get();
        return response()->json($candidats);
    }

    public function getMoniteurs()
    {
        $moniteurs = User::where('role', 'moniteur')->get();
        return response()->json($moniteurs);
    }
}