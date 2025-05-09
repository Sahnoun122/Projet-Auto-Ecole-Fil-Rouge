<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Notifications\CustomResetPassword;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Str;

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
            'type_permis' => 'required|string|max:255',
            'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
            'role' => 'required|in:admin,moniteur,candidat',
        ];

        if ($request->role === 'candidat') {
            $rules['avez_vous_permis'] = 'required|boolean'; 

            if ($request->input('avez_vous_permis') == '0') {
                $rules['photo_identite'] = 'required|file|mimes:pdf|max:2048';
            }
            else {
                $rules['photo_identite'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            }
        } elseif ($request->role === 'moniteur') {
            $rules['certifications'] = 'required|file|mimes:pdf,doc,docx|max:2048';
            $rules['qualifications'] = 'required|file|mimes:pdf,doc,docx|max:2048';
            $rules['photo_identite'] = 'required|image|mimes:jpeg,png,jpg|max:2048'; 
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
                return redirect('/candidats/dashboard')->with('success', 'Inscription réussie!');
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
                    return redirect()->intended('/candidats/dashboard');
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

        return redirect('/login');
    }



    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token)
    {
        $email = request()->query('email'); 
        return view('auth.reset-password', ['token' => $token, 'email' => request()->email]);
    }
    

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


    public function showMoniteur()
    {
        $moniteurs = User::where('role', 'moniteur')->get();
        return view('admin.moniteurs', compact('moniteurs'));
    }

    public function addMoniteur(Request $request)
    {
        $rules = $this->getMoniteurValidationRules();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $this->saveMoniteurData($request);

        return redirect()->route('admin.moniteurs.index')->with('success', 'Moniteur ajouté avec succès.');
    }

    private function getMoniteurValidationRules()
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photo_identite' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'type_permis' => 'required|string|max:255',
            'certifications' => 'required|string|max:255',
            'qualifications' => 'required|string|max:255',
            'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
        ];
    }

    private function saveMoniteurData(Request $request)
    {
        $profilePhotoPath = $request->file('photo_profile')->store('profile', 'public');
        $identityPhotoPath = $request->file('photo_identite')->store('identite', 'public');
        $certificationsPath = $request->file('certifications')->store('certifications', 'public');
        $qualificationsPath = $request->file('qualifications')->store('qualifications', 'public');

        $userData = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'photo_profile' => $profilePhotoPath,
            'photo_identite' => $identityPhotoPath,
            'type_permis' => $request->type_permis,
            'role' => 'moniteur',
            'password' => Hash::make($request->password),
            'certifications' => $certificationsPath,
            'qualifications' => $qualificationsPath,
        ];

        return User::create($userData);
    }


    public function editMoniteur($id)
    {
        $moniteur = User::findOrFail($id);
        return view('admin.moniteurs.edit', compact('moniteur'));
    }

    public function updateMoniteur(Request $request, $id)
    {
        $rules = $this->getMoniteurValidationRules();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $moniteur = User::findOrFail($id);
        $this->updateMoniteurData($request, $moniteur);

        return redirect()->route('admin.moniteurs.index')->with('success', 'Moniteur modifié avec succès.');
    }

    private function updateMoniteurData(Request $request, User $moniteur)
    {
        $moniteur->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'type_permis' => $request->type_permis,
            'password' => Hash::make($request->password),
            'certifications' => $request->certifications,
            'qualifications' => $request->qualifications,
        ]);
    }


    public function deleteMoniteur($id)
    {
        $moniteur = User::findOrFail($id);
        $moniteur->delete();
        return redirect()->route('admin.moniteurs.index')->with('success', 'Moniteur supprimé avec succès.');
    }


}
