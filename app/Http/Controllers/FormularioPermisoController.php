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

    public function getAll(Request $request)
    {
        $usuario_id = $request->usuario_id;
        $fechas = [
            'desde' => $request->desde,
            'hasta' => $request->hasta
        ];
        $estado = $request->estado;

        $result = FormularioPermiso::_getAll($usuario_id, $fechas, $estado);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['message']
            ], 400);
        }

        return response()->json($result);
    }

    public function toggleGoce(int $id)
    {
        $form = FormularioPermiso::find($id);
        $form->goce = !$form->goce;
        if ($form->save()) {
            return response()->json([
                'goce' => $form->goce
            ]);

        }

        return response()->json([
            'goce' => $form->goce
        ], 400);
    }

    public function verFicha(FormularioPermiso $formularioPermiso)
    {
        try {
            $data = [
                'formulario' => $formularioPermiso,
                'trabajador' => $formularioPermiso->trabajador,
            ];

            $pdf = \PDF::setOptions([
                'images' => true
            ])->loadView('documents.formulario-permiso.index', $data);

            $filename = $formularioPermiso->trabajador->apellido_paterno . '-' . $formularioPermiso->trabajador->apellido_materno . '-' . $formularioPermiso->trabajador->rut . '-' . $formularioPermiso->empresa->nombre_corto . '-FORMULARIO-PERMISO.pdf';

            return $pdf->stream($filename);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ]);
        }
    }
}
