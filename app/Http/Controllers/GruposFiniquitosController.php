<?php

namespace App\Http\Controllers;

use App\Http\Requests\GruposFiniquitosPost;
use App\Models\Usuario;
use App\Models\ZonaLabor;
use App\Services\GruposFiniquitosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GruposFiniquitosController extends Controller
{
    public GruposFiniquitosService $gruposFiniquitosService;

    public function __construct()
    {
        $this->gruposFiniquitosService = new GruposFiniquitosService();
    }

    public function create(GruposFiniquitosPost $request)
    {
        $result = $this->gruposFiniquitosService->create(
            $request->usuario_id,
            $request->fecha_finiquito,
            $request->zona_labor,
            $request->ruta,
            $request->codigo_bus
        );

        return response()->json([
            'message' => 'Grupo creado correctamente',
            'data' => $result
        ]);
    }

    public function get(Request $request)
    {
        $usuarioId = $request->query('usuario_id');

        $result = $this->gruposFiniquitosService->get($usuarioId);

        return response()->json([
            'message' => 'Grupos obtenidos correctamente',
            'data' => $result
        ]);
    }

    public function update(Request $request, int $id)
    {
        $result = $this->gruposFiniquitosService->update(
            $id,
            $request->usuario_id,
            $request->fecha_finiquito,
            $request->zona_labor,
            $request->ruta,
            $request->codigo_bus
        );

        return response()->json([
            'message' => 'Grupo actualizado correctamente',
            'data' => $result
        ]);
    }

    public function find(Request $request, int $id)
    {
        $result = $this->gruposFiniquitosService->find($id);

        return response()->json([
            'message' => 'Grupo obtenido correctamente',
            'data' => $result
        ]);
    }

    public function delete(int $id)
    {
        $estadoId = 4;
        $result = $this->gruposFiniquitosService->changeState($estadoId, $id);

        return response()->json([
            'message' => 'Grupo borrado correctamente',
            'data' => $result
        ]);
    }

    public function getUsuariosZonas()
    {
        $result = DB::table('usuarios_zonas')->get();

        $result->transform(function($item) {
            $item->usuario = Usuario::with('trabajador')->where('id', $item->usuario_id)->first();
            $item->zona_labor = ZonaLabor::find($item->zona_labor_id);
            return $item;
        });

        return response()->json([
            'message' => 'Data obtenida correctamente',
            'data' => $result
        ]);
    }

    public function createUsuariosZonas(Request $request)
    {
        $usuarioId = $request->get('usuario_id');
        $zonaLaborName = $request->get('zona_labor');

        $zonaLabor = ZonaLabor::where('name', $zonaLaborName)->first();

        $exists = DB::table('usuarios_zonas')
            ->where('usuario_id', $usuarioId)
            ->orWhere('zona_labor_id', $zonaLabor->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Ya hay usuario o zona labor asignada',
                'data' => []
            ], 400);
        }

        DB::table('usuarios_zonas')->insert([
            'zona_labor_id' => $zonaLabor->id,
            'usuario_id' => $usuarioId
        ]);

        return response()->json([
            'message' => 'Usuario asignado correctamente',
            'data' => []
        ]);
    }

    public function deleteUsuariosZonas(Usuario $usuario, ZonaLabor $zonaLabor)
    {
        DB::table('usuarios_zonas')
            ->where('usuario_id', $usuario->id)
            ->where('zona_labor_id', $zonaLabor->id)
            ->delete();

        return response()->json([
            'message' => 'Borrado correctamente'
        ]);
    }

    public function changeState(Request $request, int $id)
    {
        $result = $this->gruposFiniquitosService->changeState($request->get('estado_id'), $id);

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }

    public function updateFiniquitos(Request $request, int $id)
    {
        $result = $this->gruposFiniquitosService->updateFiniquitos($id);

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }

    public function print(int $id)
    {
        $result = $this->gruposFiniquitosService->print($id);

        return response()->json($result);
    }
}
