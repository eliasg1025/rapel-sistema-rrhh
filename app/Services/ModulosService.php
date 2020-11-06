<?php

namespace App\Services;

use App\Models\Modulo;


class ModulosService
{
    public function get($query = [])
    {
        return Modulo::all();
    }
}
