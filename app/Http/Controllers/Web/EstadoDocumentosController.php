<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstadoDocumentosController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->estado_documentos == 0 ) {
            $nombre_modulo = 'estado de documentos';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        if ( $usuario->estado_documentos == 1 ) {
            return redirect('/estado-documentos/boletas');
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main'
        ];

        return view('pages.estado-documentos', compact('data'));
    }

    public function boletas(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->estado_documentos == 0 ) {
            $nombre_modulo = 'estado de documentos';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'boletas'
        ];

        return view('pages.estado-documentos', compact('data'));
    }

    public function prorrogas(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->estado_documentos == 0 ) {
            $nombre_modulo = 'estado de documentos';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'prorrogas'
        ];

        return view('pages.estado-documentos', compact('data'));
    }
}
