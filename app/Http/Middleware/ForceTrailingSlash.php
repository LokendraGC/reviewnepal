<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceTrailingSlash
{
    public function handle(Request $request, Closure $next)
    {
        $path = $request->getPathInfo();

        // Only handle GET requests
        if (!$request->isMethod('get')) {
            return $next($request);
        }

        // Skip Livewire routes
        if (str_contains($path, 'livewire')) {
            return $next($request);
        }

        // Skip if already has trailing slash, is a file, or is root
        if (
            $path !== '/' &&
            !str_ends_with($path, '/') &&
            !str_contains(basename($path), '.')
        ) {
            $newUrl = rtrim($request->url(), '/') . '/';

            if ($request->getQueryString()) {
                $newUrl .= '?' . $request->getQueryString();
            }

            return redirect($newUrl, 301);
        }

        return $next($request);
    }
}
