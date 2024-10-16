<?php

namespace App\Http\Middleware;

use Closure;

class ConvertEmptyStringsToNull
{
    public function handle($request, Closure $next)
    {
        $request->merge(array_map(function ($value) {
            return $value === '' ? null : $value;
        }, $request->all()));

        return $next($request);
    }
}
