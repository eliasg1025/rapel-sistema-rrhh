<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Troncal extends Model
{
    protected $table = 'troncales';

    public static function findOrCreate(array $data=[])
    {
        try {
            $troncal = Troncal::where([
                'code' => $data['id'],
                'empresa_id' => $data['empresa_id']
            ])->first();

            if ($troncal) {
                return $troncal->id;
            }

            $troncal = new Troncal();
            $troncal->code = $data['id'];
            $troncal->empresa_id = $data['empresa_id'];
            $troncal->name = $data['name'];

            if ($troncal->save()) {
                return $troncal->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
