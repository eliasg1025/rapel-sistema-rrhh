<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiquidacionRechazo extends Model
{
    protected $table = 'liquidaciones_rechazos';

    public $incrementing = true;

    public $timestamps = false;
}
