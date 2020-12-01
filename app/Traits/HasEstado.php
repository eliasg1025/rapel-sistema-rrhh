<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HasEstado
{
    public function getEstado()
    {
        $tipo_estado = DB::table('tipos_estados')->where('name', $this->table)->first();

        $estado =  DB::table('entidades_estados as ee')
            ->select(
                'e.id as id',
                'e.name as name',
                'e.color'
            )
            ->join('estados as e', [
                'e.id' => 'ee.estado_id',
                'e.tipo_estado_id' => 'ee.tipo_estado_id'
            ])
            ->where([
                'ee.tipo_estado_id' => $tipo_estado->id,
                'ee.entidad_id' => $this->id
            ])
            ->orderBy('ee.created_at', 'DESC')->first();

        return $estado;
    }

    public function setEstado($id): bool
    {
        $tipo_estado = DB::table('tipos_estados')->where('name', $this->table)->first();

        try {
            DB::table('entidades_estados')->insert([
                'estado_id' => $id,
                'tipo_estado_id' => $tipo_estado->id,
                'entidad_id' => $this->id,
                'created_at' => now()
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
