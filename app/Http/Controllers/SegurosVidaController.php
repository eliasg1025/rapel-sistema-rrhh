<?php

namespace App\Http\Controllers;

use App\Models\SeguroVida;
use App\Models\Trabajador;
use App\Models\Usuario;
use App\Models\ZonaLabor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SegurosVidaController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();
        $trabajadorId = Trabajador::findOrCreate($data['trabajador']);
        $zonaLaborId = ZonaLabor::where([
            'code' => $data['zona_labor'],
            'empresa_id' => $data['empresa_id']
        ])->first()->id;

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
        $seguro->regimen_id = $data['regimen_id'];
        $seguro->zona_labor_id = $zonaLaborId;
        $seguro->fecha_documento = now()->toDateString();
        $seguro->save();

        return response()->json([
            'message'   => 'Guardado correctamente',
            'data'      => $seguro,
        ]);
    }

    public function get(Request $request)
    {
        $usuarioId = $request->get('usuario_id');
        $desde = $request->get('desde');
        $hasta = Carbon::parse($request->get('hasta'))->addDay();

        $rol = Usuario::find($usuarioId)->getRol('seguros-vida');

        $seguros = SeguroVida::with('usuario.trabajador', 'trabajador', 'empresa', 'zona_labor', 'regimen')
            ->whereBetween('created_at', [$desde, $hasta])
            ->when($rol->name !== 'ADMINISTRADOR', function($query) use ($usuarioId) {
                $query->where('usuario_id', $usuarioId);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'message' => 'Data obtenida correctamente',
            'data' => $seguros
        ]);
    }

    public function getTrabajadores(Request $request)
    {
        $query = $request->get('q');

        $terminos = explode(' ', $query);

        $trabajadores = SeguroVida::with('trabajador', 'empresa')->select('seguros_vida.*')
            ->join('trabajadores', 'trabajadores.id', '=', 'seguros_vida.trabajador_id');

        if ($query !== '') {
            foreach ($terminos as $termino) {
                $trabajadores->where(function($query) use ($termino) {
                    $query->where('trabajadores.rut', 'like', $termino . '%')
                        ->orWhere('trabajadores.nombre', 'like', $termino . '%')
                        ->orWhere('trabajadores.apellido_paterno', 'like', $termino . '%')
                        ->orWhere('trabajadores.apellido_materno', 'like', $termino . '%');
                });
            }
        }

        $trabajadores = $trabajadores->get();

        return response()->json([
            'message' => sizeof($trabajadores) === 0 ? 'No se encontraron resultados' : 'Se encontraron ' . sizeof($trabajadores) . ' coincidencia(s)',
            'data' => $trabajadores
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
