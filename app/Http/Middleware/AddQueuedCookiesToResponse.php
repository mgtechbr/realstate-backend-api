<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse as Middleware;

class AddQueuedCookiesToResponse extends Middleware
{
    public function handle($request, Closure $next)
    {
        return parent::handle($request, $next);
    }
}
