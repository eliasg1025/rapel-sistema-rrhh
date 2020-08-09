<?php

namespace App\Http\Controllers;

use App\Models\Sancion;
use Illuminate\Http\Request;

class SancionesController extends Controller
{
    public function create(Request $request)
    {
        $result = Sancion::_create($request->all());
        if (!$result['error']) {
            return response()->json($result);
        }

        return response()->json($result, 400);
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
}
