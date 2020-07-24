<?php

namespace App\Http\Controllers;

use App\Models\EleccionAfp;
use Illuminate\Http\Request;

class EleccionAfpController extends Controller
{
    public function create(Request $request)
    {
        $result = EleccionAfp::_create($request->all());
        return response()->json($result);
    }

    public function get(Request $request)
    {
        return response()->json([]);
    }

    public function delete($id)
    {
        $afp = EleccionAfp::find($id);
        if ($afp->delete()) {
            return response()->json([
                'message' => 'Registro borrado correctamente'
            ]);
        }

        return response()->json([
            'message' => 'Error al borrar el registro'
        ], 400);
    }

    public function getAll(Request $request)
    {
        $usuario_id = $request->usuario_id;
        $fechas = [
            'desde' => $request->desde,
            'hasta' => $request->hasta,
        ];

        $result = EleccionAfp::_getAll($usuario_id, $fechas);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['message']
            ]);
        }

        return response()->json($result);
    }

    public function verFicha(EleccionAfp $eleccion_afp)
    {
        try {
            if ($eleccion_afp->empresa_id === 9) {
                $view = 'documents.eleccion-afp.rapel';
            } else if ($eleccion_afp->empresa_id === 14) {
                $view = 'documents.eleccion-afp.verfrut';
            } else {
                throw new \Exception();
            }

            $data = [
                'eleccion_afp' => $eleccion_afp,
                'trabajador' => $eleccion_afp->trabajador
            ];

            $pdf = \PDF::setOptions([
                'images' => true
            ])->loadView($view, $data);

            $filename = $eleccion_afp->trabajador->apellido_paterno . '-' . $eleccion_afp->trabajador->apellido_materno . '-' . $eleccion_afp->trabajador->rut . '-' . $eleccion_afp->empresa->nombre_corto . '-ELECCION-AFP.pdf';

            return $pdf->stream($filename);
        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ]);
        }
    }
}
