<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';

    public function getNombreCompletoAttribute($value)
    {
        return $this->apellido_paterno . ' ' . $this->apellido_materno . ' ' . $this->nombre;
    }
}
