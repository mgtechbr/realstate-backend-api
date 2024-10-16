<?php

namespace App\Http\Exceptions;

use Exception;

class MaintenanceModeException extends Exception
{
    public function render($request)
    {
        return response()->view('errors.503', [], 503);
    }
}
