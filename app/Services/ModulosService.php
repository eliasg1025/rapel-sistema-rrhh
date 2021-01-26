<?php

namespace App\Services;

use App\Models\Modulo;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class ModulosService
{
    public function get()
    {
        return Modulo::all();
    }

    public function getByUser(Usuario $usuario)
    {
        $modulos = DB::table('rol_usuario as ru')
            ->select('m.*')
            ->join('modulos as m', 'm.id', '=', 'ru.modulo_id')
            ->where([
                'ru.usuario_id' => $usuario->id,
                'ru.activo' => 1,
            ])
            ->get();
        return $modulos;
    }
}
