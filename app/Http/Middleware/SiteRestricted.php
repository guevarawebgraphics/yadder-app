<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteRestricted
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $isRestricted = config('yadder.site.restricted');

        if (!$isRestricted) {

            if ($request->routeIs('restricted.index') || $request->routeIs('restricted.post')){
                return redirect()->route('login');
            }

            return $next($request);
        }

        if ($request->cookie('restricted_verified')) {
            return $next($request);
        }

        if ($request->routeIs('restricted.index') || $request->routeIs('restricted.post')) {
            return $next($request);
        }

        return to_route('restricted.index');
    }
}
