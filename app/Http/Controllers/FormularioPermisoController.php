<?php

namespace App\Http\Controllers;

use App\Models\FormularioPermiso;
use App\Helpers\DatosHoras;
use Illuminate\Http\Request;

class FormularioPermisoController extends Controller
{
    public function calcularHoras(Request $request)
    {
        $datos_horas = new DatosHoras(
            $request->fecha_hora_salida,
            $request->fecha_hora_regreso,
            $request->horario_entrada,
            $request->horario_salida,
            $request->refrigerio
        );

        $result = FormularioPermiso::calcularHoras($datos_horas);

        if ( isset($result['error']) ) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }

    public function create(Request $request)
    {
        $result = FormularioPermiso::_create($request->all());
        if (!$result['error']) {
            return response()->json($result);
        }

        return response()->json($result, 400);
    }
}
