<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario
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

    public function afp(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario
        ];

        switch ($usuario->afp) {
            case 1:
            case 2:
                return view('pages.afp', compact('data'));
            default:
                $nombre_modulo = 'elección de afp';
                return view('pages.no-acceso', compact('nombre_modulo'));
        }

        return view('pages.afp', compact('data'));
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

    public function atencionReseteoClave(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->reseteo_clave == 0 ) {
            $nombre_modulo = 'atencion de cambio de clave';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario
        ];

        return view('pages.atencion-reseteo-clave', compact('data'));
    }

    public function sanciones(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sanciones == 0 ) {
            $nombre_modulo = 'sanciones';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => 0,
            'submodule' => 'sanciones',
        ];

        return view('pages.sanciones', compact('data'));
    }

    public function editarSancion(Request $request, int $id)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sanciones == 0 ) {
            $nombre_modulo = 'sanciones';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => $id,
            'submodule' => 'sanciones'
        ];

        return view('pages.sanciones', compact('data'));
    }

    public function sancionesReportes(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sanciones == 0 ) {
            $nombre_modulo = 'sanciones';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => 0,
            'submodule' => 'reportes',
        ];

        return view('pages.sanciones', compact('data'));
    }

    public function sancionesDesvinculaciones(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sanciones == 0 ) {
            $nombre_modulo = 'sanciones';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => 0,
            'submodule' => 'desvinculaciones',
        ];

        return view('pages.sanciones', compact('data'));
    }

    public function usuarios(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');

        if ($usuario->rol !== 'admin' || $usuario->usuarios == 0) {
            $nombre_modulo = 'usuarios';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }
        $data = [
            'usuario' => $usuario,
            'submodule' => 'main'
        ];
        return view('pages.usuarios', compact('data'));
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
