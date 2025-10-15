<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1) Procesa la request normalmente
        $response = $next($request);

        // 2) Define el dominio del front (desde .env)
        $origin = env('FRONTEND_URL', 'http://localhost:5173');

        // 3) Agrega encabezados CORS básicos
        $response->headers->set('Access-Control-Allow-Origin', $origin);
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-CSRF-TOKEN, Authorization');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        // 4) Si es preflight (OPTIONS), respondé 204 vacío
        if ($request->getMethod() === 'OPTIONS') {
            $response->setStatusCode(204);
        }

        return $response;
    }
}
