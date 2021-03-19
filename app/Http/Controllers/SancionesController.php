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

    public function getUsuariosCarga(Request $request)
    {
        $fechas = [
            'desde' => date($request->desde),
            'hasta' => date($request->hasta)
        ];
        $estado = $request->estado;
        $incidencia_id = $request->incidencia_id;

        $result = Sancion::_getUsuariosCarga($fechas, $estado, $incidencia_id);

        return response()->json($result);
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
        $usuario_carga_id = $request->usuario_carga_id;

        $result = Sancion::_getAll($usuario_id, $fechas, $estado, $incidencia_id, $usuario_carga_id);

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
                'sancion'        => $sancion,
                'texto'          => json_decode($sancion->incidencia->texto)->texto,
                'trabajador'     => $sancion->trabajador,
                'codigo'         => 4 . '@' . $sancion->id,
            ];

            if ( $sancion->incidencia->documento === 'MIXTO' ) {
                $documentType = $sancion->reiterativo === 1 ? 'MEMORANDUM' : 'SUSPENCION';
            } else {
                $documentType = $sancion->incidencia->documento;
            }

            $template = 'documents.' . strtolower($documentType) . '.index';

            $pdf = \PDF::setOptions([
                'images' => true,
                'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true ,'chroot' => public_path()
            ])->loadView($template, $data);

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

    public function marcarSubido(Request $request, $id)
    {
        $usuario_id = $request->usuario_id;
        $result = Sancion::marcarSubido($usuario_id, $id);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['error']
            ], 400);
        }

        return response()->json($result);
    }

    public function delete($id)
    {
        $form = Sancion::find($id);

        if ($form->delete()) {
            return response()->json([
                'message' => 'Registro borrado correctamente'
            ]);
        }
        return response()->json([
            'message' => 'Error al borrar el registro'
        ], 400);
    }
}
