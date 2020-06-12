<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function verFichaIngreso(Contrato $contrato)
    {
        try {
            $trabajador = $contrato->trabajador;
            if ($contrato->empresa->code === "9") {
                $data = [
                    'trabajador' => $trabajador,
                    'contrato' => $contrato
                ];

                $pdf = \PDF::setOptions([
                    'images' => true
                ])->loadView('fichas-ingresos-obreros.rapel.contrato', $data);

                $filename = $trabajador->apellido_paterno . '-' . $trabajador->apellido_materno . '-' . $trabajador->rut . '-FICHA.pdf';

                return $pdf->stream($filename);
            } else {
                throw new \Exception();
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function test(Contrato $contrato)
    {
        try {
            $contrato->trabajador;
            if ($contrato->empresa->code === "9") {
                return response()->json([
                    'data' => $contrato
                ]);
            } else {
                throw new \Exception();
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ficha aún no disponible'
            ]);
        }
    }
}
