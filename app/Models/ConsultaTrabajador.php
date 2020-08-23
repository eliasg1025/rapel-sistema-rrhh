<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaTrabajador extends Model
{
    public $table = 'consultas_trabajadores';

    public static function _create($data)
    {
        try {
            $consulta = new ConsultaTrabajador();
            $consulta->rut = $data['rut'];
            $consulta->activo = $data['activo'];
            $consulta->usuario_id = $data['usuario_id'];
            if ($consulta->save() )  {
                return [
                    'message' => 'Guardado correctamente'
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
