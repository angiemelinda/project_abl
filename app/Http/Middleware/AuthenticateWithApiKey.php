<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWithApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (! $apiKey) {
            return response()->json(['message' => 'API Key tidak ditemukan.'], 401);
        }

        $keyExists = ApiKey::where('key', $apiKey)->exists();

        if (! $keyExists) {
            return response()->json(['message' => 'API Key tidak valid.'], 401);
        }

        return $next($request);
    }
}

