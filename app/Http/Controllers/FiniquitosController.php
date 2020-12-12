<?php

namespace App\Http\Controllers;

use App\Http\Requests\FiniquitosPost;
use App\Models\Finiquito;
use App\Models\Usuario;
use App\Services\FiniquitosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{File, Storage};

class FiniquitosController extends Controller
{
    public FiniquitosService $finiquitosService;


    public function __construct()
    {
        $this->finiquitosService = new FiniquitosService();
    }

    public function get(Request $request)
    {
        $tipo = $request->get('tipo');
        $usuarioId = $request->get('usuario_id');
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');

        $rol = (Usuario::find($usuarioId))->getRol('finiquitos');

        switch ($rol->name) {
            case 'ADMINISTRADOR':
                $finiquitos = Finiquito::with('persona', 'empresa', 'tipoCese', 'regimen', 'oficio', 'usuario.trabajador')
                    ->where('grupo_finiquito_id', null)
                    ->whereBetween('fecha_finiquito', [$desde, $hasta])
                    ->orderBy('regimen_id', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                break;

            default:
                $finiquitos = Finiquito::with('persona', 'empresa', 'tipoCese', 'regimen', 'oficio', 'usuario.trabajador')
                    ->where('grupo_finiquito_id', null)
                    ->where('usuario_id', $usuarioId)
                    ->whereBetween('fecha_finiquito', [$desde, $hasta])
                    ->orderBy('regimen_id', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                break;
        }

        $finiquitos->transform(function ($item) {
            $item->estado = $item->getEstado();
            return $item;
        });

        return response()->json([
            'message' => 'Data obtenida',
            'data' => $finiquitos
        ]);
    }

    public function create(FiniquitosPost $request)
    {
        try {
            ["personaId" => $personaId, "oficioId" => $oficioId] = $this->finiquitosService->prepare($request);

            $result = $this->finiquitosService->create(
                $request->empresa_id,
                $personaId,
                $request->tipo_cese_id,
                $request->grupo_finiquito_id,
                $request->fecha_inicio_periodo,
                $request->fecha_termino_contrato,
                $request->regimen_id,
                $oficioId,
                $request->usuario_id,
                $request->fecha_finiquito,
                $request->zona_labor,
                $request->id
            );

            if (isset($result['error'])) {
                return response()->json($result, 400);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear finiquito',
                'data' => $e->getMessage(),
                'error' => true
            ], 400);
        }
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        $grupoFiniquitoId = $request->get('grupo_finiquito_id');
        $fechaFiniquito = $request->get('fecha_finiquito');
        $usuarioId = $request->get('usuario_id');
        $name = '/tmp/' . now()->unix() . '.' . $file->getClientOriginalExtension();

        if (!Storage::disk('public')->put($name, File::get($file))) {
            return response()->json(['message' => 'Error al guardar el archivo'], 400);
        }

        $result = $this->finiquitosService->import($name, $fechaFiniquito, $grupoFiniquitoId, $usuarioId);

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }

    public function delete(int $id)
    {
        $finiquito = Finiquito::find($id);

        $finiquito->delete();

        return response()->json([
            'message' => 'Finiquito borrado correctamente',
            'data' => $id
        ]);
    }
}
