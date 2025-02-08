<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImpersonateSecureMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_if(User::isImpersonating(), 403);

        return $next($request);
    }
}
