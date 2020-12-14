<?php

namespace App\Observers;

use App\Models\Finiquito;
use Illuminate\Support\Facades\DB;

class FiniquitoObserver
{
    /**
     * Handle the finiquito "created" event.
     *
     * @param  \App\Models\Finiquito  $finiquito
     * @return void
     */
    public function created(Finiquito $finiquito)
    {
        DB::table('entidades_estados')->updateOrInsert(
            [
                'estado_id' => 1,
                'tipo_estado_id' => 2,
                'entidad_id' => $finiquito->id
            ],
            [
                'estado_id' => 1,
                'tipo_estado_id' => 2,
                'entidad_id' => $finiquito->id,
                'created_at' => now()
            ]
        );
    }

    /**
     * Handle the finiquito "updated" event.
     *
     * @param  \App\Models\Finiquito  $finiquito
     * @return void
     */
    public function updated(Finiquito $finiquito)
    {
        //
    }

    /**
     * Handle the finiquito "deleted" event.
     *
     * @param  \App\Models\Finiquito  $finiquito
     * @return void
     */
    public function deleted(Finiquito $finiquito)
    {
        DB::table('entidades_estados')->where([
            'tipo_estado_id' => 2,
            'entidad_id' => $finiquito->id
        ])->delete();
    }

    /**
     * Handle the finiquito "restored" event.
     *
     * @param  \App\Models\Finiquito  $finiquito
     * @return void
     */
    public function restored(Finiquito $finiquito)
    {
        //
    }

    /**
     * Handle the finiquito "force deleted" event.
     *
     * @param  \App\Models\Finiquito  $finiquito
     * @return void
     */
    public function forceDeleted(Finiquito $finiquito)
    {
        //
    }
}
