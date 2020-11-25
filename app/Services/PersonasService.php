<?php

namespace App\Services;

use Error;
use Illuminate\Support\Facades\DB;

class PersonasService
{
    public function create($id, $nombre, $apellidoPaterno, $apellidoMaterno, $fechaNacimiento = null, $sexo = null, $direccion = null)
    {
        DB::table('personas')->updateOrInsert(
            [
                'id' => $id,
            ],
            [
                'nombre' => $nombre,
                'apellido_paterno' => $apellidoPaterno,
                'apellido_materno' => $apellidoMaterno,
                'fecha_nacimiento' => $fechaNacimiento,
                'sexo' => $sexo,
                'direccion' => $direccion
            ]
        );

        return $id;
    }
}
