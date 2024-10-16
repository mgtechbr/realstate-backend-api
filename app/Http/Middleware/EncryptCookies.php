<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    protected function encrypt($value)
    {
        return encrypt($value);
    }

    protected function decrypt($value)
    {
        return decrypt($value);
    }
}
