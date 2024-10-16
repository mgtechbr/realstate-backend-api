<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Exceptions\MaintenanceModeException;

class CheckForMaintenanceMode
{
    public function handle($request, Closure $next)
    {
        if (app()->isDownForMaintenance()) {
            throw new MaintenanceModeException;
        }

        return $next($request);
    }
}
