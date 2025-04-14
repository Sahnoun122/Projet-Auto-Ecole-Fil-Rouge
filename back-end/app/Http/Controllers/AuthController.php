<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photo_identite' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'type_permis' => 'required|string|max:255',
            'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'role' => 'required|in:admin,moniteur,candidat',
        ];

        if ($request->role === 'moniteur') {
            $rules['certifications'] = 'required|string|max:255';
            $rules['qualifications'] = 'required|string|max:255';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
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
            'password' => Hash::make($request->password),
        ];

        if ($request->role === 'moniteur') {
            $certificationsPath = $request->file('certifications')->store('certifications', 'public');
            $qualificationsPath = $request->file('qualifications')->store('qualifications', 'public');
            
            $userData['certifications'] = $certificationsPath;
            $userData['qualifications'] = $qualificationsPath;
        }

        $user = User::create($userData);

        Auth::login($user);

        switch ($user->role) {
            case 'admin':
                return redirect('/admin/dashboard')->with('success', 'Inscription réussie!');
            case 'moniteur':
                return redirect('/moniteur/dashboard')->with('success', 'Inscription réussie!');
            default:
                return redirect('/candidat/dashboard')->with('success', 'Inscription réussie!');
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'moniteur':
                    return redirect()->intended('/moniteur/dashboard');
                default:
                    return redirect()->intended('/candidat/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}