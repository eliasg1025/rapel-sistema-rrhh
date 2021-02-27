<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenovacionFotocheckPost;
use App\Models\CorteRenovacionFotocheck;
use App\Models\MotivoFotocheck;
use App\Models\PlanillaManual;
use App\Models\RenovacionFotocheck;
use App\Models\Trabajador;
use App\Models\Usuario;
use App\Models\ZonaLabor;
use App\Services\RenovacionesFotocheckService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RenovacionesFotocheckController extends Controller
{
    public RenovacionesFotocheckService $renovacionesService;

    public function __construct()
    {
        $this->renovacionesService = new RenovacionesFotocheckService();
    }

    public function create(RenovacionFotocheckPost $request)
    {
        $result = $this->renovacionesService->create(
            $request->trabajador,
            $request->fecha_solicitud,
            $request->observacion,
            $request->regimen_id,
            $request->zona_labor_id,
            $request->empresa_id,
            $request->motivo_perdida_fotocheck_id,
            $request->color_fotocheck_id,
            $request->usuario_id
        );

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'message' => 'Registro ingresado correctamente',
            'data' => $result
        ]);
    }

    public function update(Request $request, $id)
    {
        $renovacion = RenovacionFotocheck::find($id);
        $estado = $renovacion->estado;
        $estado_documento = $request->estado_documento;

        if ($estado) {
            $renovacion->estado = $estado;
        }

        if ($estado_documento) {
            $renovacion->estado_documento = $estado_documento;
        }

        $renovacion->save();

        return response()->json([
            'message' => 'Registro actualizado correctamente',
            'data' => $renovacion
        ]);
    }

    public function delete(Request $request, $id)
    {
        $result = RenovacionFotocheck::find($id)->delete();

        return response()->json([
            'message' => 'Registro borrado correctamente',
            'data' => $result
        ]);
    }

    public function get(Request $request)
    {
        $usuarioId = $request->get('usuario_id');
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $rut = $request->get('rut');
        $tipo = $request->get('tipo');

        $rol = (Usuario::find($usuarioId))->getRol('registro-fotochecks');

        switch ($rol->name) {
            case 'ADMINISTRADOR':
                $renovacionesQuery = RenovacionFotocheck::with('trabajador', 'empresa', 'regimen', 'usuario.trabajador', 'color', 'motivo', 'zonaLabor');
                break;

            default:
                $renovacionesQuery = RenovacionFotocheck::with('trabajador', 'empresa', 'regimen', 'usuario.trabajador', 'color', 'motivo', 'zonaLabor')
                    ->where('usuario_id', $usuarioId);
                break;
        }

        $motivosConDescuento = MotivoFotocheck::where('costo', '>', 0)->get()->toArray();

        $motivosConDescuentoId = array_map(function($item) {
            return $item['id'];
        }, $motivosConDescuento);

        $trabajador = Trabajador::where('rut', $rut)->first();

        $renovaciones = $renovacionesQuery->whereBetween('fecha_solicitud', [$desde, $hasta])
            ->when($tipo === 'CON DESCUENTO', function($query) use ($motivosConDescuentoId) {
                $query->whereIn('motivo_perdida_fotocheck_id', $motivosConDescuentoId);
            })
            ->when($tipo === 'SIN DESCUENTO', function($query) use ($motivosConDescuentoId) {
                $query->whereNotIn('motivo_perdida_fotocheck_id', $motivosConDescuentoId);
            })
            ->when(!is_null($trabajador), function($query) use ($trabajador) {
                $query->where('trabajador_id', $trabajador->id);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'message' => 'Data obtenida',
            'data' => $renovaciones,
        ]);
    }

    public function getResumen(Request $request)
    {
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $tipo = $request->get('tipo');
        $empresaId = $request->get('empresa_id');
        $esCorte = $request->get('corte');

        $corte = CorteRenovacionFotocheck::where('activo', true)->first();

        if ($esCorte && !$corte) {
            return response()->json([
                'message' => 'Data obtenida',
                'data' => []
            ]);
        }

        $renovaciones = DB::table('renovaciones_fotocheck as rf')
            ->select(
                'rf.id',
                'rf.fecha_solicitud',
                'rf.observacion',
                't.rut',
                DB::raw("CONCAT(t.apellido_paterno, ' ', t.apellido_materno, ' ', t.nombre) as trabajador"),
                'cf.color',
                DB::raw("CONCAT(zl.code, ' ', zl.name) as zona_labor"),
                'mpf.descripcion as motivo',
                DB::raw("CONCAT(ts.apellido_paterno, ' ', ts.apellido_materno, ' ', ts.nombre) as solicitante"),
                'rf.estado',
                'rf.estado_documento'
            )
            ->join('trabajadores as t', 't.id', '=', 'rf.trabajador_id')
            ->join('colores_fotocheck as cf', 'cf.id', '=', 'rf.color_fotocheck_id')
            ->join('motivos_perdida_fotocheck as mpf', 'mpf.id', '=', 'rf.motivo_perdida_fotocheck_id')
            ->join('zona_labores as zl', 'zl.id', '=', 'rf.zona_labor_id')
            ->join('usuarios as u', 'u.id', '=', 'rf.usuario_id')
            ->join('trabajadores as ts', 'ts.id', '=', 'u.trabajador_id')
            ->where([
                'rf.empresa_id' => $empresaId,
            ])
            ->whereBetween('rf.fecha_solicitud', [$desde, $hasta])
            ->when($esCorte == false, function($query) {
                $query->whereNull('corte_renovacion_id');
            })
            ->when($esCorte == true, function($query) use ($corte) {
                $query->where('corte_renovacion_id', $corte->id);
            })
            ->when($tipo === 'CON DESCUENTO', function($query)  {
                $query->where('mpf.costo', '>', 0);
            })
            ->when($tipo === 'SIN DESCUENTO', function($query)  {
                $query->where('mpf.costo', '<=', 0);
            })
            ->get();

        return response()->json([
            'message' => 'Data obtenida',
            'data' => $renovaciones,
        ]);
    }

    public function createPlanillasManuales(Request $request)
    {
        $ids = $request->get('ids');
        $usuarioId = $request->get('usuario_id');

        $count = 0;
        foreach ($ids as $renovacionId) {
            $renovacion = RenovacionFotocheck::find($renovacionId);

            $planilla = DB::table('planillas_manuales')->updateOrInsert(
                ['tipo_entidad' => 'renovaciones_fotocheck', 'entidad_id' => $renovacion->id],
                [
                    'empresa_id' => $renovacion->empresa_id,
                    'regimen_id' => $renovacion->regimen_id,
                    'zona_labor_id' => $renovacion->zona_labor_id,
                    'trabajador_id' => $renovacion->trabajador_id,
                    'usuario_id' => $usuarioId,
                    'fecha_solicitud' => now()->toDateString(),
                ]
            );

            if ($planilla) {
                $count++;
            }
        }

        return response()->json([
            'message' => "Se han creado $count registros de planilla manual",
            'data' => [],
        ]);
    }
}
