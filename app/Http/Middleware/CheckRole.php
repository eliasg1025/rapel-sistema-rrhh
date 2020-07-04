<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $usuario = $request->get('user');

        if ($usuario->rol !== $role) {
            return response()->json([
                'message' => "No autorizado, tiene que tener rol de '{$role}'"
            ], 401);
        }

        return $next($request);
    }
}
