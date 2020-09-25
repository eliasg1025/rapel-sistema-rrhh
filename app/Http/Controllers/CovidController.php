<?php

namespace App\Http\Controllers;

use App\Models\SqlSrv\Covid;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CovidController extends Controller
{
    public function get(Request $request)
    {
        $usuario = $request->query('usuario');
        $result = Covid::get($usuario);

        return response()->json($result);
    }

    public function getEstados(Request $request)
    {
        $usuario_id = $request->query('usuario_id');
        $result = Covid::getEstadosCovid($usuario_id, [0, 1]); // PENDIENTE - INVALIDO

        return response()->json($result);
    }

    public function getEstadosAnalista(Request $request)
    {
        $usuario_id = $request->query('usuario_id');
        $result = Covid::getEstadosCovid($usuario_id, [3, 4]); // PARA ANALISTA - INVALIDO

        return response()->json($result);
    }

    public function sync(Request $request)
    {
        $usuario = Usuario::find($request->get('usuario')['id']);

        if ( $usuario->sanciones === 2 ) {
            $casos = Covid::get();
        } else if ( $usuario->sanciones === 3 ) {
            $casos = Covid::get($usuario->username);
        }

        $result = Covid::sync($casos);

        return response()->json($result);
    }

    public function toggleValido(Request $request, $tipo)
    {
        $ids = $request->get('ids');

        $result = Covid::toggleValido($tipo, $ids);

        return response()->json($result);
    }

    public function terminarProceso(Request $request)
    {
        $ids = $request->get('ids');

        $result = Covid::terminarProceso($ids);

        return response()->json($result);
    }

    public function getSupervisoresSst()
    {
        $result = Covid::getSupervisoresSst();

        return response()->json($result);
    }

    public function generarSanciones(Request $request)
    {
        $result = Covid::generarSanciones($request->get('data'));

        return response()->json($result);
    }
}
