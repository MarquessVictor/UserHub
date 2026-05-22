<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Área exclusiva pra quem tem role=user
        // Admin tentando entrar aqui leva um 403 — cada um no seu quadrado
        if (!auth()->check() || !auth()->user()->isUser()) {
            abort(403, 'Acesso negado.');
        }

        return $next($request);
    }
}
