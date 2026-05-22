<?php

namespace App\Routing;

use BackedEnum;
use Illuminate\Routing\UrlGenerator;

class TrailingSlashUrlGenerator extends UrlGenerator
{
    /**
     * Frontend route names that should have trailing slashes.
     */
    protected const FRONTEND_ROUTE_PREFIX = 'frontend.';

    /**
     * Additional route names that should have trailing slashes.
     */
    protected const FRONTEND_ROUTE_NAMES = [
        'home_default',
    ];

    /**
     * Get the URL to a named route.
     *
     * @param  string|\BackedEnum  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     *
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException|\InvalidArgumentException
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        $routeName = $name instanceof BackedEnum ? $name->value : $name;
        $url = parent::route($name, $parameters, $absolute);

        if (is_string($routeName) && $this->shouldAddTrailingSlash($routeName)) {
            return $this->addTrailingSlash($url);
        }

        return $url;
    }

    /**
     * Determine if the route should have a trailing slash.
     */
    protected function shouldAddTrailingSlash(string $name): bool
    {
        return str_starts_with($name, self::FRONTEND_ROUTE_PREFIX)
            || in_array($name, self::FRONTEND_ROUTE_NAMES, true);
    }

    /**
     * Add trailing slash to URL, preserving query string and fragment.
     */
    protected function addTrailingSlash(string $url): string
    {
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '/';

        if ($path === '/' || $path === '') {
            return $url;
        }

        if (str_contains(basename($path), '.')) {
            return $url;
        }

        $path = rtrim($path, '/') . '/';
        $result = ($parsed['scheme'] ?? '') . '://' . ($parsed['host'] ?? '') . $path;

        if (! empty($parsed['query'] ?? '')) {
            $result .= '?' . $parsed['query'];
        }

        if (! empty($parsed['fragment'] ?? '')) {
            $result .= '#' . $parsed['fragment'];
        }

        return $result;
    }
}
