<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Se não tiver logado ou não for admin, nem chega no controller
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Acesso negado.');
        }

        return $next($request);
    }
}
