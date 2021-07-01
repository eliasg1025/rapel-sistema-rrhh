<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Rol;
use App\Models\Usuario;
use App\Services\ModulosService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModulosController extends Controller
{
    public ModulosService $modulosService;

    public function __construct()
    {
        $this->modulosService = new ModulosService();
    }

    public function getUsuarios(Request $request, Modulo $modulo)
    {
        $rolName = $request->query('rol');

        if ($rolName) {
            $rol = Rol::where([
                'name' => $rolName,
                'modulo_id' => $modulo->id
            ])->first();

            $usuarios = DB::table('rol_usuario')
                ->where('rol_id', $rol->id)
                ->where('modulo_id', $modulo->id)
                ->get();
        } else {
            $usuarios = DB::table('rol_usuario')
                ->where('modulo_id', $modulo->id)
                ->get();
        }

        $usuarios->transform(function($item) {
            $item->usuario = Usuario::with('trabajador')->where('id', $item->usuario_id)->first();

            return $item;
        });

        return response()->json([
            'message' => 'Data obtenida',
            'data' => $usuarios
        ]);
    }

    public function getHabilitado(Request $request)
    {
        $slug = $request->get('modulo_slug');
        $modulo = $this->modulosService->findBySlug($slug);

        $habilitado = $modulo->habilitado;

        return response()->json([
            'message'   => 'Data obtenida',
            'data'      => [
                'habilitado' => $habilitado
            ]
        ]);
    }

    public function habilitar(Request $request)
    {
        $slug = $request->get('modulo_slug');
        $value = $request->get('value');
        $modulo = $this->modulosService->findBySlug($slug);

        $modulo->habilitado = $value;
        $modulo->save();

        return response()->json([
            'message'   => 'Data obtenida',
            'data'      => [
                'habilitado' => $modulo->habilitado
            ]
        ]);
    }
}
