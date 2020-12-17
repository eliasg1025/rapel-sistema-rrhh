<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModulosController extends Controller
{
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
}
