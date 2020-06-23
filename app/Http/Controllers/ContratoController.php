<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Empresa;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function verFichaIngreso(Contrato $contrato)
    {
        try {
            $trabajador = $contrato->trabajador;
            if ($contrato->empresa_id === 9) {
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

    public function generarPdf(Request $request)
    {
        $result = Contrato::generate_pdf($request->all());
        return response()->json($result);
    }

    public function registroMasivo(Request $request)
    {
        $result = Contrato::massive_record($request->all());
        return response()->json($result);
    }

    public function test(Request $request)
    {
        $result = Contrato::record($request->all());
        return response()->json($result);
    }
}
