<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json(['message' => 'API Key is missing.'], 401);
        }

        $user = User::where('api_key', $apiKey)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid API Key.'], 401);
        }

        // Authenticate the user for this request
        Auth::login($user);

        return $next($request);
    }
}
