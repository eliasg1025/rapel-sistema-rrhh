<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorteDocumentoTurecibo extends Model
{
    protected $table = 'cortes_turecibo';

    public static function getLast()
    {
        return self::orderBy('created_at', 'DESC')->first();
    }
}
