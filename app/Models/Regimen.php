<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regimen extends Model
{
    protected $table = 'regimenes';

    public $incrementing = false;

    public static function findOrCreate(array $data=[])
    {
        try {
            $regimen = Regimen::find($data['id']);

            if ($regimen) {
                return $regimen->id;
            }

            $regimen = new Regimen();
            $regimen->id = $data['id'];
            $regimen->name = $data['name'];

            if ($regimen->save()) {
                return $regimen->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
