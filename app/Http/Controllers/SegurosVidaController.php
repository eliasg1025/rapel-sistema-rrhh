<?php

namespace App\Http\Controllers;

use App\Models\SeguroVida;
use App\Models\Trabajador;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SegurosVidaController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();
        $trabajadorId = Trabajador::findOrCreate($data['trabajador']);

        $exists = SeguroVida::where([
                'trabajador_id' => $trabajadorId,
                'fecha_documento' => now()->toDateString()
            ])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Ya existe un registro de este trabajador para la fecha ' . now()->toDateString(),
                'data' => []
            ], 200);
        }

        $seguro = new SeguroVida();
        $seguro->empresa_id = $data['empresa_id'];
        $seguro->trabajador_id = $trabajadorId;
        $seguro->usuario_id = $data['usuario_id'];
        $seguro->fecha_documento = now()->toDateString();
        $seguro->save();

        return response()->json([
            'message' => 'Guardado correctamente',
            'data' => $trabajadorId,
        ]);
    }

    public function get(Request $request)
    {
        $usuarioId = $request->get('usuario_id');
        $desde = $request->get('desde');
        $hasta = Carbon::parse($request->get('hasta'))->addDay();

        $seguros = SeguroVida::with('usuario.trabajador', 'trabajador', 'empresa')
            ->whereBetween('created_at', [$desde, $hasta])
            ->where('usuario_id', $usuarioId)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'message' => 'Data obtenida correctamente',
            'data' => $seguros
        ]);
    }

    public function delete(Request $request, $id)
    {
        $seguro = SeguroVida::find($id);
        $seguro->delete();

        return response()->json([
            'message' => 'Registro borrado correctamente',
            'data' => $seguro
        ]);
    }
}
