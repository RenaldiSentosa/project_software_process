<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class N8NApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = env('N8N_API_KEY');
        $headerKey = $request->header('X-API-KEY');

        if (empty($apiKey) || $apiKey !== $headerKey) {
            return response()->json(['error' => 'Unauthorized. Invalid API Key.'], 401);
        }

        return $next($request);
    }
}
