<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Afp extends Model
{
    protected $table = 'afps';

    public static function findOrCreate(array $data)
    {
        try {
            $afp = self::where([
                'empresa_id' => $data['empresa_id'],
                'code' => $data['id']
            ])->first();

            if ( !$afp ) {
                $afp = new Afp();
            }

            $afp->name = $data['name'];
            $afp->code = $data['id'];
            $afp->publico = $data['publico'];
            $afp->empresa_id = $data['empresa_id'];

            if ( $afp->save() ) {
                return $afp->id;
            }
            return 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
