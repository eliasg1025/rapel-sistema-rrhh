<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $table = 'incidencias';

    public static function getCounterpartIncidence(Incidencia $incidence, string $type)
    {
        $search = strtoupper($type);
        $counterpart = self::where('name', 'like', '%' . $search . '%')
            ->where('name', 'like', '%' . $incidence->name . '%')
            ->first();

        if ($counterpart) {
            return $counterpart;
        }

        return $incidence;
    }
}
