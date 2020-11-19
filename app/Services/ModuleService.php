<?php


namespace App\Services;


use App\Models\Modulo;

class ModuleService
{
    public function findBySlug($slug)
    {
        return Modulo::where('slug', $slug)->first();
    }
}
