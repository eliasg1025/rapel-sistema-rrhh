<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivoPermiso extends Model
{
    protected $table = 'motivos_permisos';

    public static function findOrCreate(array $data)
    {
        try {
            $instance = self::where([
                'empresa_id' => $data['empresa_id'],
                'code' => $data['id']
            ])->first();

            if ( !$instance ) {
                $instance = new MotivoPermiso();
            }

            $instance->name = $data['name'];
            $instance->code = $data['id'];
            $instance->empresa_id = $data['empresa_id'];

            if ( $instance->save() ) {
                return $instance->id;
            }

            return 0;
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
