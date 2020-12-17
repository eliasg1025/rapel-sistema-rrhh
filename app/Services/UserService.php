<?php


namespace App\Services;


use App\Models\Modulo;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getRoles(Usuario $usuario)
    {
        return DB::table('rol_usuario')
            ->where('usuario_id', $usuario->id)
            ->get();
    }

    public function getRol(Usuario $usuario, Modulo $modulo)
    {
        $rol = DB::table('rol_usuario')
            ->where('usuario_id', $usuario->id)
            ->where('modulo_id', $modulo->id)
            ->first();

        $rol->modulo = $modulo;
        $rol->tipo = Rol::where([
            'id' => $rol->rol_id,
            'modulo_id' => $modulo->id,
        ])->first();

        return $rol;
    }
}
