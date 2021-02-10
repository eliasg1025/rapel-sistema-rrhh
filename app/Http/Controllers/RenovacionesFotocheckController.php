<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenovacionFotocheckPost;
use App\Models\MotivoFotocheck;
use App\Models\RenovacionFotocheck;
use App\Models\Usuario;
use App\Models\ZonaLabor;
use App\Services\RenovacionesFotocheckService;
use Illuminate\Http\Request;

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

        return response()->json([
            'message' => 'Registro ingresado correctamente',
            'data' => $result
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

        $renovaciones = $renovacionesQuery->whereBetween('fecha_solicitud', [$desde, $hasta])
            ->when($tipo === 'CON DESCUENTO', function($query) use ($motivosConDescuentoId) {
                $query->whereIn('motivo_perdida_fotocheck_id', $motivosConDescuentoId);
            })
            ->when($tipo === 'SIN DESCUENTO', function($query) use ($motivosConDescuentoId) {
                $query->whereNotIn('motivo_perdida_fotocheck_id', $motivosConDescuentoId);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'message' => 'Data obtenida',
            'data' => $renovaciones,
        ]);
    }
}
