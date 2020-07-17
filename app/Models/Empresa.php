<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';

    public $incrementing = false;

    public function getNombreCortoAttribute()
    {
        $nombre_corto = '';
        if ($this->empresa_id === 9) {
            $nombre_corto = 'RAPEL';
        } else if ($this->empresa_id === 15) {
            $nombre_corto = 'VERFRUT';
        } else {
            $nombre_corto = 'OTRO';
        }
        return $nombre_corto;
    }
}
