<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';

    public static function _create(array $data=[])
    {
        $existe_trabajador = self::where('rut', $data['rut'])->exists();

        if ($existe_trabajador) {
            return 'Ya existe';
        } else {
            return 'No existe';
        }
    }
}
