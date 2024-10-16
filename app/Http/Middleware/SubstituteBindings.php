<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\SubstituteBindings as Middleware;

class SubstituteBindings extends Middleware
{
    public function handle($request, Closure $next)
    {
        return parent::handle($request, $next);
    }
}
