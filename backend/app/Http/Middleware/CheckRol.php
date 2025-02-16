<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRol
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!session()->has('roles') || !in_array($role, session('roles'))) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
