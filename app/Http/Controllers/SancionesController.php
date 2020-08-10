<?php

namespace App\Http\Controllers;

use App\Models\Sancion;
use Illuminate\Http\Request;

class SancionesController extends Controller
{
    public function show($id)
    {
        $result = Sancion::_show($id);
        /*
        if (!$result) {
            return response()->json(['message' => 'Formulario no existe'], 404);
        }*/
        return response()->json($result);
    }

    public function create(Request $request)
    {
        $result = Sancion::_create($request->all());
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
        $incidencia_id = $request->incidencia_id;

        $result = Sancion::_getAll($usuario_id, $fechas, $estado, $incidencia_id);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['message']
            ], 400);
        }

        return response()->json($result);
    }

    public function verFicha(Sancion $sancion)
    {
        try {
            $data = [
                'sancion'     => $sancion,
                'trabajador'     => $sancion->trabajador,
                'codigo'         => 4 . '@' . $sancion->id,
            ];

            $pdf = \PDF::setOptions([
                'images' => true
            ])->loadView('documents.' . strtolower($sancion->incidencia->documento) . '.index', $data);

            $filename = $sancion->trabajador->apellido_paterno . '-' . $sancion->trabajador->apellido_materno . '-' . $sancion->trabajador->rut . '-' . $sancion->empresa->nombre_corto . '-' . $sancion->documento . '.pdf';

            return $pdf->stream($filename);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ]);
        }
    }

    public function marcarEnviado(Request $request, $id)
    {
        $usuario_id = $request->usuario_id;
        $result = Sancion::marcarEnviado($usuario_id, $id);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['message']
            ], 400);
        }

        return response()->json($result);
    }

    public function delete($id)
    {
        $form = Sancion::find($id);

        if ( $form->delete() ) {
            return response()->json([
                'message' => 'Registro borrado correctamente'
            ]);
        }
        return response()->json([
            'message' => 'Error al borrar el registro'
        ], 400);
    }
}
