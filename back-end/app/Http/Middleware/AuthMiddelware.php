<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        if ($role && (!$request->user() || $request->user()->role !== $role)) {
            abort(403, 'Accès non autorisé.');
        }

        if (!$role && !$request->user()) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}