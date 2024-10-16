<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\View\Middleware\ShareErrorsFromSession as Middleware;

class ShareErrorsFromSession extends Middleware
{
    public function handle($request, Closure $next)
    {
        return parent::handle($request, $next);
    }
}
