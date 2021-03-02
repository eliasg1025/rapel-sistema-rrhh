<?php

namespace App\Http\Controllers;

use App\Models\CorteRenovacionFotocheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CortesRenovacionesFotocheckController extends Controller
{
    public function get()
    {
        $cortes = CorteRenovacionFotocheck::with('usuario.trabajador')->orderBy('id', 'DESC')->get();

        return response()->json([
            'message' => 'Data obtenida correctamente',
            'data' => $cortes
        ]);
    }

    public function getUltimo(Request $request)
    {
        $corte = CorteRenovacionFotocheck::where('activo', true)->first();

        if ($corte) {
            $corte->usuario->trabajador;
        }

        return response()->json([
            'message' => 'Data obtenida correctamente',
            'data' => $corte
        ]);
    }

    public function create(Request $request)
    {
        try {
            $renovacionesIds = $request->get('renovaciones_ids');
            $usuarioId = $request->get('usuario_id');

            $corte = CorteRenovacionFotocheck::where('activo', true)->first();
            if (!$corte) {
                $corte = new CorteRenovacionFotocheck();
                $corte->fecha_hora_corte = now()->toDateTimeString();
                $corte->usuario_id = $usuarioId;
                $corte->save();
            }

            DB::table('renovaciones_fotocheck')
                ->whereIn('id', $renovacionesIds)
                ->update(['corte_renovacion_id' => $corte->id]);

            return response()->json([
                'message' => 'Corte realizado correctamente',
                'data' => $corte,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al asignar corte',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 400);
        }
    }

    public function terminarProceso(Request $request, $id)
    {
        try {
            $corte = CorteRenovacionFotocheck::find($id);

            DB::table('renovaciones_fotocheck')->where('corte_renovacion_id', $corte->id)->update(['estado' => 2]);

            $corte->activo = 0;
            $corte->save();

            return response()->json([
                'message' => 'Proceso terminado correctamente',
                'data' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al terminar informe',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 400);
        }
    }
}
