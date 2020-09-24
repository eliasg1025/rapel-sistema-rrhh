<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SancionesController extends Controller
{
    public function index(Request $request)
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

    public function editar(Request $request, int $id)
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

    public function reportes(Request $request)
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

    public function desvinculaciones(Request $request)
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

    public function supervisorSst(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sanciones == 0 ) {
            $nombre_modulo = 'sanciones';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => 0,
            'submodule' => 'supervisor-sst',
            'submenu' => 'sub1'
        ];

        return view('pages.sanciones', compact('data'));
    }

    public function analistaSst(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sanciones == 0 ) {
            $nombre_modulo = 'sanciones';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => 0,
            'submodule' => 'analista-sst',
            'submenu' => 'sub1'
        ];

        return view('pages.sanciones', compact('data'));
    }
}
