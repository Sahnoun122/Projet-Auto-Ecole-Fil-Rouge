<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthViews extends Controller
{
    public function VuConnecter()
    {
        return view('auth.connecter');
    }

    public function VuRegister()
    {
        return view('auth.register');
    }

  
}

