<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportacionFiniquito extends Model
{
    protected $table = 'importaciones_finquitos';

    public function observaciones()
    {
        return $this->hasMany(ObservacionImportacionFiniquito::class, 'importacion_finiquito_id');
    }
}
