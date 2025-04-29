<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckNotificationPreferences
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        
        if ($user && !$user->email_notifications) {
            return $next($request);
        }

        return $next($request);
    }
}