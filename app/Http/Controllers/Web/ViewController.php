<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ModulosService;
use App\User;
use Illuminate\Http\Request;


class ViewController extends Controller
{
    public ModulosService $modulosService;

    public function __construct()
    {
        $this->modulosService = new ModulosService();
    }

    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $data = [
            'usuario'   => $usuario,
            'modulos'   => $this->modulosService->get()
        ];
        return view('pages.panel', compact('data'));
    }

    public function login(Request $request)
    {
        if ($request->session()->has('usuario'))
            return redirect('/');
        return view('pages.login');
    }

    public function perfil(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario
        ];

        return view('pages.perfil', compact('data'));
    }

    public function permisos(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->permisos == 0 ) {
            $nombre_modulo = 'formularios de permiso';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => 0
        ];

        return view('pages.permisos', compact('data'));
    }

    public function editarPermiso(Request $request, int $id)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->permisos == 0 ) {
            $nombre_modulo = 'formularios de permiso';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => $id
        ];

        return view('pages.permisos', compact('data'));
    }

    public function consultaTrabajadores(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->consultas_trabajadores == 0 ) {
            $nombre_modulo = 'consultas de trabajadores';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'consulta'
        ];

        return view('pages.consultas-trabajadores', compact('data'));
    }

    public function historialConsultaTrabajadores(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->consultas_trabajadores == 0 ) {
            $nombre_modulo = 'consultas de trabajadores';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'historial-busqueda'
        ];

        return view('pages.consultas-trabajadores', compact('data'));
    }
}
