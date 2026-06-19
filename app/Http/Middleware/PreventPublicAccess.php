<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventPublicAccess
{
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->getRequestUri();

        if (
            str_contains($uri, '/public/') ||
            str_contains($uri, 'index.php')
        ) {
            return redirect('/', 301);
        }

        return $next($request);
    }
}