<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Illuminate\Http\Request;

class FichaController extends Controller
{
    public function verFichaIngresoObrero($empresa, $rut)
    {
        $empresa_id = $empresa === 9 ? 1 : 2;

        switch ($empresa) {
            case '9':
                $empresa_id = 1;
                break;

            case '14':
                $empresa_id = 2;
                break;

            default:
                break;
        }

        $trabajador = Trabajador::where([
            'empresa_id' => $empresa_id,
            'rut' => $rut
        ])->first();

        $data = [
            'trabajador' => $trabajador
        ];

        if ($empresa_id === 1) {
            $pdf = \PDF::loadView('fichas-ingresos-obreros.rapel.contrato', $data);

            $filename = "rapel-{$rut}-contrato.pdf";

            return $pdf->stream($filename);
        } else {
            return response()->json([
                'message' => 'Ficha para verfrut aún no disponibles'
            ]);
        }
    }
}
