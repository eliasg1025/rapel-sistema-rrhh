<?php

namespace App\Http\Controllers;

use App\Models\BonoRegla;
use Illuminate\Http\Request;

class BonosReglasController extends Controller
{
    public function create(Request $request)
    {
        $laborActividad = explode(" - ", $request->get('laborId'));

        $zona_id = $request->get('zonaId');
        $regimen_id = $request->get('regimenId');
        $etapa = $request->get('etapa');
        $variedad_id = $request->get('variedadId');
        $cuartel_id = $request->get('cuartelId');
        $unidad_medida_id = $request->get('unidadMedidaId');
        $labor_id = $laborActividad[0] ?? 0;
        $actividad_id = $laborActividad[1] ?? 0;
        $bono_id = $request->get('bonoId');
        $ciclo = $request->get('ciclo');
        $rut = $request->get('rut');

        $regla = new BonoRegla();
        $regla->regimen_id = $regimen_id;
        $regla->etapa = $etapa;
        $regla->zona_id = $zona_id;
        $regla->variedad_id = $variedad_id;
        $regla->cuartel_id = $cuartel_id;
        $regla->unidad_medida_id = $unidad_medida_id;
        $regla->actividad_id = $actividad_id;
        $regla->labor_id = $labor_id;
        $regla->ciclo = $ciclo;
        $regla->rut = $rut;
        $regla->bono_id = $bono_id;
        $regla->save();

        return response()->json([
            'message' => 'Regla creada correctamente',
            'data' => $regla
        ]);
    }

    public function getByBono($id)
    {
        $data = BonoRegla::where('bono_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'message' => 'Reglas obtenidas correctamente',
            'data' => $data
        ]);
    }

    public function delete($id)
    {
        $data = BonoRegla::where('id', $id)->first();
        $data->delete();

        return response()->json([
            'message' => 'Regla borrada corractamente',
            'data' => $id
        ]);
    }
}
