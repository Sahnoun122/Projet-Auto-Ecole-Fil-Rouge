<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'nom'           => 'required|string|max:255',
            'prenom'        => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'adresse'       => 'required|string|max:255',
            'telephone'     => 'required|string|max:20',
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg',
            'password'      =>['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'role'          => 'required|in:admin,moniteur,candidat'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // $identityPhoto = null ;
        // if ($request->hasFile('photo_identite')) {
        //     $identityPhoto = $request->file('photo_identite')->store('identite', 'public');
        // }

        $profilePhoto = null;
        if ($request->hasFile('photo_profile')) {
            $profilePhoto = $request->file('photo_profile')->store('profile', 'public');
        }

        // $diplomePath = null;
        // if ($request->hasFile('diplome')) {
        //     $diplomePath = $request->file('diplome')->store('diplome', 'public');
        // }

        $user = $this->authService->register([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'photo_profile' => $profilePhoto,
            'password' => $request->password,
            'role' => $request->role
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request)
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
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $this->authService->modifierMotDePasse($user, $request->password);
    
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
}