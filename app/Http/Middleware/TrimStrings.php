<?php

namespace App\Http\Middleware;

use Closure;

class TrimStrings
{
    public function handle($request, Closure $next)
    {
        $request->merge(array_map('trim', $request->all()));
        return $next($request);
    }
}
