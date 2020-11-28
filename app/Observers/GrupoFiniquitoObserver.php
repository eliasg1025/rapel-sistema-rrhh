<?php

namespace App\Observers;

use App\Models\GrupoFiniquito;
use Illuminate\Support\Facades\DB;

class GrupoFiniquitoObserver
{
    /**
     * Handle the grupo finiquito "created" event.
     *
     * @param  \App\Models\GrupoFiniquito  $grupoFiniquito
     * @return void
     */
    public function created(GrupoFiniquito $grupoFiniquito)
    {
        DB::table('entidades_estados')->insert([
            'estado_id' => 1,
            'tipo_estado_id' => 1,
            'entidad_id' => $grupoFiniquito->id,
            'created_at' => now()
        ]);
    }

    /**
     * Handle the grupo finiquito "updated" event.
     *
     * @param  \App\Models\GrupoFiniquito  $grupoFiniquito
     * @return void
     */
    public function updated(GrupoFiniquito $grupoFiniquito)
    {
        //
    }

    /**
     * Handle the grupo finiquito "deleted" event.
     *
     * @param  \App\Models\GrupoFiniquito  $grupoFiniquito
     * @return void
     */
    public function deleted(GrupoFiniquito $grupoFiniquito)
    {
        //
    }

    /**
     * Handle the grupo finiquito "restored" event.
     *
     * @param  \App\Models\GrupoFiniquito  $grupoFiniquito
     * @return void
     */
    public function restored(GrupoFiniquito $grupoFiniquito)
    {
        //
    }

    /**
     * Handle the grupo finiquito "force deleted" event.
     *
     * @param  \App\Models\GrupoFiniquito  $grupoFiniquito
     * @return void
     */
    public function forceDeleted(GrupoFiniquito $grupoFiniquito)
    {
        //
    }
}
