<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NotificationController extends Controller
{
    public function unsubscribe(User $user, $token)
    {
        if (!Hash::check($user->id.$user->email, $token)) {
            abort(403, 'Lien de désinscription invalide');
        }

        $user->update(['email_notifications' => false]);

        return view('emails.unsubscribe-confirmation', [
            'user' => $user,
            'reactiverUrl' => route('email.resubscribe', [
                'user' => $user->id,
                'token' => Hash::make($user->id.$user->email)
            ])
        ]);
    }

    public function resubscribe(User $user, $token)
    {
        if (!Hash::check($user->id.$user->email, $token)) {
            abort(403, 'Lien de réactivation invalide');
        }

        $user->update(['email_notifications' => true]);

        return view('emails.resubscribe-confirmation', [
            'user' => $user
        ]);
    }
}