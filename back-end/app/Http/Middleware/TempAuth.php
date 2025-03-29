<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TempAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
                  $token = $request->bearerToken();
        
          if (!$token) {
              return response()->json([
                  'error' => 'Token d\'accès temporaire requis'
              ], 401);
          }
  
          $tokenRecord = DB::table('temp_tokens')
              ->where('token', $token)
              ->where('created_at', '>', now()->subHours(24))
              ->first();
  
          if (!$tokenRecord) {
              return response()->json([
                  'error' => 'Token invalide ou expiré'
              ], 401);
          }
  
          $request->merge([
              'user_id' => $tokenRecord->user_id
          ]);
  
          return $next($request);
        
    }
}
