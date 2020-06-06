<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';

    public function departamento()
    {
        return $this->belongsTo('App\Models\Departamento');
    }
}
