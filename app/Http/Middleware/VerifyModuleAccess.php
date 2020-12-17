<?php

namespace App\Http\Middleware;

use App\Models\Modulo;
use App\Services\ModuleService;
use App\Services\UserService;
use Closure;

class VerifyModuleAccess
{
    public UserService $userService;
    public ModuleService $moduleService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->moduleService = new ModuleService();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $moduleSlug)
    {
        $user = $request->session()->get('usuario');

        $module = $this->moduleService->findBySlug($moduleSlug);
        $rol = $this->userService->getRol($user, $module);

        if ( is_null($rol) ) {
            $nombre_modulo = $moduleSlug;
            return response()->view('pages.no-acceso', compact('nombre_modulo'));
        }
        
        $user->modulo_rol = $rol;
        $request->session()->put('usuario', $user);

        return $next($request);
    }
}
